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

        $response->getBody()->write(json_encode($sprint));

        return $response->withHeader('Content-Type', 'application/json');
    }
}