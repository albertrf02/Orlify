<?php

namespace App\Controllers;

class ViewsController
{
    /**
     * Controlador para la página principal de la aplicación.
     *
     * @param \Emeset\Http\Request $request Objeto de solicitud HTTP.
     * @param \Emeset\Http\Response $response Objeto de respuesta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objeto de respuesta HTTP con datos para la plantilla.
     */

    public function index($request, $response, $container)
    {
        $modelOrles = $container->get("orles");
        $allOrles = $modelOrles->getPublicOrlesAndClass();
        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("index.php");
        $response->set("orles", $allOrles);
        return $response;
    }

    /**
     * Controlador per a la pàgina d'inici de sessió.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla i possiblement un missatge d'error.
     */
    public function login($request, $response, $container)
    {

        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("login.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina de registre d'usuaris.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla i possiblement un missatge d'error.
     */
    public function register($request, $response, $container)
    {

        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("register.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina d'administració.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
    public function admin($request, $response, $container)
    {

        $model = $container->get("users");
        $model2 = $container->get("classes");
        $allUsers = $model->getAllUsers();
        $roles = $model->getRoles();
        $classes = $model2->getClasses();
        $activeClasses = $model2->getActiveClasses();
        $students = $model->getStudent();
        $professors = $model->getTeacher();

        $countUsers = 12;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $countUsers;
        $users = array_slice($allUsers, $start, $countUsers);
        $totalPages = ceil(count($allUsers) / $countUsers);

        $response->set("students", $students);
        $response->set("professors", $professors);
        $response->set("users", $users);
        $response->set("roles", $roles);
        $response->set("classes", $classes);
        $response->set("activeClasses", $activeClasses);
        $response->set("currentPage", $page);
        $response->set("totalPages", $totalPages);

        $modelUsers = $container->get("users");
        $modelOrles = $container->get("orles");
        $modelClasses = $container->get("classes");


        $allGroups = $modelUsers->getClassGroups();
        $allOrles = $modelOrles->getOrles();

        $classes = $modelClasses->getClasses();

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

                $response->redirect("Location: /orla/edit?idOrla=" . $idOrla);
            }

            if ($action === "toggleOrlaPublic") {
                $idOrla = $_POST['idOrla'];
                $isChecked = $_POST['isChecked'];

                if ($isChecked) {
                    $modelOrles->setOrlaPublicOn($idOrla);
                } else {
                    $modelOrles->setOrlaPublicOff($idOrla);
                }

                $response->redirect("Location: /admin");

            }

        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "deleteReport") {
                $modelUsers->deleteReport($_GET['report_id']);

                $response->redirect("Location: /admin");
            }

            if ($action === "deleteReportedImage") {
                $modelUsers->deleteReportAndPhoto($_GET['report_id']);

                $response->redirect("Location: /admin");
            }

            if ($action === "deleteOrla") {
                $idOrla = $_GET['idOrla'];
                $modelOrles->deleteOrla($idOrla);

                $response->redirect("Location: /admin");
            }

            if ($action === "activateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOn($idOrla);

                $response->redirect("Location: /admin");
            }

            if ($action === "deactivateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOff($idOrla);

                $response->redirect("Location: /admin");
            }

        }

        $reportedImages = $modelUsers->getReportedImages();

        $response->set("reportedImages", $reportedImages);

        $response->SetTemplate("AdminView.php");

        return $response;
    }

    /**
     * Mostra la vista de l'editor d'orles amb l'identificador d'orla proporcionat.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb la vista de l'editor d'orles.
     */
    public function orlaEditor($request, $response, $container)
    {
        $idOrla = $_GET["idOrla"];
        $response->set("idOrla", $idOrla);
        $response->SetTemplate("editorOrlesView.php");

        return $response;
    }

    /**
     * Gestiona les operacions relacionades amb l'equip directiu, com la creació d'orles, la gestió de visibilitat,
     * la manipulació de reports d'imatges i altres accions administratives.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb dades per a la vista de l'equip directiu.
     */
    public function equipDirectiu($request, $response, $container)
    {

        $modelUsers = $container->get("users");
        $modelOrles = $container->get("orles");
        $modelClasses = $container->get("classes");


        $allGroups = $modelUsers->getClassGroups();
        $allOrles = $modelOrles->getOrles();

        $classes = $modelClasses->getClasses();

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

                $response->redirect("Location: /orla/edit?idOrla=" . $idOrla);
            }

            if ($action === "toggleOrlaPublic") {
                $idOrla = $_POST['idOrla'];
                $isChecked = $_POST['isChecked'];

                if ($isChecked) {
                    $modelOrles->setOrlaPublicOn($idOrla);
                } else {
                    $modelOrles->setOrlaPublicOff($idOrla);
                }

                $response->redirect("Location: /equipDirectiu");

            }

        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "deleteReport") {
                $modelUsers->deleteReport($_GET['report_id']);

                $response->redirect("Location: /equipDirectiu");
            }

            if ($action === "deleteReportedImage") {
                $modelUsers->deleteReportAndPhoto($_GET['report_id']);

                $response->redirect("Location: /equipDirectiu");
            }

            if ($action === "deleteOrla") {
                $idOrla = $_GET['idOrla'];
                $modelOrles->deleteOrla($idOrla);

                $response->redirect("Location: /equipDirectiu");
            }

            if ($action === "activateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOn($idOrla);

                $response->redirect("Location: /equipDirectiu");
            }

            if ($action === "deactivateOrla") {
                $idOrla = $_GET["idOrla"];

                $modelOrles->setOrlaVisibilityOff($idOrla);

                $response->redirect("Location: /equipDirectiu");
            }

        }

        $reportedImages = $modelUsers->getReportedImages();

        $response->set("reportedImages", $reportedImages);
        $response->set("classes", $classes);
        $response->SetTemplate("equipDirectiuView.php");
        return $response;
    }

    /**
     * Gestiona les operacions relacionades amb el perfil d'un usuari, com la configuració de fotos, la selecció d'avatar,
     * i la visualització d'informació personal i imatges relacionades amb l'usuari.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb dades per a la vista del perfil de l'usuari.
     */
    public function perfil($request, $response, $container)
    {
        $userId = $_SESSION["user"]["id"];
        $userModel = $container->get("users");

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];

            if ($action === "setDefaultPhoto") {
                $userModel->setDefaultPhoto($userId, $_POST['idPhoto']);

                $response->redirect("Location: /perfil");
            }

            if ($action === "setPorfilePhoto") {
                $userModel->setPorfilePhoto($userId, $_POST['avatar']);


                $response->redirect("Location: /perfil");
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

    /**
     * Controlador per a la pàgina de recuperació de contrasenya.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
    function recover($request, $response, $container)
    {
        $response->SetTemplate("Recover.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina de gestió de tokens invàlids.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
    function invalidtoken($request, $response, $container)
    {
        $response->SetTemplate("InvalidToken.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina de recuperació de contrasenya mitjançant un token.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
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

    /**
     * Gestiona la generació del carnet d'un usuari a partir d'un token proporcionat.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb dades per a la vista del carnet o un missatge d'error.
     */
    function carnet($request, $response, $container)
    {
        $modelusers = $container->get("users");

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST["token_carnet"])) {
            $tokenCarnet = $_REQUEST["token_carnet"];
            $user = $modelusers->getUserByTokenCarnet($tokenCarnet);

            if ($user) {
                $response->set("user", $user);
                $response->setTemplate("CarnetView.php");
                return $response;
            } else {
                $response->setBody("Invalid token");
                return $response;
            }
        } else {
            $response->setBody("Token not provided");
            return $response;
        }
    }

    /**
     * Obté el token de carnet associat a l'usuari actual i el retorna en format JSON.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb el token de carnet en format JSON.
     */
    function getTokenCarnet($request, $response, $container)
    {
        $modelusers = $container->get("users");
        $getToken = $modelusers->getTokenCarnet($_SESSION["user"]["id"]);

        $response->setJSON();
        $response->setBody(json_encode($getToken));
        return $response;
    }

    /**
     * Gestiona el procés de canvi de contrasenya per a l'usuari actual.
     *
     * @param \Emeset\Http\Request $request Petició HTTP.
     * @param \Emeset\Http\Response $response Resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP amb el resultat del canvi de contrasenya o missatge d'error.
     */
    function canviarContrasenya($request, $response, $container)
    {
        $userModel = $container->get("users");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST["currentPassword"];
            $newPassword = $_POST["newPassword"];

            $user = $userModel->login($_SESSION["user"]["email"], $currentPassword);

            if ($user) {
                $newHashedPassword = $userModel->hashPassword($newPassword);
                $userModel->updatePassword($_SESSION["user"]["id"], $newHashedPassword);

                $response->redirect("Location: /perfil");
            } else {
                $error = "La contrasenya actual no és correcta";
                $response->setSession("error", $error);

                $response->redirect("Location: /canviarContrasenya");
                return $response;
            }
        }

        $error = $request->get("SESSION", "error");
        $response->setSession("error", "");
        $response->set("error", $error);
        $response->SetTemplate("CanviarContrasenyaView.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina del professor.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
    function teacher($request, $response, $container)
    {
        $id = $request->get("SESSION", "user")["id"];

        $model = $container->get("users");
        $model2 = $container->get("classes");
        $userModel = $container->get("users");
        $allUsers = $model->getAllStudents();
        $allClass = $model2->getClassByUser($id);
        $userOrla = $userModel->getOrlaFromClassByUserId($id);

        $countUsers = 12;
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $countUsers;
        $users = array_slice($allUsers, $start, $countUsers);
        $totalPages = ceil(count($allUsers) / $countUsers);

        $response->set("users", $users);
        $response->set("currentPage", $page);
        $response->set("totalPages", $totalPages);
        $response->set("classes", $allClass);
        $response->set("userOrla", $userOrla);
        $response->SetTemplate("TeacherView.php");
        return $response;
    }

    /**
     * Controlador per a la pàgina de la càmera.
     *
     * @param \Emeset\Http\Request $request Objecte de sol·licitud HTTP.
     * @param \Emeset\Http\Response $response Objecte de resposta HTTP.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Objecte de resposta HTTP amb dades per a la plantilla.
     */
    function camera($request, $response, $container)
    {
        $idUser = $request->get(INPUT_POST, "id-edit");
        $response->set("idUser", $idUser);

        $response->SetTemplate("Camera.php");
        return $response;
    }
}

