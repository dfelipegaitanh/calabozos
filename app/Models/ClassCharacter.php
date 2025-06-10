<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * ClassCharacter model representing a character class in the game.
 *
 * This model stores the basic information about character classes
 * retrieved from the external Calabozos API.
 *
 * @property-read int $id
 * @property string $index Unique identifier for the class from the API
 * @property string $name Display name of the character class
 * @property string $url API URL for the class resource
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ClassCharacter extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classes';
}
