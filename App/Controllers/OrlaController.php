<?php

namespace App\Controllers;

class OrlaController
{
    public function getUsersFromOrla($request, $response, $container)
    {
        $orlesModel = $container->get("orles");
        $idOrla = $_GET["idOrla"];

        $usersInOrla = $orlesModel->getUserFromGroupInOrla($idOrla);
        $placeholderImage = 'img/placeholder.jpg';

        // Transform the array
        $usersInOrlaMap = [];
        foreach ($usersInOrla as $item) {
            $usersInOrlaMap[$item['id']] = [
                'name' => $item['name'] . ' ' . $item['surname'],
                'picture' => $item['defaultPicture'] ?? $placeholderImage,
                'role' => $item['role'],
                'isInOrla' => $item['isInOrla'] ?? false
            ];
        }

        $response->setJSON();
        $response->setBody(json_encode($usersInOrlaMap));

        return $response;
    }

    public function saveOrla($request, $response, $container)
    {
        $orlesModel = $container->get("orles");

        //1. Obtindre i parsejar el JSON de la orla
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "saveOrla") {
                $usersOrla = $_POST["orlaValues"];
                $idOrla = $_POST["idOrla"];
                $usersOrla = json_decode($usersOrla, true);

                //2. Esborrar els usuaris que estiguin a la orla
                $orlesModel->deleteUsersFromOrla($idOrla);
                //3. Guardar els usuaris a la orla
                $orlesModel->addUsersToOrla($idOrla, $usersOrla);

                $response->redirect("Location: /orla/view?idOrla=" . $idOrla);
            }
        }

        //4. redirigir a la vista de la orla

        return $response;
    }

    private function getRenderHTML($idOrla, $container)
    {
        // TODO add db logic to get the data from the orla
        $orlesModel = $container->get("orles");

        $orlaUsers = $orlesModel->getOrlaById($idOrla);

        $role1Users = [];
        $role2Users = [];

        foreach ($orlaUsers as &$user) {
            if ($user['role'] == 1) {
                array_push($role1Users, $user);
            } elseif ($user['role'] == 2) {
                array_push($role2Users, $user);
            }
        }

        // Specify our Twig templates location
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../twigTemplates/orla');

        // Instantiate our Twig
        $twig = new \Twig\Environment($loader);

        // Render our view
        $htmlContent = $twig->render('orla.html.twig', ['role1Users' => $role1Users, 'role2Users' => $role2Users]);
        return $htmlContent;
    }

    public function viewOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $response->setTemplate("orlaRenderedView.php");
        $response->set("idOrla", $idOrla);

        return $response;
    }

    public function iframeOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $htmlContent = $this->getRenderHTML($idOrla, $container);
        $response->setBody($htmlContent);
        return $response;
    }

    public function orlaToPDF($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $htmlContent = $this->getRenderHTML($idOrla, $container);

        //TODO get orla name from db
        $orlaName = "orlaName";

        // Execute wkhtmltopdf command
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w")   // stderr
        );

        $papersize = isset($_GET["paperFormat"]) ? $_GET["paperFormat"] : "A4";

        $process = proc_open("wkhtmltopdf --orientation Landscape --page-size $papersize - -", $descriptorspec, $pipes);

        if (is_resource($process)) {
            // Pass HTML content to wkhtmltopdf via stdin
            fwrite($pipes[0], $htmlContent);
            fclose($pipes[0]);

            // Read the output from stdout
            $pdfContent = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Close the process
            $return_value = proc_close($process);

            // Send the generated PDF to the client
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . $orlaName . '.pdf');
            header('Content-Length: ' . strlen($pdfContent));
            flush(); // Flush system output buffer
            echo $pdfContent;
        }
    }

    public function editOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];

        $response->set("idOrla", $idOrla);
        $response->SetTemplate("editorOrlesView.php");
        return $response;
    }

    public function getOrlaByClass($request, $response, $container)
    {
        $idClass = $request->get(INPUT_POST, "idClass");

        $model = $container->get("orles");
        $orla = $model->getOrlaByClassId($idClass);

        if (!empty($orla)) {
            $response->set('orla', $orla);
            $response->setJSON();
        } else {
            $response->set('error', 'error');
            $response->setJSON();
        }

        return $response;
    }

}