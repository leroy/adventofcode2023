<?php

namespace Leroy\AdventOfCode2023\Support;

function input(string $day): string
{
    return file_get_contents(__DIR__ . "/../../input/{$day}.txt");
}

function lines(string $day): array
{
    return explode("\n", input($day));
}

function mapWithKeys(callable $callback, array $array) {
    $result = [];

    foreach ($array as $key => $value) {
        $transformed = $callback($value, $key);

        foreach ($transformed as $newKey => $newValue) {
            $result[$newKey] = $newValue;
        }
    }

    return $result;
}

function strpos_all($haystack, $needle) {
    $offset = 0;
    $allpos = array();
    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }
    return $allpos;
}