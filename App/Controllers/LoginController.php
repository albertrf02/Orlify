<?php

namespace App\Controllers;

class LoginController
{

    function login($request, $response, $container)
    {
        $user = $request->get(INPUT_POST, "email");
        $password = $request->get(INPUT_POST, "password");

        $model = $container->get("users");
        $login = $model->login($user, $password);

        if ($login) {
            $response->setSession("logged", true);
            $response->setSession("user", $login);
            $response->redirect("Location: /");
        } else {
            $response->setSession("logged", false);
            $response->setSession("error", "Usuari o contrasenya incorrectes");
            $response->redirect("Location: /login");
        }

        return $response;
    }

    function logout($request, $response, $container)
    {

        $response->setSession("logged", false);
        $response->setSession("user", []);
        $response->redirect("Location: /");

        return $response;
    }

}

