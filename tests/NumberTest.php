<?php

namespace Wkukielczak\PhpUtils\Tests;

use PHPUnit\Framework\TestCase;
use Wkukielczak\PhpUtils\Number;

class NumberTest extends TestCase
{
    public function testStringIsFloatShouldBeTrue(): void
    {
        $this->assertTrue(Number::isFloat('1.4'));
        $this->assertTrue(Number::isFloat('143.'));
        $this->assertTrue(Number::isFloat('923876.883322233'));
    }

    public function testStringIsFloatShouldBeFalse(): void
    {
        $this->assertFalse(Number::isFloat('.0'));
        $this->assertFalse(Number::isFloat('We have 1.5 degrees'));
        $this->assertFalse(Number::isFloat(' 21.3'));
    }
}