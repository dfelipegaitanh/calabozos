# Step-by-Step Guide to Implementing Monster Creation

This guide provides detailed implementation steps for creating and managing monsters using the D&D 5e API. It follows a similar structure to the character creation guide but is adapted specifically for monsters.

## Prerequisites

Before starting implementation, ensure you have:

1. A working Laravel application
2. The `CalabozosApiClient.php` and `CalabozosApi.php` classes set up
3. Basic understanding of D&D 5e monster mechanics

## Implementation Steps

### Step 1: Extend the API Client

First, extend the `CalabozosApi.php` class to include all necessary endpoints for monster creation:

```php
<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Http\Client\ConnectionException;

class CalabozosApi extends CalabozosApiClient
{
    // Existing methods...

    /**
     * @throws ConnectionException
     */
    public function getMonsters(): array
    {
        $response = $this->get('/monsters');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getMonsterDetails(string $monster): array
    {
        $response = $this->get("/monsters/{$monster}");
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getMonstersByChallengRating(string $cr): array
    {
        // This is a custom endpoint that would need to be implemented
        // as the D&D 5e API doesn't directly support filtering by CR
        $monsters = $this->getMonsters();
        $filteredMonsters = [];
        
        foreach ($monsters['results'] as $monster) {
            $details = $this->getMonsterDetails($monster['index']);
            if ($details['challenge_rating'] == $cr) {
                $filteredMonsters[] = $monster;
            }
        }
        
        return ['results' => $filteredMonsters];
    }

    /**
     * @throws ConnectionException
     */
    public function getMonstersByType(string $type): array
    {
        // This is a custom endpoint that would need to be implemented
        // as the D&D 5e API doesn't directly support filtering by type
        $monsters = $this->getMonsters();
        $filteredMonsters = [];
        
        foreach ($monsters['results'] as $monster) {
            $details = $this->getMonsterDetails($monster['index']);
            if ($details['type'] == $type) {
                $filteredMonsters[] = $monster;
            }
        }
        
        return ['results' => $filteredMonsters];
    }

    /**
     * @throws ConnectionException
     */
    public function getMonsterActions(string $monster): array
    {
        $monsterDetails = $this->getMonsterDetails($monster);
        return $monsterDetails['actions'] ?? [];
    }

    /**
     * @throws ConnectionException
     */
    public function getMonsterSpecialAbilities(string $monster): array
    {
        $monsterDetails = $this->getMonsterDetails($monster);
        return $monsterDetails['special_abilities'] ?? [];
    }
}
```

### Step 2: Create Database Models

Create the necessary database models to store monster data:

1. Create a Monster model:

```bash
php artisan make:model Monster -m
```

2. Edit the migration file to include all necessary fields:

```php
public function up()
{
    Schema::create('monsters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // For user-created monsters
        $table->string('name');
        $table->string('size');
        $table->string('type');
        $table->string('subtype')->nullable();
        $table->string('alignment');
        $table->integer('armor_class');
        $table->integer('hit_points');
        $table->string('hit_dice');
        $table->integer('strength');
        $table->integer('dexterity');
        $table->integer('constitution');
        $table->integer('intelligence');
        $table->integer('wisdom');
        $table->integer('charisma');
        $table->decimal('challenge_rating', 4, 2);
        $table->integer('xp');
        $table->json('speed')->nullable();
        $table->json('senses')->nullable();
        $table->json('saving_throws')->nullable();
        $table->json('skills')->nullable();
        $table->json('damage_vulnerabilities')->nullable();
        $table->json('damage_resistances')->nullable();
        $table->json('damage_immunities')->nullable();
        $table->json('condition_immunities')->nullable();
        $table->json('languages')->nullable();
        $table->json('special_abilities')->nullable();
        $table->json('actions')->nullable();
        $table->json('legendary_actions')->nullable();
        $table->json('reactions')->nullable();
        $table->boolean('is_custom')->default(false);
        $table->boolean('is_template')->default(false);
        $table->timestamps();
    });
}
```

3. Create related models for monster components as needed (e.g., MonsterAction, MonsterAbility).

### Step 3: Create a Monster Generation Service

Create a service to handle monster creation and management:

```php
<?php

namespace App\Services;

use App\Models\Monster;
use App\Services\Api\CalabozosApi;
use Illuminate\Support\Facades\Auth;

class MonsterGenerationService
{
    protected CalabozosApi $api;

    public function __construct(CalabozosApi $api)
    {
        $this->api = $api;
    }

    /**
     * Create a new monster from API data or custom input
     */
    public function createMonster(array $data): Monster
    {
        // 1. Validate input data
        // 2. Process monster creation
        // 3. Save monster to database
        // 4. Return the created monster

        $monster = new Monster();
        $monster->user_id = Auth::id();
        $monster->name = $data['name'];
        $monster->size = $data['size'];
        $monster->type = $data['type'];
        $monster->subtype = $data['subtype'] ?? null;
        $monster->alignment = $data['alignment'];
        
        // Set ability scores
        $monster->strength = $data['ability_scores']['strength'];
        $monster->dexterity = $data['ability_scores']['dexterity'];
        $monster->constitution = $data['ability_scores']['constitution'];
        $monster->intelligence = $data['ability_scores']['intelligence'];
        $monster->wisdom = $data['ability_scores']['wisdom'];
        $monster->charisma = $data['ability_scores']['charisma'];
        
        // Set combat stats
        $monster->armor_class = $data['armor_class'];
        $monster->hit_points = $data['hit_points'];
        $monster->hit_dice = $data['hit_dice'];
        $monster->challenge_rating = $data['challenge_rating'];
        $monster->xp = $this->calculateXP($data['challenge_rating']);
        
        // Store JSON data
        $monster->speed = json_encode($data['speed']);
        $monster->senses = json_encode($data['senses'] ?? []);
        $monster->saving_throws = json_encode($data['saving_throws'] ?? []);
        $monster->skills = json_encode($data['skills'] ?? []);
        $monster->damage_vulnerabilities = json_encode($data['damage_vulnerabilities'] ?? []);
        $monster->damage_resistances = json_encode($data['damage_resistances'] ?? []);
        $monster->damage_immunities = json_encode($data['damage_immunities'] ?? []);
        $monster->condition_immunities = json_encode($data['condition_immunities'] ?? []);
        $monster->languages = json_encode($data['languages'] ?? []);
        $monster->special_abilities = json_encode($data['special_abilities'] ?? []);
        $monster->actions = json_encode($data['actions'] ?? []);
        $monster->legendary_actions = json_encode($data['legendary_actions'] ?? []);
        $monster->reactions = json_encode($data['reactions'] ?? []);
        
        // Set flags
        $monster->is_custom = $data['is_custom'] ?? false;
        $monster->is_template = $data['is_template'] ?? false;
        
        $monster->save();
        
        return $monster;
    }

    /**
     * Import a monster from the D&D 5e API
     */
    public function importMonsterFromApi(string $monsterIndex): Monster
    {
        $monsterData = $this->api->getMonsterDetails($monsterIndex);
        
        // Transform API data to match our database structure
        $data = [
            'name' => $monsterData['name'],
            'size' => $monsterData['size'],
            'type' => $monsterData['type'],
            'subtype' => $monsterData['subtype'] ?? null,
            'alignment' => $monsterData['alignment'],
            'armor_class' => $monsterData['armor_class'],
            'hit_points' => $monsterData['hit_points'],
            'hit_dice' => $monsterData['hit_dice'],
            'ability_scores' => [
                'strength' => $monsterData['strength'],
                'dexterity' => $monsterData['dexterity'],
                'constitution' => $monsterData['constitution'],
                'intelligence' => $monsterData['intelligence'],
                'wisdom' => $monsterData['wisdom'],
                'charisma' => $monsterData['charisma'],
            ],
            'challenge_rating' => $monsterData['challenge_rating'],
            'speed' => $monsterData['speed'],
            'senses' => $monsterData['senses'] ?? [],
            'saving_throws' => $this->extractSavingThrows($monsterData),
            'skills' => $monsterData['proficiencies'] ? $this->extractSkills($monsterData['proficiencies']) : [],
            'damage_vulnerabilities' => $monsterData['damage_vulnerabilities'] ?? [],
            'damage_resistances' => $monsterData['damage_resistances'] ?? [],
            'damage_immunities' => $monsterData['damage_immunities'] ?? [],
            'condition_immunities' => $monsterData['condition_immunities'] ? 
                array_map(function($item) { return $item['name']; }, $monsterData['condition_immunities']) : [],
            'languages' => $monsterData['languages'] ? explode(', ', $monsterData['languages']) : [],
            'special_abilities' => $monsterData['special_abilities'] ?? [],
            'actions' => $monsterData['actions'] ?? [],
            'legendary_actions' => $monsterData['legendary_actions'] ?? [],
            'reactions' => $monsterData['reactions'] ?? [],
            'is_custom' => false,
            'is_template' => false,
        ];
        
        return $this->createMonster($data);
    }

    /**
     * Create a custom monster based on a template
     */
    public function createCustomMonster(array $data, ?int $templateId = null): Monster
    {
        if ($templateId) {
            // Load template monster and use as base
            $template = Monster::findOrFail($templateId);
            
            // Merge template data with custom data
            $data = array_merge($this->monsterToArray($template), $data);
        }
        
        $data['is_custom'] = true;
        
        return $this->createMonster($data);
    }

    /**
     * Save a monster as a template for future use
     */
    public function saveAsTemplate(Monster $monster): Monster
    {
        $templateData = $this->monsterToArray($monster);
        $templateData['name'] = $templateData['name'] . ' (Template)';
        $templateData['is_template'] = true;
        
        return $this->createMonster($templateData);
    }

    /**
     * Calculate XP based on challenge rating
     */
    private function calculateXP(float $challengeRating): int
    {
        // CR to XP conversion table
        $crToXp = [
            0 => 10,
            0.125 => 25,
            0.25 => 50,
            0.5 => 100,
            1 => 200,
            2 => 450,
            3 => 700,
            4 => 1100,
            5 => 1800,
            6 => 2300,
            7 => 2900,
            8 => 3900,
            9 => 5000,
            10 => 5900,
            11 => 7200,
            12 => 8400,
            13 => 10000,
            14 => 11500,
            15 => 13000,
            16 => 15000,
            17 => 18000,
            18 => 20000,
            19 => 22000,
            20 => 25000,
            21 => 33000,
            22 => 41000,
            23 => 50000,
            24 => 62000,
            25 => 75000,
            26 => 90000,
            27 => 105000,
            28 => 120000,
            29 => 135000,
            30 => 155000,
        ];
        
        return $crToXp[$challengeRating] ?? 0;
    }

    /**
     * Extract saving throw proficiencies from monster data
     */
    private function extractSavingThrows(array $monsterData): array
    {
        $savingThrows = [];
        
        if (isset($monsterData['proficiencies'])) {
            foreach ($monsterData['proficiencies'] as $proficiency) {
                if (strpos($proficiency['proficiency']['index'], 'saving-throw') !== false) {
                    $ability = str_replace('saving-throw-', '', $proficiency['proficiency']['index']);
                    $savingThrows[$ability] = $proficiency['value'];
                }
            }
        }
        
        return $savingThrows;
    }

    /**
     * Extract skill proficiencies from monster data
     */
    private function extractSkills(array $proficiencies): array
    {
        $skills = [];
        
        foreach ($proficiencies as $proficiency) {
            if (strpos($proficiency['proficiency']['index'], 'skill') !== false) {
                $skill = str_replace('skill-', '', $proficiency['proficiency']['index']);
                $skills[$skill] = $proficiency['value'];
            }
        }
        
        return $skills;
    }

    /**
     * Convert a Monster model to an array for reuse
     */
    private function monsterToArray(Monster $monster): array
    {
        return [
            'name' => $monster->name,
            'size' => $monster->size,
            'type' => $monster->type,
            'subtype' => $monster->subtype,
            'alignment' => $monster->alignment,
            'armor_class' => $monster->armor_class,
            'hit_points' => $monster->hit_points,
            'hit_dice' => $monster->hit_dice,
            'ability_scores' => [
                'strength' => $monster->strength,
                'dexterity' => $monster->dexterity,
                'constitution' => $monster->constitution,
                'intelligence' => $monster->intelligence,
                'wisdom' => $monster->wisdom,
                'charisma' => $monster->charisma,
            ],
            'challenge_rating' => $monster->challenge_rating,
            'speed' => json_decode($monster->speed, true),
            'senses' => json_decode($monster->senses, true),
            'saving_throws' => json_decode($monster->saving_throws, true),
            'skills' => json_decode($monster->skills, true),
            'damage_vulnerabilities' => json_decode($monster->damage_vulnerabilities, true),
            'damage_resistances' => json_decode($monster->damage_resistances, true),
            'damage_immunities' => json_decode($monster->damage_immunities, true),
            'condition_immunities' => json_decode($monster->condition_immunities, true),
            'languages' => json_decode($monster->languages, true),
            'special_abilities' => json_decode($monster->special_abilities, true),
            'actions' => json_decode($monster->actions, true),
            'legendary_actions' => json_decode($monster->legendary_actions, true),
            'reactions' => json_decode($monster->reactions, true),
            'is_custom' => $monster->is_custom,
            'is_template' => $monster->is_template,
        ];
    }
}
```

### Step 4: Create Controllers and Routes

1. Create a MonsterController:

```bash
php artisan make:controller MonsterController --resource
```

2. Implement the controller methods:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Services\Api\CalabozosApi;
use App\Services\MonsterGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonsterController extends Controller
{
    protected CalabozosApi $api;
    protected MonsterGenerationService $monsterService;

    public function __construct(CalabozosApi $api, MonsterGenerationService $monsterService)
    {
        $this->api = $api;
        $this->monsterService = $monsterService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the monsters.
     */
    public function index()
    {
        $monsters = Monster::where('user_id', Auth::id())
            ->where('is_template', false)
            ->get();
            
        return view('monsters.index', compact('monsters'));
    }

    /**
     * Show the form for creating a new monster.
     */
    public function create()
    {
        // Get data needed for monster creation form
        $monsterTypes = [
            'aberration', 'beast', 'celestial', 'construct', 'dragon', 
            'elemental', 'fey', 'fiend', 'giant', 'humanoid', 
            'monstrosity', 'ooze', 'plant', 'undead'
        ];
        
        $sizes = ['Tiny', 'Small', 'Medium', 'Large', 'Huge', 'Gargantuan'];
        
        $alignments = [
            'lawful good', 'neutral good', 'chaotic good',
            'lawful neutral', 'neutral', 'chaotic neutral',
            'lawful evil', 'neutral evil', 'chaotic evil',
            'unaligned', 'any alignment'
        ];
        
        $challengeRatings = [
            0, 0.125, 0.25, 0.5, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
            24, 25, 26, 27, 28, 29, 30
        ];
        
        $templates = Monster::where('is_template', true)->get();

        return view('monsters.create', compact(
            'monsterTypes', 'sizes', 'alignments', 'challengeRatings', 'templates'
        ));
    }

    /**
     * Store a newly created monster in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string',
            'type' => 'required|string',
            'subtype' => 'nullable|string',
            'alignment' => 'required|string',
            'armor_class' => 'required|integer|min:0',
            'hit_points' => 'required|integer|min:1',
            'hit_dice' => 'required|string',
            'ability_scores.strength' => 'required|integer|min:1|max:30',
            'ability_scores.dexterity' => 'required|integer|min:1|max:30',
            'ability_scores.constitution' => 'required|integer|min:1|max:30',
            'ability_scores.intelligence' => 'required|integer|min:1|max:30',
            'ability_scores.wisdom' => 'required|integer|min:1|max:30',
            'ability_scores.charisma' => 'required|integer|min:1|max:30',
            'challenge_rating' => 'required|numeric|min:0|max:30',
            'speed' => 'required|array',
            'senses' => 'nullable|array',
            'saving_throws' => 'nullable|array',
            'skills' => 'nullable|array',
            'damage_vulnerabilities' => 'nullable|array',
            'damage_resistances' => 'nullable|array',
            'damage_immunities' => 'nullable|array',
            'condition_immunities' => 'nullable|array',
            'languages' => 'nullable|array',
            'special_abilities' => 'nullable|array',
            'actions' => 'nullable|array',
            'legendary_actions' => 'nullable|array',
            'reactions' => 'nullable|array',
            'template_id' => 'nullable|integer|exists:monsters,id',
        ]);

        $monster = $this->monsterService->createCustomMonster(
            $validatedData, 
            $request->input('template_id')
        );

        return redirect()->route('monsters.show', $monster)
            ->with('success', 'Monster created successfully!');
    }

    /**
     * Display the specified monster.
     */
    public function show(Monster $monster)
    {
        // Ensure the monster belongs to the authenticated user
        if ($monster->user_id !== Auth::id() && !$monster->is_template) {
            abort(403);
        }

        return view('monsters.show', compact('monster'));
    }

    /**
     * Show the form for editing the specified monster.
     */
    public function edit(Monster $monster)
    {
        // Ensure the monster belongs to the authenticated user
        if ($monster->user_id !== Auth::id()) {
            abort(403);
        }

        $monsterTypes = [
            'aberration', 'beast', 'celestial', 'construct', 'dragon', 
            'elemental', 'fey', 'fiend', 'giant', 'humanoid', 
            'monstrosity', 'ooze', 'plant', 'undead'
        ];
        
        $sizes = ['Tiny', 'Small', 'Medium', 'Large', 'Huge', 'Gargantuan'];
        
        $alignments = [
            'lawful good', 'neutral good', 'chaotic good',
            'lawful neutral', 'neutral', 'chaotic neutral',
            'lawful evil', 'neutral evil', 'chaotic evil',
            'unaligned', 'any alignment'
        ];
        
        $challengeRatings = [
            0, 0.125, 0.25, 0.5, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
            24, 25, 26, 27, 28, 29, 30
        ];

        return view('monsters.edit', compact(
            'monster', 'monsterTypes', 'sizes', 'alignments', 'challengeRatings'
        ));
    }

    /**
     * Update the specified monster in storage.
     */
    public function update(Request $request, Monster $monster)
    {
        // Ensure the monster belongs to the authenticated user
        if ($monster->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string',
            'type' => 'required|string',
            'subtype' => 'nullable|string',
            'alignment' => 'required|string',
            'armor_class' => 'required|integer|min:0',
            'hit_points' => 'required|integer|min:1',
            'hit_dice' => 'required|string',
            'ability_scores.strength' => 'required|integer|min:1|max:30',
            'ability_scores.dexterity' => 'required|integer|min:1|max:30',
            'ability_scores.constitution' => 'required|integer|min:1|max:30',
            'ability_scores.intelligence' => 'required|integer|min:1|max:30',
            'ability_scores.wisdom' => 'required|integer|min:1|max:30',
            'ability_scores.charisma' => 'required|integer|min:1|max:30',
            'challenge_rating' => 'required|numeric|min:0|max:30',
            'speed' => 'required|array',
            'senses' => 'nullable|array',
            'saving_throws' => 'nullable|array',
            'skills' => 'nullable|array',
            'damage_vulnerabilities' => 'nullable|array',
            'damage_resistances' => 'nullable|array',
            'damage_immunities' => 'nullable|array',
            'condition_immunities' => 'nullable|array',
            'languages' => 'nullable|array',
            'special_abilities' => 'nullable|array',
            'actions' => 'nullable|array',
            'legendary_actions' => 'nullable|array',
            'reactions' => 'nullable|array',
        ]);

        // Update monster using the service
        $monster = $this->monsterService->updateMonster($monster, $validatedData);

        return redirect()->route('monsters.show', $monster)
            ->with('success', 'Monster updated successfully!');
    }

    /**
     * Remove the specified monster from storage.
     */
    public function destroy(Monster $monster)
    {
        // Ensure the monster belongs to the authenticated user
        if ($monster->user_id !== Auth::id()) {
            abort(403);
        }

        $monster->delete();

        return redirect()->route('monsters.index')
            ->with('success', 'Monster deleted successfully!');
    }

    /**
     * Save a monster as a template.
     */
    public function saveAsTemplate(Monster $monster)
    {
        // Ensure the monster belongs to the authenticated user
        if ($monster->user_id !== Auth::id()) {
            abort(403);
        }

        $template = $this->monsterService->saveAsTemplate($monster);

        return redirect()->route('monsters.templates')
            ->with('success', 'Monster saved as template successfully!');
    }

    /**
     * Display a listing of monster templates.
     */
    public function templates()
    {
        $templates = Monster::where(function($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('user_id', null);
        })->where('is_template', true)->get();
            
        return view('monsters.templates', compact('templates'));
    }

    /**
     * Show the form for importing a monster from the API.
     */
    public function importForm()
    {
        $apiMonsters = $this->api->getMonsters();
        
        return view('monsters.import', compact('apiMonsters'));
    }

    /**
     * Import a monster from the API.
     */
    public function import(Request $request)
    {
        $validatedData = $request->validate([
            'monster_index' => 'required|string',
        ]);

        $monster = $this->monsterService->importMonsterFromApi($validatedData['monster_index']);

        return redirect()->route('monsters.show', $monster)
            ->with('success', 'Monster imported successfully!');
    }
}
```

3. Add routes in `routes/web.php`:

```php
Route::resource('monsters', MonsterController::class);
Route::get('monsters/{monster}/save-as-template', [MonsterController::class, 'saveAsTemplate'])->name('monsters.save-as-template');
Route::get('monster-templates', [MonsterController::class, 'templates'])->name('monsters.templates');
Route::get('monsters-import', [MonsterController::class, 'importForm'])->name('monsters.import-form');
Route::post('monsters-import', [MonsterController::class, 'import'])->name('monsters.import');
```

### Step 5: Create Views for Monster Management

Create the necessary Blade templates for monster management:

1. Create a base layout for monster creation:

```html
<!-- resources/views/monsters/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Monster</h1>
    
    <form method="POST" action="{{ route('monsters.store') }}" id="monster-form">
        @csrf
        
        <!-- Multi-step form with tabs -->
        <ul class="nav nav-tabs" id="monsterTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="basics-tab" data-toggle="tab" href="#basics" role="tab">1. Basics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="abilities-tab" data-toggle="tab" href="#abilities" role="tab">2. Abilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="combat-tab" data-toggle="tab" href="#combat" role="tab">3. Combat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="features-tab" data-toggle="tab" href="#features" role="tab">4. Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="actions-tab" data-toggle="tab" href="#actions" role="tab">5. Actions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab">6. Review</a>
            </li>
        </ul>
        
        <div class="tab-content" id="monsterTabContent">
            <!-- Step 1: Basic Information -->
            <div class="tab-pane fade show active" id="basics" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Basic Information</h3>
                        
                        <div class="form-group">
                            <label for="template_id">Start from Template (Optional)</label>
                            <select class="form-control" id="template_id" name="template_id">
                                <option value="">Create from scratch</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Selecting a template will pre-fill the form with the template's values.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Monster Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="size">Size</label>
                            <select class="form-control" id="size" name="size" required>
                                <option value="">Select a size</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select a type</option>
                                @foreach($monsterTypes as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="subtype">Subtype (Optional)</label>
                            <input type="text" class="form-control" id="subtype" name="subtype">
                        </div>
                        
                        <div class="form-group">
                            <label for="alignment">Alignment</label>
                            <select class="form-control" id="alignment" name="alignment" required>
                                <option value="">Select an alignment</option>
                                @foreach($alignments as $alignment)
                                    <option value="{{ $alignment }}">{{ ucfirst($alignment) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="languages">Languages</label>
                            <input type="text" class="form-control" id="languages" name="languages" placeholder="Common, Elvish, etc.">
                            <small class="form-text text-muted">
                                Separate multiple languages with commas.
                            </small>
                        </div>
                        
                        <button type="button" class="btn btn-primary next-tab">Next: Abilities</button>
                    </div>
                </div>
            </div>
            
            <!-- Step 2: Ability Scores -->
            <div class="tab-pane fade" id="abilities" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Ability Scores</h3>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[strength]">Strength</label>
                                    <input type="number" class="form-control" id="ability_scores[strength]" name="ability_scores[strength]" min="1" max="30" required>
                                    <div class="ability-modifier" id="str-modifier"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[dexterity]">Dexterity</label>
                                    <input type="number" class="form-control" id="ability_scores[dexterity]" name="ability_scores[dexterity]" min="1" max="30" required>
                                    <div class="ability-modifier" id="dex-modifier"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[constitution]">Constitution</label>
                                    <input type="number" class="form-control" id="ability_scores[constitution]" name="ability_scores[constitution]" min="1" max="30" required>
                                    <div class="ability-modifier" id="con-modifier"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[intelligence]">Intelligence</label>
                                    <input type="number" class="form-control" id="ability_scores[intelligence]" name="ability_scores[intelligence]" min="1" max="30" required>
                                    <div class="ability-modifier" id="int-modifier"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[wisdom]">Wisdom</label>
                                    <input type="number" class="form-control" id="ability_scores[wisdom]" name="ability_scores[wisdom]" min="1" max="30" required>
                                    <div class="ability-modifier" id="wis-modifier"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ability_scores[charisma]">Charisma</label>
                                    <input type="number" class="form-control" id="ability_scores[charisma]" name="ability_scores[charisma]" min="1" max="30" required>
                                    <div class="ability-modifier" id="cha-modifier"></div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mt-4">Saving Throws</h4>
                        <p>Select which saving throws this monster is proficient in:</p>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_str" name="saving_throws[str]">
                                    <label class="form-check-label" for="saving_throw_str">
                                        Strength
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_dex" name="saving_throws[dex]">
                                    <label class="form-check-label" for="saving_throw_dex">
                                        Dexterity
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_con" name="saving_throws[con]">
                                    <label class="form-check-label" for="saving_throw_con">
                                        Constitution
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_int" name="saving_throws[int]">
                                    <label class="form-check-label" for="saving_throw_int">
                                        Intelligence
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_wis" name="saving_throws[wis]">
                                    <label class="form-check-label" for="saving_throw_wis">
                                        Wisdom
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="saving_throw_cha" name="saving_throws[cha]">
                                    <label class="form-check-label" for="saving_throw_cha">
                                        Charisma
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary prev-tab">Previous: Basics</button>
                            <button type="button" class="btn btn-primary next-tab">Next: Combat</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional tabs for each step... -->
            
            <!-- Final Review Tab -->
            <div class="tab-pane fade" id="review" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Review Your Monster</h3>
                        
                        <div id="monster-summary"></div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary prev-tab">Previous: Actions</button>
                            <button type="submit" class="btn btn-success">Create Monster</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// JavaScript to handle tab navigation and dynamic content loading
$(document).ready(function() {
    // Tab navigation
    $('.next-tab').click(function() {
        const currentTab = $(this).closest('.tab-pane');
        const nextTab = currentTab.next('.tab-pane');
        
        // Validate current tab before proceeding
        if (validateTab(currentTab)) {
            $('#monsterTabs a[href="#' + nextTab.attr('id') + '"]').tab('show');
        }
    });
    
    $('.prev-tab').click(function() {
        const currentTab = $(this).closest('.tab-pane');
        const prevTab = currentTab.prev('.tab-pane');
        
        $('#monsterTabs a[href="#' + prevTab.attr('id') + '"]').tab('show');
    });
    
    // Calculate ability modifiers
    $('input[id^="ability_scores"]').change(function() {
        const ability = $(this).attr('id').match(/\[(.*?)\]/)[1];
        const score = parseInt($(this).val());
        const modifier = Math.floor((score - 10) / 2);
        
        const modifierText = modifier >= 0 ? '+' + modifier : modifier;
        $('#' + ability.substring(0, 3) + '-modifier').text('Modifier: ' + modifierText);
    });
    
    // Load template data when selected
    $('#template_id').change(function() {
        const templateId = $(this).val();
        if (templateId) {
            $.get('/api/monster-templates/' + templateId, function(data) {
                // Populate form fields with template data
                $('#name').val(data.name.replace(' (Template)', ''));
                $('#size').val(data.size);
                $('#type').val(data.type);
                $('#subtype').val(data.subtype);
                $('#alignment').val(data.alignment);
                
                // Populate ability scores
                $('input[name="ability_scores[strength]"]').val(data.strength).trigger('change');
                $('input[name="ability_scores[dexterity]"]').val(data.dexterity).trigger('change');
                $('input[name="ability_scores[constitution]"]').val(data.constitution).trigger('change');
                $('input[name="ability_scores[intelligence]"]').val(data.intelligence).trigger('change');
                $('input[name="ability_scores[wisdom]"]').val(data.wisdom).trigger('change');
                $('input[name="ability_scores[charisma]"]').val(data.charisma).trigger('change');
                
                // Populate other fields...
            });
        }
    });
    
    // Form submission
    $('#monster-form').submit(function(e) {
        e.preventDefault();
        
        // Final validation
        if (validateForm()) {
            // Submit the form
            this.submit();
        }
    });
    
    // Validation functions
    function validateTab(tab) {
        // Implement validation logic for each tab
        return true;
    }
    
    function validateForm() {
        // Implement final form validation
        return true;
    }
});
</script>
@endsection
```

2. Create a view for importing monsters from the API:

```html
<!-- resources/views/monsters/import.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Import Monster from D&D 5e API</h1>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('monsters.import') }}">
                @csrf
                
                <div class="form-group">
                    <label for="monster_index">Select Monster</label>
                    <select class="form-control" id="monster_index" name="monster_index" required>
                        <option value="">Select a monster to import</option>
                        @foreach($apiMonsters['results'] as $monster)
                            <option value="{{ $monster['index'] }}">{{ $monster['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="monster-preview" class="mt-4"></div>
                
                <button type="submit" class="btn btn-primary mt-3">Import Monster</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load monster details when selected
    $('#monster_index').change(function() {
        const monsterIndex = $(this).val();
        if (monsterIndex) {
            $.get('/api/monsters/' + monsterIndex, function(data) {
                let html = '<h3>' + data.name + '</h3>';
                html += '<p><strong>Type:</strong> ' + data.size + ' ' + data.type;
                if (data.subtype) {
                    html += ' (' + data.subtype + ')';
                }
                html += ', ' + data.alignment + '</p>';
                
                html += '<p><strong>Armor Class:</strong> ' + data.armor_class + '</p>';
                html += '<p><strong>Hit Points:</strong> ' + data.hit_points + ' (' + data.hit_dice + ')</p>';
                
                html += '<h4>Ability Scores</h4>';
                html += '<div class="row">';
                html += '<div class="col-md-2"><strong>STR:</strong> ' + data.strength + '</div>';
                html += '<div class="col-md-2"><strong>DEX:</strong> ' + data.dexterity + '</div>';
                html += '<div class="col-md-2"><strong>CON:</strong> ' + data.constitution + '</div>';
                html += '<div class="col-md-2"><strong>INT:</strong> ' + data.intelligence + '</div>';
                html += '<div class="col-md-2"><strong>WIS:</strong> ' + data.wisdom + '</div>';
                html += '<div class="col-md-2"><strong>CHA:</strong> ' + data.charisma + '</div>';
                html += '</div>';
                
                $('#monster-preview').html(html);
            });
        } else {
            $('#monster-preview').html('');
        }
    });
});
</script>
@endsection
```

### Step 6: Implement API Controllers

Create API controllers to fetch data from the D&D 5e API:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Monster;
use App\Services\Api\CalabozosApi;
use Exception;
use Illuminate\Http\JsonResponse;

class MonsterApiController extends Controller
{
    protected CalabozosApi $api;

    public function __construct(CalabozosApi $api)
    {
        $this->api = $api;
    }

    /**
     * Get monster details from the D&D 5e API.
     */
    public function getMonster(string $monster): JsonResponse
    {
        try {
            $monsterDetails = $this->api->getMonsterDetails($monster);
            
            return response()->json($monsterDetails);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve monster details: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get monster template details.
     */
    public function getMonsterTemplate(Monster $monster): JsonResponse
    {
        // Ensure the monster is a template
        if (!$monster->is_template) {
            return response()->json([
                'status' => 'error',
                'message' => 'The requested monster is not a template.',
            ], 400);
        }

        return response()->json($monster);
    }

    /**
     * Get monsters by challenge rating.
     */
    public function getMonstersByCR(string $cr): JsonResponse
    {
        try {
            $monsters = $this->api->getMonstersByChallengRating($cr);
            
            return response()->json($monsters);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve monsters: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get monsters by type.
     */
    public function getMonstersByType(string $type): JsonResponse
    {
        try {
            $monsters = $this->api->getMonstersByType($type);
            
            return response()->json($monsters);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve monsters: '.$e->getMessage(),
            ], 500);
        }
    }
}
```

Add routes in `routes/api.php`:

```php
Route::get('/monsters/{monster}', [MonsterApiController::class, 'getMonster']);
Route::get('/monster-templates/{monster}', [MonsterApiController::class, 'getMonsterTemplate']);
Route::get('/monsters/cr/{cr}', [MonsterApiController::class, 'getMonstersByCR']);
Route::get('/monsters/type/{type}', [MonsterApiController::class, 'getMonstersByType']);
```

## Complete Monster Creation Process

Here's a summary of the step-by-step process to create and manage monsters:

1. **Setup the Database**:
   - Run migrations to create the monster table
   - Ensure relationships with users are set up

2. **Implement the API Client**:
   - Extend the CalabozosApi class with monster-related endpoints
   - Test API connections to ensure data can be retrieved

3. **Create the Monster Service**:
   - Implement the MonsterGenerationService
   - Add methods for importing monsters from the API
   - Add methods for creating custom monsters
   - Add methods for managing monster templates

4. **Build the User Interface**:
   - Create a multi-step form for monster creation
   - Implement JavaScript for dynamic content loading
   - Add validation for each step
   - Create views for monster listing, viewing, and editing

5. **Implement Controllers**:
   - Create the MonsterController for web routes
   - Create the MonsterApiController for API routes
   - Add proper validation and error handling

6. **Test the Implementation**:
   - Test each step of the monster creation process
   - Verify that data is correctly saved to the database
   - Ensure the monster details display correctly

## Additional Features

1. **Monster Templates**:
   - Allow users to save monsters as templates
   - Use templates as starting points for new monsters
   - Share templates with other users

2. **Monster Import**:
   - Import monsters directly from the D&D 5e API
   - Customize imported monsters as needed

3. **Monster Filtering**:
   - Filter monsters by challenge rating
   - Filter monsters by type
   - Search monsters by name or abilities

4. **Encounter Building**:
   - Create encounters with multiple monsters
   - Calculate encounter difficulty based on party level
   - Track monster health and status during combat

## Conclusion

This guide provides a detailed implementation approach for monster creation and management using the D&D 5e API. By following these steps, you can create a robust monster management system that integrates with the API and provides a user-friendly interface for Dungeon Masters.

Remember to adapt this implementation to your specific requirements and to test thoroughly at each step.
