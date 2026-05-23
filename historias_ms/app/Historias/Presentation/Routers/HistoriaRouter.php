<?php

use Slim\App;
use App\Historias\Controllers\HistoriaController;

return function ($app) {

    $controller = new HistoriaController();

    $app->get('/historias', [$controller, 'index']);

    $app->get('/historias/{id}', [$controller, 'show']);

    $app->post('/historias', [$controller, 'store']);

    $app->put('/historias/{id}', [$controller, 'update']);

    $app->delete('/historias/{id}', [$controller, 'destroy']);
};