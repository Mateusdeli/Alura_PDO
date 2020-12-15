<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\IStudentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;
use RuntimeException;
use Alura\Pdo\Domain\Model\Phone;

class PdoStudentRepository implements IStudentRepository{

    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function getAllStudents(): array
    {
        $query = "SELECT * FROM students;";
        $stmt = $this->connection->query($query);
        return $this->hydrateStudentList($stmt);
    }

    public function getStudentsDateBirth(DateTimeInterface $birthDate): array
    {
        $query = "SELECT * FROM `students` WHERE `birth_date` = :d;";
        $stmt = $this->connection->query($query);
        $stmt->bindValue(":d", $birthDate->format("Y-m-d"), PDO::PARAM_STR);
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    private function hydrateStudentList(PDOStatement $stmt) : array
    {
        $students = $stmt->fetchAll();
        $studentsList = [];

        foreach ($students as $student) {
            $studentsList[] = 
            $st = new Student($student['id'], $student['name'], new DateTimeImmutable($student['birth_date']));
            $this->fillPhoneAt($st);
        }

        return $studentsList;
    }
    
    private function fillPhoneAt(Student $student): void {
        
        $query = "SELECT id, area_code, number FROM phones WHERE student_id = :i";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":i", $student->id());
        $stmt->execute();
        
        $phones = $stmt->fetchAll();
        foreach ($phones as $phone) {
            $p = new Phone($phone['id'], $phone['area_code'], $phone['number']);
            $student->addPhone($p);
        }
    }

    public function save(Student $student): bool
    {
        if ($student->id() !== null) {
            return $this->update($student);
        }
        else {
            $query = "INSERT INTO `students` (`name`, `birth_date`) VALUES (:n, :d);";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":n", $student->name(), PDO::PARAM_STR);
            $stmt->bindValue(":d", $student->birthDate()->format("Y-m-d"), PDO::PARAM_STR);
            return $stmt->execute();
        }
    }

    public function update(Student $student): bool
    {
        $query = "UPDATE `students` SET name = :n, birth_date = :d WHERE id = :i;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":n", $student->name(), PDO::PARAM_STR);
        $stmt->bindValue(":d", $student->birthDate()->format("Y-m-d"), PDO::PARAM_STR);
        $stmt->bindValue(":i", $student->id(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $query = "DELETE FROM `students` WHERE id = :i";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":i", $student->id(), PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getStudentsWithPhones(): array
    {
        
        $query = "SELECT 
                        students.id,
                        students.name,
                        students.birth_date,
                        phones.id AS phone_id,
                        phones.area_code,
                        phones.number FROM students JOIN phones ON students.id = phones.id";
       $stmt = $this->connection->query($query);
       $results = $stmt->fetchAll();
       $studentsList = [];
       foreach ($results as $row) {
           
           if (!array_key_exists($row['id'], $studentsList)) {
               $studentsList[$row['id']] = new Student($row['id'], $row['name'], new \DateTimeImmutable($row['birth_date']));
           }
           
           $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);
           $studentsList[$row['id']]->addPhone($phone);
           
       }
       return $studentsList;
    }

}