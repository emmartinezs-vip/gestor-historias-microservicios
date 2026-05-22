<?php

namespace App\Sprints\Controllers;

use App\Sprints\Presentation\Repositories\SprintRepository;

class SprintController
{
    public function index($request, $response)
    {
        $repository = new SprintRepository();

        $sprints = $repository->getAllSprints();

        $response->getBody()->write(json_encode($sprints));

        return $response->withHeader('Content-Type', 'application/json');
    }

   public function show($request, $response, $args)
    {
        $id = (int) $args['id'];

        $repository = new SprintRepository();

        $sprint = $repository->getSprintById($id);

        if (!$sprint) {

        $error = [
            "error" => "Sprint no encontrado"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
        }

        $response->getBody()->write(json_encode($sprint));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store($request, $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $repository = new SprintRepository();

        $created = $repository->createSprint($data);

        if (!$created) {

        $error = [
            "error" => "No se pudo crear el sprint"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }

        $message = [
        "mensaje" => "Sprint creado correctamente"
    ];

        $response->getBody()->write(json_encode($message));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}