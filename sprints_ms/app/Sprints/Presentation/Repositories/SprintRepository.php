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
}