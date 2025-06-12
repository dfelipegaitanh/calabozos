<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for spellcasting data.
 * 
 * Used in: ClassService::getClassSpellcasting
 */
readonly class SpellcastingDto
{
    public function __construct(
        public int $level,
        public AbilityScoreReferenceDto $spellcastingAbility,
        public array $info
    ) {}
    
    public static function fromArray(array $data): self
    {
        $infoArray = [];
        foreach ($data['info'] ?? [] as $infoItem) {
            $infoArray[] = SpellcastingInfoDto::fromArray($infoItem);
        }
        
        return new self(
            level: $data['level'] ?? 0,
            spellcastingAbility: AbilityScoreReferenceDto::fromArray($data['spellcasting_ability'] ?? []),
            info: $infoArray
        );
    }
}
