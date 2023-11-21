<?php

use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;

/**
 * Controlador que gestiona el procés de login
 * Framework d'exemple per a M07 Desenvolupament d'aplicacions web.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Comprova si l'usuari s'ha autentificat correctament
 *
 **/

/**
 * ctrlValidarLogin: Controlador que comprova si l'usuari s'ha autentificat
 * correctament
 *
 * @param $request contingut de la peticó http.
 * @param $response contingut de la response http.
 * @param $container  paràmetres de configuració de l'aplicació
 *
 **/
function ctrlValidarLogin(Request $request, Response $response, Container $container) :Response
{
    $email = $request->get(INPUT_POST, "email");
    $password = $request->get(INPUT_POST, "password");

    $model = $container->get("users");
    $login = $model->login($email, $password);

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
