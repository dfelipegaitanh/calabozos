<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for starting equipment data.
 *
 * Used in: ClassService::getClassByIndex
 */
readonly class StartingEquipmentDto
{
    public function __construct(
        public EquipmentReferenceDto $equipment,
        public int $quantity
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            equipment: EquipmentReferenceDto::fromArray($data['equipment'] ?? []),
            quantity: $data['quantity'] ?? 0
        );
    }
}
