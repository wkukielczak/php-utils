<?php

namespace Wkukielczak\PhpUtils\Tests;

use PHPUnit\Framework\TestCase;
use Wkukielczak\PhpUtils\Crypto;

class CryptoTest extends TestCase
{
    public function testRandSecureShouldReturnNumbersInExpectedRange(): void
    {
        $number = Crypto::randSecure(0, 10);
        $this->assertGreaterThanOrEqual(0, $number);
        $this->assertLessThanOrEqual(10, $number);

        $number = Crypto::randSecure(100, 10000);
        $this->assertGreaterThanOrEqual(100, $number);
        $this->assertLessThanOrEqual(10000, $number);
    }

    public function testTokenShouldBeGeneratedOutOfAvailbleCharacters(): void
    {
        $string = Crypto::getToken();
        $this->assertEquals(32, strlen($string));
        $this->assertMatchesRegularExpression('/^([A-Za-z0-9]){32}$/', $string);
    }

    public function testNegativeRangeShouldReturnMinValue(): void
    {
        $this->assertEquals(17, Crypto::randSecure(17, 15));
    }
}