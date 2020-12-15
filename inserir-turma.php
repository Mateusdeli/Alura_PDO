<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {
    $aStudent = new Student(null, "XANDAOOOOO2222222222", new DateTimeImmutable('1988-11-07'));
    $studentRepository->save($aStudent);
    $connection->commit();
} 
catch (Throwable $ex) {
    echo $ex->getMessage();
    $connection->rollBack();
}


