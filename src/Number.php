<?php

namespace Wkukielczak\PhpUtils;

class Number
{
    public static function isFloat(mixed $var): bool
    {
        return 1 === preg_match('/^\d+\.(\d+)?$/', $var);
    }
}