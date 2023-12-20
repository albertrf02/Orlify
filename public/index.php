<?php
use App\Controllers\ViewsController;

use App\Controllers\LoginController;

use App\Controllers\UserController;

use App\Controllers\OrlaController;
use App\Controllers\RecoverController;

use App\Controllers\ClassController;


use Emeset\Contracts\Routers\Router;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../vendor/autoload.php";

header("Access-Control-Allow-Origin: *");

/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);

$app->get("/", [ViewsController::class, "index"], [[\App\Middleware\LoadUserData::class, "loadUserData"]]);
$app->get("/login", [ViewsController::class, "login"]);
$app->get("/register", [ViewsController::class, "register"]);
$app->get("/logout", [LoginController::class, "logout"]);
$app->get("/publicOrles", [ViewsController::class, "publicOrles"]);
$app->get("/admin", [ViewsController::class, "admin"], [[\App\Middleware\Auth::class, "auth"]]);





$app->get("/equipDirectiu", [ViewsController::class, "equipDirectiu"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/perfil", [ViewsController::class, "perfil"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/professor", [ViewsController::class, "teacher"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/canviarContrasenya", [ViewsController::class, "canviarContrasenya"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/carnet", [ViewsController::class, "carnet"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/orles", [ViewsController::class, "orles"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/veureOrla", [OrlaController::class, "getUsersFromOrla"], [[\App\Middleware\Auth::class, "auth"]]);

$app->get("/orla/edit", [OrlaController::class, "editOrla"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/orla/view", [OrlaController::class, "viewOrla"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/orla-pdf", [OrlaController::class, "orlaToPDF"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/orla/iframe", [OrlaController::class, "iframeOrla"], [[\App\Middleware\Auth::class, "auth"]]);


$app->post("/saveOrla", [OrlaController::class, "saveOrla"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/equipDirectiu", [ViewsController::class, "equipDirectiu"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/report-image", [UserController::class, "reportImages"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/perfil", [ViewsController::class, "perfil"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/updatePassword", [ViewsController::class, "canviarContrasenya"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/recover", [ViewsController::class, "recover"]);
$app->get("/invalidtoken", [ViewsController::class, "invalidtoken"]);
$app->get("/recoverpassword/{token}", [ViewsController::class, "recoverpassword"]);



$app->post("/dologin", [LoginController::class, "login"]);
$app->post("/doregister", [LoginController::class, "register"]);
$app->post("/updateuser", [UserController::class, "update"]);
$app->post("/deleteuser", [UserController::class, "delete"]);
$app->post("/dorecover", [RecoverController::class, "recover"]);
$app->post("/dorecoverpassword", [RecoverController::class, "password"]);
$app->post("/doinsertphoto", [UserController::class, "insertPhoto"]);
$app->post("/camera", [ViewsController::class, "camera"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/doinsertphotoweb", [UserController::class, "insertPhotoWeb"]);



$app->post("/updateuserajax", [UserController::class, "updateAjax"]);
$app->post("/deleteuserajax", [UserController::class, "deleteAjax"]);


$app->post("/importcsv", [UserController::class, "importCSV"]);




$app->post("/searchuserajax", [UserController::class, "searchUserAjax"]);


$app->post("/editclassajax", [ClassController::class, "editClassAjax"]);
$app->post("/editclass", [ClassController::class, "editClass"]);

$app->post("/searchteacherclassajax", [ClassController::class, "searchTeacherClassAjax"]);

$app->post("/searchuserclassajax", [ClassController::class, "searchUserClassAjax"]);
$app->post("/searchUserTeacher", [ClassController::class, "searchUserAjax"]);

$app->post("/getclassajax", [ClassController::class, "getClassAjax"]);


$app->post("/adduserclass", [ClassController::class, "addUserClass"]);


$app->post("/viewuserclass", [ClassController::class, "viewUserClass"]);

$app->post("/deleteuserclass", [ClassController::class, "deleteUserClass"]);

$app->post("/addclass", [ClassController::class, "addClass"]);


$app->post("/insertgeneratdeuser", [UserController::class, "insertGeneratedUser"]);

$app->post("/searchstudentclassajax", [ClassController::class, "searchStudentClassAjax"]);






$app->route(Router::DEFAULT_ROUTE, "\App\Controllers\ErrorController:error404");

$app->execute();