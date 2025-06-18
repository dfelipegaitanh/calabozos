<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

class ClassesDto
{
    public function __construct(
        public int $count,
        public array $results,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['count'] ?? 0,
            $data['results'] ?? [],
        );
    }
}
