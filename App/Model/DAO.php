<?php

namespace App\Model;

class DAO
{
    public static function prepararSetInsert(array $campos)
    {
        $set = '';

        foreach ($campos as $key => $values) {
            $set .= $key . ', ';
        }

        $set = substr($set, 0, -2);

        return $set;
    }

    public static function prepararSetValues(array $campos)
    {
        $set = '';

        foreach ($campos as $key => $values) {
            $set .= ':' . $key . ', ';
        }

        $set = substr($set, 0, -2);

        return $set;
    }

    public static function prepararArray(array $campos)
    {
        $array = [];

        foreach ($campos as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    public static function prepararSetUpdate(array $campos)
    {
        $set = '';

        foreach ($campos as $key => $value) {
            $set .= $key . ' = ' . ':' . $key . ', ';
        }

        $set = substr($set, 0, -2) . ' ';
        return $set;
    }
}
