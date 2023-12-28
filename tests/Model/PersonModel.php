<?php

namespace Wkukielczak\PhpUtils\Tests\Model;

use Wkukielczak\PhpUtils\ToArrayTrait;

class PersonModel
{
    use ToArrayTrait;

    private ?string $name = null;
    private ?string $lastName = null;
    private ?int $age = null;
    private ?int $favoriteNumber = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): PersonModel
    {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): PersonModel
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): PersonModel
    {
        $this->age = $age;
        return $this;
    }

    public function getFavoriteNumber(): ?int
    {
        return $this->favoriteNumber;
    }

    public function setFavoriteNumber(?int $favoriteNumber): PersonModel
    {
        $this->favoriteNumber = $favoriteNumber;
        return $this;
    }
}