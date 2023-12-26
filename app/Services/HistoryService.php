<?php

namespace App\Services;

use App\Models\History;

class HistoryService
{
    public static function addRecord($data)
    {
        \Log::info($data);
        return History::create($data);
    }

    public static function getObjectDifference($array1, $array2)
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (!array_key_exists($key, $array2) || $array2[$key] != $value) {
                $difference[$key] = [
                    'old' => $value,
                    'new' => $array2[$key] ?? null,
                ];
            }
        }

        // Check for additional keys in $array2
        foreach ($array2 as $key => $value) {
            if (!array_key_exists($key, $array1)) {
                $difference[$key] = [
                    'old' => null,
                    'new' => $value,
                ];
            }
        }

        return $difference;
    }
}
