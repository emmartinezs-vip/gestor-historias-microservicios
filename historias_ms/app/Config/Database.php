<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private string $host = 'localhost';
    private string $database = 'gestor_historias_db';
    private string $username = 'root';
    private string $password = '';

    public function connect(): PDO
    {
        try {
            $connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;

        } catch (PDOException $exception) {

            die("Error de conexión: " . $exception->getMessage());
        }
    }
}