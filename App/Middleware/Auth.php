<?php

namespace App\Middleware;

class Auth
{

    /**
     * Middleware que gestiona l'autenticació
     *
     * @param \Emeset\Http\Request $request petició HTTP
     * @param \Emeset\Http\Response $response resposta HTTP
     * @param \Emeset\Container $container  
     * @param callable $next  següent middleware o controlador.   
     * @return \Emeset\Http\Response resposta HTTP
     */
    public static function auth($request, $response, $container, $next)
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
            $response = \Emeset\Middleware::next($request, $response, $container, $next);
        } else {
            $response->redirect("location: /login");
        }

        return $response;
    }

    public static function admin($request, $response, $container, $next)
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

            if ($user["role"] == "4") {
                $response = \Emeset\Middleware::next($request, $response, $container, $next);
            } else {
                $response->redirect("location: /");
            }
        } else {
            $response->redirect("location: /login");
        }

        return $response;
    }

    public static function equipDirectiu($request, $response, $container, $next)
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

            if ($user["role"] == "3") {
                $response = \Emeset\Middleware::next($request, $response, $container, $next);
            } else {
                $response->redirect("location: /");
            }
        } else {
            $response->redirect("location: /login");
        }

        return $response;
    }

    public static function professor($request, $response, $container, $next)
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

            if ($user["role"] == "2") {
                $response = \Emeset\Middleware::next($request, $response, $container, $next);
            } else {
                $response->redirect("location: /");
            }
        } else {
            $response->redirect("location: /login");
        }

        return $response;
    }

    public static function alumne($request, $response, $container, $next)
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

            if ($user["role"] == "1") {
                $response = \Emeset\Middleware::next($request, $response, $container, $next);
            } else {
                $response->redirect("location: /");
            }
        } else {
            $response->redirect("location: /login");
        }

        return $response;
    }
}