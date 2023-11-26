<?php

namespace App\Controllers;

class ViewsController
{
    public function index($request, $response, $container)
    {
        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("index.php");
        return $response;
    }

    public function login($request, $response, $container)
    {
        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("login.php");
        return $response;
    }

    public function register($request, $response, $container)
    {
        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("register.php");
        return $response;
    }

    public function admin($request, $response, $container) {
        $model = $container->get("users");
    
        // Obtén todos los usuarios
        $allUsers = $model->getAllUsers();

        $roles = $model->getRoles();
    
        // Cantidad de usuarios a mostrar por página
        $countUsers = 9;
    
        // Página actual, predeterminada a 1 si no está definida o es incorrecta
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
    
        // Calcula el índice de inicio basado en la página actual y la cantidad de usuarios por página
        $start = ($page - 1) * $countUsers;
    
        // Obtiene los usuarios para la página actual
        $users = array_slice($allUsers, $start, $countUsers);
    
        // Calcula el número total de páginas
        $totalPages = ceil(count($allUsers) / $countUsers);
    
        // Configura las variables para la vista
        $response->set("users", $users);
        $response->set("roles", $roles);
        $response->set("currentPage", $page);
        $response->set("totalPages", $totalPages);


    
        $response->SetTemplate("AdminView.php");
        return $response;
    }
    
}

