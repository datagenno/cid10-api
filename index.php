<?php
require('App/Core/Configs/bootstrap.php');

$app->group('/v1', function () use ($app) { require_once("App/V1/routes.php"); });
$app->group('/v2', function () use ($app) { require_once("App/V2/routes.php"); });

$app->run();
