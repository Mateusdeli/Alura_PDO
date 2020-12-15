<?php

require_once __DIR__ . "/vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();

$student = new Student(1, "Joao Paulo Alex", new DateTimeImmutable("1969-11-05"));
$studentRepository = new PdoStudentRepository($connection);

$studentRepository->save($student);

echo 'Concluido';
