<?php

namespace Leroy\AdventOfCode2023\Support\Grid;

class Grid
{
    private array $grid = [];

    private array $valuePositions = [];

    private $linkedCells = [];

    private $linkTree = [];

    public function set(Position $position, mixed $value)
    {
        $this->grid[$position->key()] = $value;

        $this->valuePositions[$value][] = $position;
    }

    public function get(Position $position): mixed
    {
        return $this->grid[$position->key()] ?? null;
    }

    public function link(Position $position, Position $linkedPosition)
    {
        $this->linkedCells[$position->key()][] = $linkedPosition;
        $this->linkTree[$linkedPosition->key()] = $position;
    }

    public function linked(Position $position): array
    {
        if (!isset($this->linkedCells[$position->key()]) && isset($this->linkTree[$position->key()])) {
            $position = $this->linkTree[$position->key()];
        }

        return [
            $position,
            ...($this->linkedCells[$position->key()] ?? [])
        ] ?? [];
    }

    public function neighbours(Position $position)
    {
        $neighbours = [
            new Position($position->x - 1, $position->y - 1),
            new Position($position->x - 1, $position->y),
            new Position($position->x - 1, $position->y + 1),

            new Position($position->x, $position->y - 1),
            new Position($position->x, $position->y + 1),

            new Position($position->x + 1, $position->y - 1),
            new Position($position->x + 1, $position->y),
            new Position($position->x + 1, $position->y + 1),
        ];

        return array_filter($neighbours, function(Position $position) {
            return isset($this->grid[$position->key()]) && $this->grid[$position->key()] !== null;
        });
    }
}