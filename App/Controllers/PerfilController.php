<?php

namespace App\Controllers;

class PerfilController
{
    public function perfil($request, $response, $container)
    {
        $response->SetTemplate("PerfilView.php");

        $userId = $_SESSION["user"]["Id"];
        $userModel = $container->get("users");

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "setDefaultPhoto") {
                $userModel->setDefaultPhoto($userId, $_POST['idPhoto']);
            }
        }

        $user = $userModel->getUserById($userId);
        $userPhotos = $userModel->getPhotos($userId);

        $response->set("user", $user);
        $response->set("userPhotos", $userPhotos);

        return $response;
    }
}
