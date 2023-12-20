<?php

namespace App\Controllers;

class LoginController
{

    /**
     * Gestiona el procés d'inici de sessió amb les credencials proporcionades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades de l'usuari (email i contrasenya).
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar l'estat de la sessió i redirigir.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que pot redirigir a la pàgina d'inici o mostrar un missatge d'error.
     */
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

    /**
     * Funció de tancament de sessió.
     *
     * @param \Emeset\Http\Request $request petició HTTP
     * @param \Emeset\Http\Response $response resposta HTTP
     * @param \Emeset\Container $container  
     * 
     * @return \Emeset\Http\Response resposta HTTP
     *
     */

    function logout($request, $response, $container)
    {
        $response->setSession("logged", false);
        $response->setSession("user", null);
        $response->redirect("Location: /");

        return $response;
    }

    /**
     * Gestiona el procés de registre d'usuaris amb les dades proporcionades.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les dades del formulari de registre.
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar el redirigiment després del registre.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que redirigeix a la pàgina d'inici o a la pàgina d'administrador segons el tipus de registre.
     */

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

