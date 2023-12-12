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

        $countUsers = 9;
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

    public function orlaEditor($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $response->set("idOrla", $idOrla);
        $response->SetTemplate("editorOrlesView.php");

        return $response;
    }

    public function equipDirectiu($request, $response, $container)
    {

        $modelUsers = $container->get("users");
        $modelOrles = $container->get("orles");

        $allGroups = $modelUsers->getClassGroups();
        $allOrles = $modelOrles->getOrles();

        $response->set("groups", $allGroups);

        $classNames = [];

        foreach ($allOrles as $orla) {
            $idOrla = $orla["id"];
            $className = $modelOrles->getClassByOrlaId($idOrla);
            $classNames[$idOrla] = $className;
        }

        $response->set("classNames", $classNames);
        $response->set("orles", $allOrles);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "createOrla") {
                $name = $_POST["name"];
                $group = $_POST["group"];
                $idCreator = $_SESSION["user"]["id"];

                $idOrla = $modelOrles->createOrla($name, $group, $idCreator);

                header("Location: /orla/edit?idOrla=" . $idOrla);
            }

        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "deleteReport") {
                $modelUsers->deleteReportAndPhoto($_GET['report_id']);

                header("Location: /equipDirectiu");
            }

            if ($action === "deleteOrla") {
                $idOrla = $_GET['idOrla'];
                $modelOrles->deleteOrla($idOrla);

                header("Location: /equipDirectiu");
            }

            if ($action === "activateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOn($idOrla);

                header("Location: /equipDirectiu");
            }

            if ($action === "deactivateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOff($idOrla);

                header("Location: /equipDirectiu");
            }
        }

        $reportedImages = $modelUsers->getReportedImages();

        $response->set("reportedImages", $reportedImages);
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

            if ($action === "setPorfilePhoto") {
                $userModel->setPorfilePhoto($userId, $_POST['avatar']);


                header("Location: /perfil");
            }
        }

        $avatars = $userModel->getAvatars();

        $user = $userModel->getUserById($userId);
        $userPhotos = $userModel->getPhotos($userId);
        $defaultPhoto = $userModel->getDefaultPhoto($userId);
        $userOrla = $userModel->getOrlaFromClassByUserId($userId);

        $response->set("user", $user);
        $response->set("userPhotos", $userPhotos);
        $response->set("defaultPhoto", $defaultPhoto);
        $response->set("avatars", $avatars);
        $response->set("userOrla", $userOrla);

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
        $response->SetTemplate("InvalidToken.php");
        return $response;
    }

    function recoverpassword($request, $response, $container)
    {
        date_default_timezone_set('Europe/Madrid');

        $token = $request->getParam("token");

        $userModel = $container->get("users");
        $valid = $userModel->isValidToken($token);
        $time = $userModel->getTokenExpiration($token);

        $currentTime = date('Y-m-d H:i:s');

        if ($valid && $currentTime < $time) {
            $errorpass = $request->get("SESSION", "errorpass");
            $response->set("errorpass", $errorpass);
            $response->set("token", $token);
            $response->setTemplate("RecoverPassword.php");
            return $response;

        } else {
            $response->redirect("Location: /invalidtoken");
            return $response;
        }
    }

}

