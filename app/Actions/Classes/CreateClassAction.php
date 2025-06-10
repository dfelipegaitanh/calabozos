<?php

declare(strict_types=1);

namespace App\Actions\Classes;

use App\DTOs\Classes\ClassDto;
use App\Models\ClassCharacter;

/**
 * Action to create or retrieve a ClassCharacter from a ClassDto.
 *
 * This action follows the single responsibility principle by focusing
 * on the specific business operation of creating a class character.
 */
readonly class CreateClassAction
{
    /**
     * Create or retrieve a ClassCharacter based on the provided DTO.
     *
     * If a class with the same index already exists, it returns the existing one.
     * Otherwise, it creates a new ClassCharacter instance with the DTO data.
     *
     * @param  ClassDto  $classDto  The data transfer object containing class data
     * @return ClassCharacter The created or retrieved class character model
     */
    public function handle(ClassDto $classDto): ClassCharacter
    {
        return ClassCharacter::query()->firstOrCreate(
            ['index' => $classDto->index],
            [
                'name' => $classDto->name,
                'url' => $classDto->url,
            ]
        );
    }
}
