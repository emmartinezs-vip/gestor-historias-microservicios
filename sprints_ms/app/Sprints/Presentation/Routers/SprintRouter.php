<?php

use Slim\App;
use App\Sprints\Controllers\SprintController;

return function (App $app) {

    $controller = new SprintController();

    $app->get('/sprints', [$controller, 'index']);

};