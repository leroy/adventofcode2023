<?php

namespace Leroy\AdventOfCode2023\Day\Three;

use Leroy\AdventOfCode2023\Support\Grid\Grid;
use Leroy\AdventOfCode2023\Support\Grid\Position;
use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\lines;

class Second implements Puzzle
{
    public function run()
    {
        $symbols = [
            '*',
            '$',
            '%',
            '/',
            '+',
            '-',
            '=',
            '@',
            '#',
            '&'
        ];

        $grid = new Grid();

        $lines = lines('3');

        $gearPositions = [];

        $numbers = [];

        foreach ($lines as $y => $line) {
            $lastNumeric = false;
            $firstLinkPosition = null;

            foreach (str_split($line) as $x => $character) {
                $grid->set(new Position($x, $y), $character);

                if (is_numeric($character) && !$lastNumeric) {
                    $firstLinkPosition = new Position($x, $y);
                }

                if (is_numeric($character) && $lastNumeric) {
                    $grid->link($firstLinkPosition, new Position($x, $y));
                }

                if ($character === '*') {
                    $gearPositions[] = new Position($x, $y);
                }

                $lastNumeric = is_numeric($character);

                if (!$lastNumeric) {
                    $firstLinkPosition = null;
                }
            }
        }

        foreach($gearPositions as $gearPosition) {
            $neighbours = $grid->neighbours($gearPosition);

            $neighbouringNumbers = collect($neighbours)
                ->filter(fn(Position $neighbour) => is_numeric($grid->get($neighbour)))
                ->map(fn(Position $neighbouringNumber) => $grid->linked($neighbouringNumber))
                ->unique(fn(array $linked) => array_reduce($linked, fn($carry, Position $position) => $carry . $position->key(), ''))
                ->map(fn(array $linked) => (int) array_reduce($linked, fn($carry, Position $position) => $carry . $grid->get($position), ''));

            if ($neighbouringNumbers->count() == 2) {
                $numbers[] = $neighbouringNumbers->first() * $neighbouringNumbers->last();
            }
        }

        echo array_sum($numbers);
    }
}