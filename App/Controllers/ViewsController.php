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

    public function equipDirectiu($request, $response, $container)
    {

        $modelUsers = $container->get("users");
        $modelOrles = $container->get("orles");

        $allGroups = $modelUsers->getClassGroups();
        $allOrles = $modelOrles->getOrles();

        $response->set("groups", $allGroups);
        $response->set("orles", $allOrles);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST["name"];
            $group = $_POST["group"];
            $idCreator = $_SESSION["user"]["id"];

            $postOrla = $modelOrles->createOrla($name, $group, $idCreator);

            $response->set("postOrla", $postOrla);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "deleteReport") {
                $modelUsers->deleteReportAndPhoto($_GET['report_id']);

                header("Location: /equipDirectiu");
            }
        }

        $reportedImages = $modelUsers->getReportedImages();

        $response->set("reportedImages", $reportedImages);

        $modelOrles = $container->get("orles");

        $response->SetTemplate("equipDirectiuView.php");
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

                header("Location: /perfil");
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "setDefaultPhoto") {
                $userModel->setDefaultPhoto($userId, $_POST['avatar']);

                header("Location: /perfil");
            }
        }

        $user = $userModel->getUserById($userId);
        $userPhotos = $userModel->getPhotos($userId);
        $defaultPhoto = $userModel->getDefaultPhoto($userId);

        $response->set("user", $user);
        $response->set("userPhotos", $userPhotos);
        $response->set("defaultPhoto", $defaultPhoto);

        $response->SetTemplate("PerfilView.php");
        return $response;
    }

}

