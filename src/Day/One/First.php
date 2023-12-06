<?php

namespace Leroy\AdventOfCode2023\Day\One;

use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\input;

class First implements Puzzle
{
    public function run()
    {
        $input = input('1');

        $lines = explode(PHP_EOL, $input);

        $linesNumeric = array_map(fn($line) => filter_var($line, FILTER_SANITIZE_NUMBER_INT), $lines);

        $linesNumeric = array_filter($linesNumeric);

        $linesNumeric = array_map(fn($line) => $line[0] . $line[-1], $linesNumeric);

        $sum = array_sum($linesNumeric);

        echo $sum;
    }
}

