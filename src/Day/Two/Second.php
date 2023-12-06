<?php

namespace Leroy\AdventOfCode2023\Day\Two;

use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\input;
use function Leroy\AdventOfCode2023\Support\lines;
use function Leroy\AdventOfCode2023\Support\mapWithKeys;

class Second implements Puzzle
{

    public function run()
    {
        $valid = [
            'red' => 12,
            'green' => 13,
            'blue' => 14,
        ];

        $powers = [];

        $lines = lines('2');

        foreach($lines as $line) {
            [$game, $games] = explode(':', $line);

            $gameId = filter_var($game, FILTER_SANITIZE_NUMBER_INT);

            $games = explode(';', $games);

            $games = array_map(function(string $game) {
                $grabs = explode(',', $game);
                $grabs = array_map(trim(...), $grabs);

                $grabs = mapWithKeys(function($grab) {
                    [$count, $color] = explode(' ', $grab);

                    return [$color => (int) $count];
                }, $grabs);

                return $grabs;
            }, $games);

            $lowest = [];

            foreach($games as $game) {
                foreach($game as $color => $count) {
                    if (empty($lowest[$color])) {
                        $lowest[$color] = $count;
                        continue;
                    }

                    if ($count > $lowest[$color]) {
                        $lowest[$color] = $count;
                    }
                }
            }

            $power[] = array_reduce($lowest, function($carry, $item) {
                return $carry * $item;
            }, 1);
        }

        echo array_sum($power);
    }
}