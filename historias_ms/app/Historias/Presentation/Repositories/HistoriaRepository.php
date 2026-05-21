<?php

namespace App\Historias\Presentation\Repositories;

use App\Config\Database;
use PDO;

class HistoriaRepository
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();

        $this->connection = $database->connect();
    }

    public function getAllHistorias(): array
    {
        $sql = "SELECT * FROM historias";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}