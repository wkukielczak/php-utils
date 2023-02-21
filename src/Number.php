<?php

namespace Wkukielczak\PhpUtils;

class Number
{
    /**
     * Check if the string can be safely converted to a float number
     *
     * @param string $var
     * @return bool
     */
    public static function isFloat(string $var): bool
    {
        return 1 === preg_match('/^\d+\.(\d+)?$/', $var);
    }
}