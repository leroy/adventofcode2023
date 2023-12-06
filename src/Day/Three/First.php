<?php

namespace Leroy\AdventOfCode2023\Day\Three;

use Leroy\AdventOfCode2023\Support\Grid\Grid;
use Leroy\AdventOfCode2023\Support\Grid\Position;
use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\lines;

class First implements Puzzle
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

        $numberPositions = [];

        $numbers = [];

        foreach ($lines as $y => $line) {
            $lastNumeric = false;
            $firstLinkPosition = null;

            foreach (str_split($line) as $x => $character) {
                $grid->set(new Position($x, $y), $character);

                if (is_numeric($character) && !$lastNumeric) {
                    $firstLinkPosition = new Position($x, $y);
                    $numberPositions[] = $firstLinkPosition;
                }

                if (is_numeric($character) && $lastNumeric) {
                    $grid->link($firstLinkPosition, new Position($x, $y));
                }

                $lastNumeric = is_numeric($character);

                if (!$lastNumeric) {
                    $firstLinkPosition = null;
                }
            }
        }

        foreach ($numberPositions as $numberPosition) {
            $linked = $grid->linked($numberPosition);

            $neighbours = collect($linked)->flatMap(fn(Position $position) => $grid->neighbours($position))->unique(fn(Position $position) => $position->key())->flatten()->toArray();

            foreach($neighbours as $neighbour) {
                $neighbourValue = $grid->get($neighbour);

                if (in_array($neighbourValue, $symbols)) {
                    $number = array_reduce($linked, fn($carry, Position $position) => $carry . $grid->get($position), '');
                    $number = (int)$number;

                    $numbers[] = $number;
                    continue 2;
                }
            }
        }

        echo array_sum($numbers);
    }
}