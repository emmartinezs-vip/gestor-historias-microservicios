<?php

namespace App\Sprints\Controllers;

class SprintController
{
    public function index($request, $response)
    {
        $data = [
            "mensaje" => "Controlador de Sprints funcionando"
        ];

        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json');
    }
}