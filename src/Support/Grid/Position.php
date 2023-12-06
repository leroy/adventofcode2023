<?php

namespace Leroy\AdventOfCode2023\Support\Grid;

class Position
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
    )
    {
    }

    public function key(): string
    {
        return "{$this->x},{$this->y}";
    }

    public static function fromKey(string $key): Position
    {
        [$x, $y] = explode(',', $key);

        return new Position((int)$x, (int)$y);
    }

    public function __toString(): string
    {
        return $this->key();
    }
}