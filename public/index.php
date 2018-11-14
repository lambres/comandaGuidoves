<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

//IMPORTS
require_once '../mw/Cors.php';
require_once '../mw/Validations.php';
require_once '../controllers/users.php';
require_once '../controllers/login.php';


$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
    ],
];
$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->post('/login', \Logins::class . ':login')->add(\Cors::class . ':HabilitarCORSTodos');

$app->post('/users/new', \Users::class . ':new_user')->add(\Validations::class . ':validate_new_user')->add(\Cors::class . ':HabilitarCORSTodos');

$app->post('/users/update', \Users::class . ':update_user')->add(\Cors::class . ':HabilitarCORSTodos');

$app->run();

?>