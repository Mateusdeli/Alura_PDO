<?php

namespace Alura\Pdo\Domain\Repository;

use Alura\Pdo\Domain\Model\Student;
use DateTimeInterface;

interface IStudentRepository {

    public function getAllStudents(): array;
    public function getStudentsWithPhones(): array;
    public function getStudentsDateBirth(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;

}