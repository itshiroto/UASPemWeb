<?php

namespace App\Helpers;
use App\Models;

class isExist
{
    public static function isExist($model, $column, $value)
    {
        $model = 'App\Models\\' . $model;
        $model = new $model;
        $result = $model::where($column, $value)->first();
        if ($result) {
            return true;
        }
        else {
            return false;
        }
    }
}