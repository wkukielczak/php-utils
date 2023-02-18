<?php

namespace Wkukielczak\PhpUtils;

/**
 * Credits: https://stackoverflow.com/a/3291689/3029310.
 */
class Crypto
{
    public static function randSecure($min, $max): int
    {
        $range = $max - $min;
        if ($range < 0) {
            return $min;
        } // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    public static function getToken(int $length = 32): string
    {
        $token = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        for ($i = 0; $i < $length; ++$i) {
            $token .= $codeAlphabet[self::randSecure(0, strlen($codeAlphabet))];
        }

        return $token;
    }
}
