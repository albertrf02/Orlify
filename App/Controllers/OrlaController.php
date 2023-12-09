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

                header("Location: /equipDirectiu");
                var_dump($usersOrla);
                var_dump($idOrla);
            }
        }

        //4. redirigir a la vista de la orla

        return $response;
    }

    private function getRenderHTML($idOrla)
    {
        // Specify our Twig templates location
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../twigTemplates/orla');

        // Instantiate our Twig
        $twig = new \Twig\Environment($loader);

        // Sample data
        $foo = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Eve'],
        ];

        // Render our view
        $htmlContent = $twig->render('orla.html', ['foo' => $foo]);
        return $htmlContent;
    }

    public function displayOrla($request, $response, $container)
    {
        $response->setBody($this->getRenderHTML(1));

        return $response;
    }

    public function orlaToPDF($request, $response, $container)
    {
        $htmlContent = $this->getRenderHTML(1);

        // Execute wkhtmltopdf command
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w")   // stderr
        );

        $papersize = 'A4';

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
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="download.pdf"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($pdfContent));
            flush(); // Flush system output buffer
            echo $pdfContent;
            exit;
        }
    }

}