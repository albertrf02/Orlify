<?php


use App\Controllers\LoginController;
use Emeset\Contracts\Routers\Router;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../vendor/autoload.php";

/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);

$app->get("/", [LoginController::class,"index"]);
$app->get("/login", [LoginController::class,"indexlogin"]);
$app->post("/dologin", [LoginController::class,"login"]);

$app->route(Router::DEFAULT_ROUTE, "\App\Controllers\ErrorController:error404");

$app->execute();