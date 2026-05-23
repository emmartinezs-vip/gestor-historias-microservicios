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

    public function getHistoriaById(int $id): array|bool
    {
    $sql = "SELECT * FROM historias WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createHistoria(array $data): bool
    {
    $sql = "INSERT INTO historias (
                titulo,
                descripcion,
                responsable,
                estado,
                puntos,
                fecha_creacion,
                fecha_finalizacion,
                sprint_id
            ) VALUES (
                :titulo,
                :descripcion,
                :responsable,
                :estado,
                :puntos,
                :fecha_creacion,
                :fecha_finalizacion,
                :sprint_id
            )";

    $statement = $this->connection->prepare($sql);

    $statement->bindParam(':titulo', $data['titulo']);
    $statement->bindParam(':descripcion', $data['descripcion']);
    $statement->bindParam(':responsable', $data['responsable']);
    $statement->bindParam(':estado', $data['estado']);
    $statement->bindParam(':puntos', $data['puntos']);
    $statement->bindParam(':fecha_creacion', $data['fecha_creacion']);
    $statement->bindParam(':fecha_finalizacion', $data['fecha_finalizacion']);
    $statement->bindParam(':sprint_id', $data['sprint_id']);

    return $statement->execute();
    }

    public function updateHistoria(int $id, array $data): bool
    {
    $sql = "UPDATE historias
            SET
                titulo = :titulo,
                descripcion = :descripcion,
                responsable = :responsable,
                estado = :estado,
                puntos = :puntos,
                fecha_creacion = :fecha_creacion,
                fecha_finalizacion = :fecha_finalizacion,
                sprint_id = :sprint_id
            WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindParam(':titulo', $data['titulo']);
    $statement->bindParam(':descripcion', $data['descripcion']);
    $statement->bindParam(':responsable', $data['responsable']);
    $statement->bindParam(':estado', $data['estado']);
    $statement->bindParam(':puntos', $data['puntos']);
    $statement->bindParam(':fecha_creacion', $data['fecha_creacion']);
    $statement->bindParam(':fecha_finalizacion', $data['fecha_finalizacion']);
    $statement->bindParam(':sprint_id', $data['sprint_id']);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    return $statement->execute();
    }

    public function deleteHistoria(int $id): bool
    {
    $sql = "DELETE FROM historias WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    return $statement->execute();
    }

   public function obtenerReporteGeneral(): array
{
    $sql = "
        SELECT estado, COUNT(*) AS cantidad
        FROM historias
        GROUP BY estado
    ";

    $statement = $this->connection->prepare($sql);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerReporteResponsables(): array
{
    $sql = "
        SELECT
            responsable,

            SUM(
                CASE
                    WHEN estado = 'nueva'
                    THEN 1
                    ELSE 0
                END
            ) AS nuevas,

            SUM(
                CASE
                    WHEN estado = 'finalizada'
                    THEN 1
                    ELSE 0
                END
            ) AS finalizadas,

            SUM(
                CASE
                    WHEN estado = 'impedimento'
                    THEN 1
                    ELSE 0
                END
            ) AS impedimentos

        FROM historias

        GROUP BY responsable
    ";

    $statement = $this->connection->prepare($sql);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

}