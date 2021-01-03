<?php

namespace App\Helpers;

class Faker
{
    /**
     * Generate string only from numbers
     *
     * @param int $length
     * @return string
     */
    public static function generateNumberString(int $length): string
    {
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= mt_rand(0, 9);
        }

        return $token;
    }
}
