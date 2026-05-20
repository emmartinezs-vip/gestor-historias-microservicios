<?php

namespace App\Historias\Controllers;

class HistoriaController
{
    public function index($request, $response)
    {
        $data = [
            "mensaje" => "Microservicio de Historias funcionando"
        ];

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json');
    }
}