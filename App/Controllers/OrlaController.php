<?php

namespace App\Controllers;

class OrlaController
{

    /**
     * Agafa els usuaris d'una orla
     *
     * @param \Emeset\Http\Request $request petició HTTP
     * @param \Emeset\Http\Response $response resposta HTTP
     * @param \Emeset\Container $container  
     * 
     * @return \Emeset\Http\Response resposta HTTP
     */
    public function getUsersFromOrla($request, $response, $container)
    {
        $orlesModel = $container->get("orles");
        $idOrla = $_GET["idOrla"];

        $usersInOrla = $orlesModel->getUserFromGroupInOrla($idOrla);
        $placeholderImage = 'img/placeholder.jpg';

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


    /**
     * Guarda les dades de l'orla a la base de dades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP després de processar les dades de l'orla.
     */
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

    /**
     * Comprova si la connexió és segura utilitzant HTTPS o el port 443.
     *
     * @return bool Retorna true si la connexió és segura, si no retorna fals.
     */
    private function isSecure()
    {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    /**
     * Obté el contingut HTML per renderitzar la vista d'una orla.
     *
     * @param int $idOrla Identificador de l'orla.
     * @param \Emeset\Container $container
     *
     * @return string Contingut HTML de la vista d'una orla.
     */
    private function getRenderHTML($idOrla, $container)
    {
        $orlesModel = $container->get("orles");

        $orlaUsers = $orlesModel->getOrlaById($idOrla);

        if ($this->isSecure()) {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

        $server = $protocol . $_SERVER['SERVER_NAME'];

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
        $htmlContent = $twig->render('orla.html.twig', ['role1Users' => $role1Users, 'role2Users' => $role2Users, 'server' => $server]);
        return $htmlContent;
    }

    /**
     * Mostra la vista d'una orla amb l'identificador d'orla proporcionat.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la vista d'una orla.
     */
    public function viewOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $response->setTemplate("orlaRenderedView.php");
        $response->set("idOrla", $idOrla);

        return $response;
    }

    /**
     * Genera i retorna el contingut HTML d'una orla per a ser utilitzat en un iframe.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb el contingut HTML per a l'iframe.
     */
    public function iframeOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $htmlContent = $this->getRenderHTML($idOrla, $container);
        $response->setBody($htmlContent);
        return $response;
    }

    /**
     * Genera un fitxer PDF a partir del contingut HTML de la vista d'una orla.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return void No retorna res, ja que el resultat és un fitxer PDF que s'envia al navegador.
     */
    public function orlaToPDF($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $htmlContent = $this->getRenderHTML($idOrla, $container);

        //TODO get orla name from db
        $orlaName = "orlaName";

        $papersize = isset($_GET["paperFormat"]) ? $_GET["paperFormat"] : "A4";

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        // instantiate and use the dompdf class
        $dompdf = new \Dompdf\Dompdf($options);

        $dompdf->loadHtml($htmlContent);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($papersize, 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    /**
     * Mostra la vista d'edició d'una orla amb l'identificador d'orla proporcionat.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container 
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la vista d'edició de l'orla.
     */
    public function editOrla($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];

        $response->set("idOrla", $idOrla);
        $response->SetTemplate("editorOrlesView.php");
        return $response;
    }

    /**
     * Obté les dades d'una orla associada a una classe mitjançant una sol·licitud POST.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb les dades de l'orla o un missatge d'error.
     */
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