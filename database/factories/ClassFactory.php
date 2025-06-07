<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ClassCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
 use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Factory for creating test instances of ClassCharacter model.
 *
 * This factory generates realistic test data for character classes
 * to be used in automated tests and database seeding.
 */
class ClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassCharacter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> Array of attributes to create a ClassCharacter instance
     */
    public function definition(): array
    {
        $index = $this->faker->name();
        $name = Str::upper($index);

        return [
            'index' => $index,
            'name' => $name,
            'url' => $this->faker->url(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
