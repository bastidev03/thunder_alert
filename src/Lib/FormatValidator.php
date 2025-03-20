<?php
namespace App\Lib;

class FormatValidator
{
    const INSEE_REGEX = '/^(0[1-9]|[1-9][ABab\d])\d{3}$/';

    const BASIC_PHONE_REGEX = '/^(06|07)\d{8}$/';


    public static function checkInsee(mixed $raw_value):bool
    {
        return !!preg_match(self::INSEE_REGEX, "$raw_value");
    }

    public static function checkPhone(mixed $raw_value):bool
    {
        return !!preg_match(self::BASIC_PHONE_REGEX, "$raw_value");
    }
}