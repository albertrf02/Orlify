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
            $response->redirect("Location: /home");
        } else {
            $response->setSession("logged", false);
            $response->setSession("error", "Usuari o contrasenya incorrectes");
            $response->redirect("Location: /");
        }

        return $response;
    }

    function logout($request, $response, $container)
    {

        $response->setSession("logged", false);
        $response->setSession("user", null);
        $response->redirect("Location: /");

        return $response;
    }


    function register($request, $response, $container)
    {
        $form = $request->get(INPUT_POST, "formType");
        $name = $request->get(INPUT_POST, "name");
        $lastname = $request->get(INPUT_POST, "lastname");
        $username = $request->get(INPUT_POST, "username");
        $password = $request->get(INPUT_POST, "password");
        $email = $request->get(INPUT_POST, "email");
        $role = $request->get(INPUT_POST, "role");

        $model = $container->get("users");

        $role = $role ?? NULL;


        $hashPassword = $model->hashPassword($password);
        $register = $model->register($name, $lastname, $username, $hashPassword, $email, $role);

        if ($form === 'userRegistration') {
            $response->redirect("Location: /");
        } else if ($form === 'adminRegistration') {
            $response->redirect("Location: /admin");

        }
        return $response;
    }

}

