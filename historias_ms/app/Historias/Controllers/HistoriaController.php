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

   public function store($request, $response)
    {
    $data = json_decode($request->getBody()->getContents(), true);

    if (empty($data['titulo'])) {

    $response->getBody()->write(json_encode([
        "error" => "El titulo es obligatorio"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if (empty($data['responsable'])) {

    $response->getBody()->write(json_encode([
        "error" => "El responsable es obligatorio"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if ($data['puntos'] < 0) {

    $response->getBody()->write(json_encode([
        "error" => "Los puntos no pueden ser negativos"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if (
    !empty($data['fecha_finalizacion']) &&
    $data['fecha_finalizacion'] < $data['fecha_creacion']
) {

    $response->getBody()->write(json_encode([
        "error" => "La fecha final no puede ser menor a la fecha de creacion"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

    $repository = new HistoriaRepository();

    $created = $repository->createHistoria($data);

    if (!$created) {

        $error = [
            "error" => "No se pudo crear la historia"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }

    $message = [
        "mensaje" => "Historia creada correctamente"
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

    if (empty($data['titulo'])) {

    $response->getBody()->write(json_encode([
        "error" => "El titulo es obligatorio"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if (empty($data['responsable'])) {

    $response->getBody()->write(json_encode([
        "error" => "El responsable es obligatorio"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if ($data['puntos'] < 0) {

    $response->getBody()->write(json_encode([
        "error" => "Los puntos no pueden ser negativos"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

if (
    !empty($data['fecha_finalizacion']) &&
    $data['fecha_finalizacion'] < $data['fecha_creacion']
) {

    $response->getBody()->write(json_encode([
        "error" => "La fecha final no puede ser menor a la fecha de creacion"
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(400);
}

    $repository = new HistoriaRepository();

    $historia = $repository->getHistoriaById($id);

    if (!$historia) {
        $response->getBody()->write(json_encode([
            'error' => 'Historia no encontrada'
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    }

    $repository->updateHistoria($id, $data);

    $response->getBody()->write(json_encode([
        'mensaje' => 'Historia actualizada correctamente'
    ]));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
    }

    public function destroy($request, $response, $args)
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

    $deleted = $repository->deleteHistoria($id);

    if (!$deleted) {

        $error = [
            "error" => "No se pudo eliminar la historia"
        ];

        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }

    $message = [
        "mensaje" => "Historia eliminada correctamente"
    ];

    $response->getBody()->write(json_encode($message));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
    }

   public function reporteGeneral($request, $response)
{
    $repository = new HistoriaRepository();

    $reporte = $repository->obtenerReporteGeneral();

    $response->getBody()->write(
        json_encode($reporte)
    );

    return $response
        ->withHeader('Content-Type', 'application/json');
}

public function reporteResponsables($request, $response)
{
    $repository = new HistoriaRepository();

    $reporte = $repository->obtenerReporteResponsables();

    $response->getBody()->write(
        json_encode($reporte)
    );

    return $response
        ->withHeader('Content-Type', 'application/json');
}

}