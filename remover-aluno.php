<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once __DIR__ . "/vendor/autoload.php";

$pdo = ConnectionCreator::createConnection();

$id = 22;

$query = "DELETE FROM `students` WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);

if ($stmt->execute()) { 
    echo "Aluno excluido com sucesso!";
}
