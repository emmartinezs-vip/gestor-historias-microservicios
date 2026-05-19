<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

(require __DIR__ . '/../app/Sprints/Presentation/Routers/SprintRouter.php')($app);

$app->run();