<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Mateus Deliberali',
    new \DateTimeImmutable('1997-07-10')
);

$studentRepository = new PdoStudentRepository(ConnectionCreator::createConnection());

$students = $studentRepository->getAllStudents();

foreach ($students as $student) {
    echo $student->name();
}


