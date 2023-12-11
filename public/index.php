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

/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);

$app->get("/", [ViewsController::class, "index"]);
$app->get("/login", [ViewsController::class, "login"]);
$app->get("/register", [ViewsController::class, "register"]);
$app->get("/logout", [LoginController::class, "logout"]);
$app->get("/admin", [ViewsController::class, "admin"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/equipDirectiu", [ViewsController::class, "equipDirectiu"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/perfil", [ViewsController::class, "perfil"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/veureOrla", [OrlaController::class, "getUsersFromOrla"]);


$app->post("/equipDirectiuPost", [ViewsController::class, "equipDirectiu"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/report-image", [UserController::class, "reportImages"], [[\App\Middleware\Auth::class, "auth"]]);
$app->post("/perfil", [ViewsController::class, "perfil"], [[\App\Middleware\Auth::class, "auth"]]);
$app->get("/recover", [ViewsController::class, "recover"]);
$app->get("/invalidtoken", [ViewsController::class, "invalidtoken"]);
$app->get("/recoverpassword/{token}", [ViewsController::class, "recoverpassword"]);


$app->post("/dologin", [LoginController::class, "login"]);
$app->post("/doregister", [LoginController::class, "register"]);
$app->post("/updateuser", [UserController::class, "update"]);
$app->post("/deleteuser", [UserController::class, "delete"]);
$app->post("/dorecover", [RecoverController::class, "recover"]);
$app->post("/dorecoverpassword", [RecoverController::class, "password"]);



$app->post("/updateuserajax", [UserController::class, "updateAjax"]);
$app->post("/deleteuserajax", [UserController::class, "deleteAjax"]);


$app->post("/importcsv", [UserController::class, "importCSV"]);




$app->post("/searchuserajax", [UserController::class, "searchUserAjax"]);


$app->post("/editclassajax", [ClassController::class, "editClassAjax"]);
$app->post("/editclass", [ClassController::class, "editClass"]);






$app->route(Router::DEFAULT_ROUTE, "\App\Controllers\ErrorController:error404");

$app->execute();