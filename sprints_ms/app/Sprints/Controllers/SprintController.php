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

    public function update($request, $response, $args)
{
        $id = (int) $args['id'];

        $data = json_decode($request->getBody()->getContents(), true);

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

        $updated = $repository->updateSprint($id, $data);

    if (!$updated) {

        $error = [
            "error" => "No se pudo actualizar el sprint"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }

        $message = [
        "mensaje" => "Sprint actualizado correctamente"
    ];

        $response->getBody()->write(json_encode($message));

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
    }

    public function destroy($request, $response, $args)
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

    $deleted = $repository->deleteSprint($id);

    if (!$deleted) {

        $error = [
            "error" => "No se pudo eliminar el sprint"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }

    $message = [
        "mensaje" => "Sprint eliminado correctamente"
    ];

    $response->getBody()->write(json_encode($message));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
}
}