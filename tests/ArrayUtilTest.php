<?php

namespace Wkukielczak\PhpUtils\Tests;

use PHPUnit\Framework\TestCase;
use Wkukielczak\PhpUtils\ArrayUtil;

final class ArrayUtilTest extends TestCase
{
    public function testGetArrayElementShouldSucceed(): void
    {
        $testArray = [
            'one' => 1,
            'two' => 2,
            'three' => 3
        ];

        $this->assertEquals(1, ArrayUtil::safeGet('one', $testArray));
        $this->assertEquals(2, ArrayUtil::safeGet('two', $testArray));
        $this->assertEquals(3, ArrayUtil::safeGet('three', $testArray));
    }

    public function testGetNotExistingElementWithDefaultValueShouldSucceed(): void
    {
        $testArray = ['one' => 1];

        $this->assertEquals('Hola', ArrayUtil::safeGet('hello', $testArray, 'Hola'));
        $this->assertEquals('two', ArrayUtil::safeGet('two', $testArray, 'two'));
        $this->assertNull(ArrayUtil::safeGet('two', $testArray));
        $this->assertEquals([], ArrayUtil::safeGet('nested', $testArray, []));
    }

    public function testNullArrayShouldNotFailAndReturnDefaultValue(): void
    {
        $testArray = null;

        $this->assertNull(ArrayUtil::safeGet('one', $testArray));
        $this->assertEquals('hi!', ArrayUtil::safeGet('message', $testArray, 'hi!'));
    }
}