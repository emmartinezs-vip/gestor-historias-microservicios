<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->add(function ($request, $handler) {

    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

});

$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});

(require __DIR__ . '/../app/Sprints/Presentation/Routers/SprintRouter.php')($app);

$app->run();