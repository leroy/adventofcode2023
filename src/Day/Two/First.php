<?php

namespace Leroy\AdventOfCode2023\Day\Two;

use Leroy\AdventOfCode2023\Support\Puzzle;
use function Leroy\AdventOfCode2023\Support\input;
use function Leroy\AdventOfCode2023\Support\lines;
use function Leroy\AdventOfCode2023\Support\mapWithKeys;

class First implements Puzzle
{

    public function run()
    {
        $valid = [
            'red' => 12,
            'green' => 13,
            'blue' => 14,
        ];

        $gameIds = [];

        $lines = lines('2');

        foreach($lines as $line) {
            $legit = true;

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

            foreach($games as $game) {
                foreach($game as $color => $count) {
                    if ($count > $valid[$color]) {
                        $legit = false;
                    }
                }
            }

            if ($legit) {
                $gameIds[] = $gameId;
            }
        }

        echo array_sum($gameIds);
    }
}