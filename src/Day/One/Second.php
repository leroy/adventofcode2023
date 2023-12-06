<?php

namespace Leroy\AdventOfCode2023\Day\One;

use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\input;
use function Leroy\AdventOfCode2023\Support\strpos_all;

class Second implements Puzzle
{
    private array $stringNumbers = [
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
    ];

    public function run()
    {
        $input = input('1');

        $lines = explode(PHP_EOL, $input);

        foreach ($lines as &$line) {

            $stringNumberPositions = [];
            foreach ($this->stringNumbers as $key => $value) {
                $stringNumberPositions[$key] = strpos_all($line, $key);
            }

            foreach ($stringNumberPositions as $stringNumber => $positions) {
                foreach($positions as $position) {
                    $line[$position] = $this->stringNumbers[$stringNumber];
                }
            }
        }

        $linesNumeric = array_map(fn($line) => filter_var($line, FILTER_SANITIZE_NUMBER_INT), $lines);

        $linesNumeric = array_filter($linesNumeric);

        $linesNumeric = array_map(fn($line) => $line[0] . $line[-1], $linesNumeric);

        $sum = array_sum($linesNumeric);

        echo $sum;
    }
}