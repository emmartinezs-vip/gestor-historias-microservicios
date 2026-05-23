<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$historiaRoutes = require __DIR__ . '/../app/Historias/Presentation/Routers/HistoriaRouter.php';

$historiaRoutes($app);

$app->run();