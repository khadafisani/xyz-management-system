<?php

namespace App\Http\Enums;

trait Enum
{
    /**
     * Notes About PHP Enums
     * enum is a final class, therefore using `trait` instead of `extends` but same purpose of hierarchy
     * implicit model binding enums need to define `enumclass: string` due to laravel searched by value of the variables
     * `enum::getList()` method is available as `enum::cases()`
     */

    public static function getArray()
    {
        $result = [];
        foreach (self::cases() as $arr)
            $result[] = [
                "id" => $arr->value,
                "name" => self::getString($arr),
            ];
        return $result;
    }

    // default name from enum case.
    public static function getString(Self $self): string
    {
        return $self->name;
    }
}
