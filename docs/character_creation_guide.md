# Step-by-Step Guide to Implementing Character Creation

This guide provides detailed implementation steps for creating a character using the D&D 5e API. It builds upon the ideas outlined in `ideas.md` and provides concrete implementation details.

## Prerequisites

Before starting implementation, ensure you have:

1. A working Laravel application
2. The `CalabozosApiClient.php` and `CalabozosApi.php` classes set up
3. Basic understanding of D&D 5e character creation rules

## Implementation Steps

### Step 1: Extend the API Client

First, extend the `CalabozosApi.php` class to include all necessary endpoints for character creation:

```php
<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Http\Client\ConnectionException;

class CalabozosApi extends CalabozosApiClient
{
    /**
     * @throws ConnectionException
     */
    public function getClasses(): array
    {
        $response = $this->get('/classes');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getClassDetails(string $class): array
    {
        $response = $this->get("/classes/{$class}");
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getRaces(): array
    {
        $response = $this->get('/races');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getRaceDetails(string $race): array
    {
        $response = $this->get("/races/{$race}");
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getBackgrounds(): array
    {
        $response = $this->get('/backgrounds');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getBackgroundDetails(string $background): array
    {
        $response = $this->get("/backgrounds/{$background}");
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getSkills(): array
    {
        $response = $this->get('/skills');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getEquipment(): array
    {
        $response = $this->get('/equipment');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getSpells(): array
    {
        $response = $this->get('/spells');
        return $response->json();
    }

    /**
     * @throws ConnectionException
     */
    public function getClassSpells(string $class): array
    {
        $response = $this->get("/classes/{$class}/spells");
        return $response->json();
    }
}
```

### Step 2: Create Database Models

Create the necessary database models to store character data:

1. Create a Character model:

```bash
php artisan make:model Character -m
```

2. Edit the migration file to include all necessary fields:

```php
public function up()
{
    Schema::create('characters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('name');
        $table->string('race');
        $table->string('class');
        $table->string('background');
        $table->integer('level')->default(1);
        $table->integer('strength');
        $table->integer('dexterity');
        $table->integer('constitution');
        $table->integer('intelligence');
        $table->integer('wisdom');
        $table->integer('charisma');
        $table->integer('hit_points');
        $table->integer('armor_class');
        $table->json('proficiencies')->nullable();
        $table->json('equipment')->nullable();
        $table->json('spells')->nullable();
        $table->json('features')->nullable();
        $table->timestamps();
    });
}
```

3. Create related models for character components as needed (e.g., CharacterSpell, CharacterEquipment).

### Step 3: Create a Character Generation Service

Create a service to handle character creation logic:

```php
<?php

namespace App\Services;

use App\Models\Character;
use App\Services\Api\CalabozosApi;
use Illuminate\Support\Facades\Auth;

class CharacterGenerationService
{
    protected CalabozosApi $api;

    public function __construct(CalabozosApi $api)
    {
        $this->api = $api;
    }

    public function createCharacter(array $data): Character
    {
        // 1. Validate input data
        // 2. Process character creation
        // 3. Save character to database
        // 4. Return the created character

        $character = new Character();
        $character->user_id = Auth::id();
        $character->name = $data['name'];
        $character->race = $data['race'];
        $character->class = $data['class'];
        $character->background = $data['background'];
        
        // Set ability scores
        $character->strength = $data['ability_scores']['strength'];
        $character->dexterity = $data['ability_scores']['dexterity'];
        $character->constitution = $data['ability_scores']['constitution'];
        $character->intelligence = $data['ability_scores']['intelligence'];
        $character->wisdom = $data['ability_scores']['wisdom'];
        $character->charisma = $data['ability_scores']['charisma'];
        
        // Calculate derived statistics
        $character->hit_points = $this->calculateHitPoints($data['class'], $character->constitution);
        $character->armor_class = $this->calculateArmorClass($character->dexterity, $data['equipment']);
        
        // Store JSON data
        $character->proficiencies = json_encode($this->getProficiencies($data));
        $character->equipment = json_encode($data['equipment']);
        $character->spells = json_encode($data['spells'] ?? []);
        $character->features = json_encode($this->getFeatures($data));
        
        $character->save();
        
        return $character;
    }

    private function calculateHitPoints(string $class, int $constitutionScore): int
    {
        $constitutionModifier = floor(($constitutionScore - 10) / 2);
        
        // Get hit die from class details
        $classDetails = $this->api->getClassDetails($class);
        $hitDie = $classDetails['hit_die'] ?? 8;
        
        // At level 1, hit points are maximum hit die + constitution modifier
        return $hitDie + $constitutionModifier;
    }

    private function calculateArmorClass(int $dexterityScore, array $equipment): int
    {
        $dexterityModifier = floor(($dexterityScore - 10) / 2);
        
        // Base AC is 10 + dexterity modifier
        $armorClass = 10 + $dexterityModifier;
        
        // Check if character has armor and adjust AC accordingly
        // This is a simplified version - actual implementation would need to check armor types
        
        return $armorClass;
    }

    private function getProficiencies(array $data): array
    {
        // Combine proficiencies from race, class, and background
        $proficiencies = [];
        
        // Add class proficiencies
        $classDetails = $this->api->getClassDetails($data['class']);
        if (isset($classDetails['proficiencies'])) {
            foreach ($classDetails['proficiencies'] as $proficiency) {
                $proficiencies[] = $proficiency['name'];
            }
        }
        
        // Add race proficiencies
        $raceDetails = $this->api->getRaceDetails($data['race']);
        if (isset($raceDetails['starting_proficiencies'])) {
            foreach ($raceDetails['starting_proficiencies'] as $proficiency) {
                $proficiencies[] = $proficiency['name'];
            }
        }
        
        // Add background proficiencies
        $backgroundDetails = $this->api->getBackgroundDetails($data['background']);
        if (isset($backgroundDetails['starting_proficiencies'])) {
            foreach ($backgroundDetails['starting_proficiencies'] as $proficiency) {
                $proficiencies[] = $proficiency['name'];
            }
        }
        
        // Add selected skill proficiencies
        if (isset($data['skill_proficiencies'])) {
            $proficiencies = array_merge($proficiencies, $data['skill_proficiencies']);
        }
        
        return array_unique($proficiencies);
    }

    private function getFeatures(array $data): array
    {
        // Combine features from race, class, and background
        $features = [];
        
        // Add class features
        $classDetails = $this->api->getClassDetails($data['class']);
        if (isset($classDetails['class_features'])) {
            foreach ($classDetails['class_features'] as $feature) {
                $features[] = [
                    'name' => $feature['name'],
                    'description' => $feature['desc'],
                    'source' => 'class'
                ];
            }
        }
        
        // Add race features
        $raceDetails = $this->api->getRaceDetails($data['race']);
        if (isset($raceDetails['traits'])) {
            foreach ($raceDetails['traits'] as $trait) {
                $features[] = [
                    'name' => $trait['name'],
                    'description' => $trait['desc'],
                    'source' => 'race'
                ];
            }
        }
        
        // Add background features
        $backgroundDetails = $this->api->getBackgroundDetails($data['background']);
        if (isset($backgroundDetails['feature'])) {
            $features[] = [
                'name' => $backgroundDetails['feature']['name'],
                'description' => $backgroundDetails['feature']['desc'],
                'source' => 'background'
            ];
        }
        
        return $features;
    }
}
```

### Step 4: Create Controllers and Routes

1. Create a CharacterController:

```bash
php artisan make:controller CharacterController --resource
```

2. Implement the controller methods:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Services\Api\CalabozosApi;
use App\Services\CharacterGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    protected CalabozosApi $api;
    protected CharacterGenerationService $characterService;

    public function __construct(CalabozosApi $api, CharacterGenerationService $characterService)
    {
        $this->api = $api;
        $this->characterService = $characterService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the characters.
     */
    public function index()
    {
        $characters = Character::where('user_id', Auth::id())->get();
        return view('characters.index', compact('characters'));
    }

    /**
     * Show the form for creating a new character.
     */
    public function create()
    {
        // Get data needed for character creation form
        $races = $this->api->getRaces();
        $classes = $this->api->getClasses();
        $backgrounds = $this->api->getBackgrounds();
        $skills = $this->api->getSkills();

        return view('characters.create', compact('races', 'classes', 'backgrounds', 'skills'));
    }

    /**
     * Store a newly created character in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'race' => 'required|string',
            'class' => 'required|string',
            'background' => 'required|string',
            'ability_scores.strength' => 'required|integer|min:3|max:20',
            'ability_scores.dexterity' => 'required|integer|min:3|max:20',
            'ability_scores.constitution' => 'required|integer|min:3|max:20',
            'ability_scores.intelligence' => 'required|integer|min:3|max:20',
            'ability_scores.wisdom' => 'required|integer|min:3|max:20',
            'ability_scores.charisma' => 'required|integer|min:3|max:20',
            'skill_proficiencies' => 'array',
            'equipment' => 'array',
            'spells' => 'array',
        ]);

        $character = $this->characterService->createCharacter($validatedData);

        return redirect()->route('characters.show', $character)
            ->with('success', 'Character created successfully!');
    }

    /**
     * Display the specified character.
     */
    public function show(Character $character)
    {
        // Ensure the character belongs to the authenticated user
        if ($character->user_id !== Auth::id()) {
            abort(403);
        }

        return view('characters.show', compact('character'));
    }

    /**
     * Show the form for editing the specified character.
     */
    public function edit(Character $character)
    {
        // Ensure the character belongs to the authenticated user
        if ($character->user_id !== Auth::id()) {
            abort(403);
        }

        $races = $this->api->getRaces();
        $classes = $this->api->getClasses();
        $backgrounds = $this->api->getBackgrounds();
        $skills = $this->api->getSkills();

        return view('characters.edit', compact('character', 'races', 'classes', 'backgrounds', 'skills'));
    }

    /**
     * Update the specified character in storage.
     */
    public function update(Request $request, Character $character)
    {
        // Ensure the character belongs to the authenticated user
        if ($character->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'race' => 'required|string',
            'class' => 'required|string',
            'background' => 'required|string',
            'ability_scores.strength' => 'required|integer|min:3|max:20',
            'ability_scores.dexterity' => 'required|integer|min:3|max:20',
            'ability_scores.constitution' => 'required|integer|min:3|max:20',
            'ability_scores.intelligence' => 'required|integer|min:3|max:20',
            'ability_scores.wisdom' => 'required|integer|min:3|max:20',
            'ability_scores.charisma' => 'required|integer|min:3|max:20',
            'skill_proficiencies' => 'array',
            'equipment' => 'array',
            'spells' => 'array',
        ]);

        // Update character using the service
        $character = $this->characterService->updateCharacter($character, $validatedData);

        return redirect()->route('characters.show', $character)
            ->with('success', 'Character updated successfully!');
    }

    /**
     * Remove the specified character from storage.
     */
    public function destroy(Character $character)
    {
        // Ensure the character belongs to the authenticated user
        if ($character->user_id !== Auth::id()) {
            abort(403);
        }

        $character->delete();

        return redirect()->route('characters.index')
            ->with('success', 'Character deleted successfully!');
    }
}
```

3. Add routes in `routes/web.php`:

```php
Route::resource('characters', CharacterController::class);
```

### Step 5: Create Views for Character Creation

Create the necessary Blade templates for character creation:

1. Create a base layout for character creation:

```html
<!-- resources/views/characters/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Character</h1>
    
    <form method="POST" action="{{ route('characters.store') }}" id="character-form">
        @csrf
        
        <!-- Multi-step form with tabs -->
        <ul class="nav nav-tabs" id="characterTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="basics-tab" data-toggle="tab" href="#basics" role="tab">1. Basics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="race-tab" data-toggle="tab" href="#race" role="tab">2. Race</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="class-tab" data-toggle="tab" href="#class" role="tab">3. Class</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="abilities-tab" data-toggle="tab" href="#abilities" role="tab">4. Abilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="background-tab" data-toggle="tab" href="#background" role="tab">5. Background</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="equipment-tab" data-toggle="tab" href="#equipment" role="tab">6. Equipment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="spells-tab" data-toggle="tab" href="#spells" role="tab">7. Spells</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab">8. Review</a>
            </li>
        </ul>
        
        <div class="tab-content" id="characterTabContent">
            <!-- Step 1: Basic Information -->
            <div class="tab-pane fade show active" id="basics" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Basic Information</h3>
                        
                        <div class="form-group">
                            <label for="name">Character Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <button type="button" class="btn btn-primary next-tab">Next: Race</button>
                    </div>
                </div>
            </div>
            
            <!-- Step 2: Race Selection -->
            <div class="tab-pane fade" id="race" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Choose Race</h3>
                        
                        <div class="form-group">
                            <label for="race">Race</label>
                            <select class="form-control" id="race" name="race" required>
                                <option value="">Select a race</option>
                                @foreach($races['results'] as $race)
                                    <option value="{{ $race['index'] }}">{{ $race['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="race-details" class="mt-4"></div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary prev-tab">Previous: Basics</button>
                            <button type="button" class="btn btn-primary next-tab">Next: Class</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional tabs for each step... -->
            
            <!-- Final Review Tab -->
            <div class="tab-pane fade" id="review" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h3>Review Your Character</h3>
                        
                        <div id="character-summary"></div>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary prev-tab">Previous: Spells</button>
                            <button type="submit" class="btn btn-success">Create Character</button>
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
            $('#characterTabs a[href="#' + nextTab.attr('id') + '"]').tab('show');
        }
    });
    
    $('.prev-tab').click(function() {
        const currentTab = $(this).closest('.tab-pane');
        const prevTab = currentTab.prev('.tab-pane');
        
        $('#characterTabs a[href="#' + prevTab.attr('id') + '"]').tab('show');
    });
    
    // Load race details when race is selected
    $('#race').change(function() {
        const selectedRace = $(this).val();
        if (selectedRace) {
            $.get('/api/races/' + selectedRace, function(data) {
                let html = '<h4>' + data.name + '</h4>';
                html += '<p>' + data.alignment + '</p>';
                html += '<h5>Ability Score Increases:</h5><ul>';
                
                data.ability_bonuses.forEach(function(bonus) {
                    html += '<li>' + bonus.ability_score.name + ': +' + bonus.bonus + '</li>';
                });
                
                html += '</ul>';
                html += '<h5>Speed:</h5><p>' + data.speed + ' feet</p>';
                
                $('#race-details').html(html);
            });
        }
    });
    
    // Similar handlers for other dynamic content...
    
    // Form submission
    $('#character-form').submit(function(e) {
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

### Step 6: Implement API Controllers

Create API controllers to fetch data from the D&D 5e API:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CalabozosApi;
use Exception;
use Illuminate\Http\JsonResponse;

class DndApiController extends Controller
{
    protected CalabozosApi $api;

    public function __construct(CalabozosApi $api)
    {
        $this->api = $api;
    }

    /**
     * Get race details.
     */
    public function getRace(string $race): JsonResponse
    {
        try {
            $raceDetails = $this->api->getRaceDetails($race);
            
            return response()->json($raceDetails);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve race details: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get class details.
     */
    public function getClass(string $class): JsonResponse
    {
        try {
            $classDetails = $this->api->getClassDetails($class);
            
            return response()->json($classDetails);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve class details: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get background details.
     */
    public function getBackground(string $background): JsonResponse
    {
        try {
            $backgroundDetails = $this->api->getBackgroundDetails($background);
            
            return response()->json($backgroundDetails);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve background details: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get spells for a class.
     */
    public function getClassSpells(string $class): JsonResponse
    {
        try {
            $spells = $this->api->getClassSpells($class);
            
            return response()->json($spells);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve spells: '.$e->getMessage(),
            ], 500);
        }
    }
}
```

Add routes in `routes/api.php`:

```php
Route::get('/races/{race}', [DndApiController::class, 'getRace']);
Route::get('/classes/{class}', [DndApiController::class, 'getClass']);
Route::get('/backgrounds/{background}', [DndApiController::class, 'getBackground']);
Route::get('/classes/{class}/spells', [DndApiController::class, 'getClassSpells']);
```

## Complete Character Creation Process

Here's a summary of the step-by-step process to create a character:

1. **Setup the Database**:
   - Run migrations to create the character table
   - Ensure relationships with users are set up

2. **Implement the API Client**:
   - Extend the CalabozosApi class with all necessary endpoints
   - Test API connections to ensure data can be retrieved

3. **Create the Character Service**:
   - Implement the CharacterGenerationService
   - Add methods for calculating derived statistics
   - Handle the integration of different character aspects

4. **Build the User Interface**:
   - Create a multi-step form for character creation
   - Implement JavaScript for dynamic content loading
   - Add validation for each step

5. **Implement Controllers**:
   - Create the CharacterController for web routes
   - Create the DndApiController for API routes
   - Add proper validation and error handling

6. **Test the Implementation**:
   - Test each step of the character creation process
   - Verify that data is correctly saved to the database
   - Ensure the character sheet displays all information correctly

## Conclusion

This guide provides a detailed implementation approach for character creation using the D&D 5e API. By following these steps, you can create a robust character creation system that integrates with the API and provides a user-friendly interface for players.

Remember to adapt this implementation to your specific requirements and to test thoroughly at each step.
