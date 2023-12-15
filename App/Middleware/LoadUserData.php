<?php

namespace App\Middleware;

class LoadUserData {
    public static function loadUserData($request, $response, $container, $next)
    {

        $user = $request->get("SESSION", "user");
        $logged = $request->get("SESSION", "logged");

        if (!isset($logged)) {
            $user = "";
            $logged = false;
        }

        // si l'usuari està logat permetem carregar el recurs
        if ($logged) {
            $userModel = $container->get("users");

            $email = $request->get("SESSION", "user")["email"];
            $user = $userModel->getUser($email);

            $response->set("user", $user);
            $response->set("logged", $logged);
        }

        $response = \Emeset\Middleware::next($request, $response, $container, $next);
        
        return $response;
    }
}