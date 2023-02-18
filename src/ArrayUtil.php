<?php

namespace Wkukielczak\PhpUtils;

class ArrayUtil
{
    /**
     * Safely get array's value. If the key is not present returns the default value.
     * If the default value is not set, the function will return NULL
     *
     * @param string|int $key
     * @param array|null $arr
     * @param mixed $default
     * @return mixed
     */
    static public function safeGet(string|int $key, ?array $arr, mixed $default = null): mixed
    {
        return $arr ?
            array_key_exists($key, $arr) ? $arr[$key] : $default :
            $default;
    }
}