<?php

namespace Wkukielczak\PhpUtils\Tests;

use PHPUnit\Framework\TestCase;
use Wkukielczak\PhpUtils\Tests\Model\PersonModel;

class ToArrayTraitTest extends TestCase
{
    public function testToArrayShouldReturnAllValues(): void
    {
        $person = new PersonModel();
        $person->setName('Wojtek')
            ->setLastName('Kukielczak')
            ->setAge(5)
            ->setFavoriteNumber(71);

        $expected = [
            'name' => 'Wojtek',
            'lastName' => 'Kukielczak',
            'age' => 5,
            'favoriteNumber' => 71
        ];

        $this->assertEqualsCanonicalizing($expected, $person->toArray());
    }

    public function testToArrayShouldReturnOnlyNonNullValues(): void
    {
        $person = new PersonModel();
        $person->setName('Wojtek')->setLastName('Kukielczak');

        $expected = [
            'name' => 'Wojtek',
            'lastName' => 'Kukielczak',
        ];

        $this->assertEqualsCanonicalizing($expected, $person->toArray());
    }
}