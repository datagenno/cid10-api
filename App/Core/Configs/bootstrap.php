<?php
require(__DIR__ . '/../../../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

if(getenv('ENV') === 'DEVELOPMENT') {
  ini_set('display_errors',1);
  ini_set('display_startup_erros',1);
  error_reporting(E_ALL);
}

$container = new \Slim\Container();

$container['errorHandler'] = function($container) {
  return function($request, $response, $exception) use ($container) {
    return $container['response']->withStatus(500)
                                 ->withHeader('Content-Type', 'application/json;charset=utf-8')
                                 ->write($exception->getMessage());
  };
};

$container['notFoundHandler'] = function($container) {
  return function($request, $response) use ($container) {
    $message = json_encode([
      'error'   => true,
      'message' => 'request_not_found'
    ]);

    return $container['response']->withStatus(404)
                                 ->withHeader('Content-Type', 'application/json;charset=utf-8')
                                 ->write($message);
  };
};

$app = new \Slim\App($container);

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
  "secure" => getenv('ENV') === 'PRODUCTION',
  "users"  => [ getenv('BASIC_AUTHENTICATION_USERNAME') => getenv('BASIC_AUTHENTICATION_PASSWORD') ]
]));
