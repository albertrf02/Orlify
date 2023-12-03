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

    public function admin($request, $response, $container)
    {

        $model = $container->get("users");
        $allUsers = $model->getAllUsers();

        $countUsers = 6;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $countUsers;
        $users = array_slice($allUsers, $start, $countUsers);
        $totalPages = ceil(count($allUsers) / $countUsers);

        $response->set("users", $users);
        $response->set("currentPage", $page);
        $response->set("totalPages", $totalPages);

        $response->SetTemplate("AdminView.php");
        return $response;
    }

    public function perfil($request, $response, $container)
    {
        $userId = $_SESSION["user"]["id"];
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

        $response->SetTemplate("PerfilView.php");
        return $response;
    }

    function recover($request, $response, $container)
    {
        $response->SetTemplate("Recover.php");
        return $response;
    }


    function invalidtoken($request, $response, $container)
    {
        $time = $request->get("SESSION", "time");
        $response->set("time", $time);
        $response->SetTemplate("InvalidToken.php");
        return $response;
    }

    function recoverpassword($request, $response, $container)
    {
        $token = $request->getParam("token");

        $userModel = $container->get("users");
        $valid = $userModel->isValidToken($token);
        $time = $userModel->CheckTime($token);

        if($valid == "true"){
            $response->setTemplate("RecoverPassword.php");
            return $response;

        }else{
            $response->setSession("time", $time);
            $response->redirect("Location: /invalidtoken");
            return $response;
        }  
    }
}

