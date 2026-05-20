<?php

use Slim\App;
use App\Historias\Controllers\HistoriaController;

return function (App $app) {

    $controller = new HistoriaController();

    $app->get('/historias', [$controller, 'index']);
};