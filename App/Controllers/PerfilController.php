<?php

namespace App\Controllers;

class PerfilController
{
    public function perfil($request, $response, $container)
        {
            $response->SetTemplate("PerfilView.php");

            $userId = $_SESSION["user"]["Id"];

            $userModel = $container->get("users");
            $user = $userModel->getUserById($userId);
            $userPhotos = $userModel->getPhotos($userId);
            
            $response->set("user", $user);
            $response->set("userPhotos", $userPhotos);
            
            
            
            
            // error_log(print_r($userPhotos, true));
            // var_dump($_SESSION);

            return $response;
        }
}
