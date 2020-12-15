<?php

namespace Alura\Pdo\Domain\Model;

use Alura\Pdo\Domain\Model\Phone;

class Student
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;
    private array $phones;

    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }
    
    function addPhone(Phone $phone) {
        $this->phones[] = $phone;
    }
    
    function getPhones(): array {
        return $this->phones;
    }
}
