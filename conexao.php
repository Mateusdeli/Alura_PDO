<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$query = "
CREATE TABLE IF NOT EXISTS `students` (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    birth_date DATE
);

CREATE TABLE IF NOT EXISTS `phones` (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    area_code CHAR(2),
    number CHAR(9),
    student_id INTEGER,
    FOREIGN KEY(student_id) REFERENCES students(id)
);";

$pdo->exec($query);

echo "Conectado!";

