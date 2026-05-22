<?php

namespace App\Sprints\Presentation\Repositories;

use App\Config\Database;
use PDO;

class SprintRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->connect();
    }

    public function getAllSprints(): array
    {
        $sql = "SELECT * FROM sprints";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSprintById(int $id): array|bool
    {
        $sql = "SELECT * FROM sprints WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createSprint(array $data): bool
    {
        $sql = "INSERT INTO sprints (
                nombre,
                fecha_inicio,
                fecha_fin
            ) VALUES (
                :nombre,
                :fecha_inicio,
                :fecha_fin
            )";

        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':nombre', $data['nombre']);
        $statement->bindParam(':fecha_inicio', $data['fecha_inicio']);
        $statement->bindParam(':fecha_fin', $data['fecha_fin']);

        return $statement->execute();
    }
}