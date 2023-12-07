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
                'name' => $item['name'] . ' ' . $item['surname'], // Combining first and last name
                'picture' => $item['defaultPicture'] ?? $placeholderImage, // Use default picture if available, else placeholder
                'isInOrla' => $item['isInOrla'] ?? false // Use isInOrla if available, else false
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

                var_dump($usersOrla);
                var_dump($idOrla);
            }
        }

        //4. redirigir a la vista de la orla

        return $response;
    }

}