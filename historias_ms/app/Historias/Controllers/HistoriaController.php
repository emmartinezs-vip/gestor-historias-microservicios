<?php

namespace App\Historias\Controllers;

use App\Historias\Presentation\Repositories\HistoriaRepository;

class HistoriaController
{
    public function index($request, $response)
    {
        $repository = new HistoriaRepository();

        $historias = $repository->getAllHistorias();

        $response->getBody()->write(json_encode($historias));

        return $response->withHeader('Content-Type', 'application/json');
    }
}