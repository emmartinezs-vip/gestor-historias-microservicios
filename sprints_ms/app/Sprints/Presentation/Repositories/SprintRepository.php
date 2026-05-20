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
}