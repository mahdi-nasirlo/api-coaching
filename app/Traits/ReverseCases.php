<?php

namespace App\Traits;

/**
 * make reverse array from EnumClass::cases()
 * @method static cases()
 */
trait ReverseCases
{
    public static function reverseCasesWithLang(): array
    {
        $reverseArray = [];

        foreach (static::cases() as $case) {
            $reverseArray[$case->value] = trans('status.' . $case->name);
        }

        return $reverseArray;
    }

    public static function reverseCases(): array
    {
        $reverseArray = [];

        foreach (static::cases() as $case) {
            $reverseArray[$case->value] = $case->name;
        }

        return $reverseArray;
    }
}
