<?php
use App\Controllers\ViewsController;

use App\Controllers\LoginController;

use App\Controllers\UserController;

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
$app->get("/admin", [ViewsController::class, "admin"], [[\App\Middleware\Auth::class,"auth"]]);


$app->post("/dologin", [LoginController::class, "login"]);
$app->post("/doregister", [LoginController::class, "register"]);
$app->post("/updateuser", [UserController::class, "update"]);
$app->post("/deleteuser", [UserController::class, "delete"]);

$app->post("/searchuser", [UserController::class, "searchUser"]);




$app->route(Router::DEFAULT_ROUTE, "\App\Controllers\ErrorController:error404");

$app->execute();