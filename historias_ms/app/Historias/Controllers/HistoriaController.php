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

    public function show($request, $response, $args)
    {
        $id = (int) $args['id'];

        $repository = new HistoriaRepository();

        $historia = $repository->getHistoriaById($id);

        if (!$historia) {

            $error = [
                "error" => "Historia no encontrada"
            ];

            $response->getBody()->write(json_encode($error));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $response->getBody()->write(json_encode($historia));

        return $response->withHeader('Content-Type', 'application/json');
    }
}