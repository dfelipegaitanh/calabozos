# Ideas for Character Generation using D&D 5e API

This document outlines ideas, steps, and suggestions for implementing character generation using the [D&D 5e API](https://5e-bits.github.io/docs/api). The current implementation already includes functionality to fetch classes from the API.

## Character Creation Process

### 1. Basic Character Setup
- [ ] Create a character model/entity to store character data
- [ ] Implement a character creation form/interface
- [ ] Generate random character name or allow user input

### 2. Race Selection
- [ ] Fetch available races from the API (`/api/races`)
- [ ] Display race options to the user
- [ ] Store selected race and apply racial traits
- [ ] Implement subraces where applicable (`/api/races/{race}/subraces`)
- [ ] Apply racial ability score bonuses

### 3. Class Selection
- [ ] Use existing class fetching functionality (`/api/classes`)
- [ ] Display class options to the user
- [ ] Store selected class
- [ ] Fetch and apply class-specific features (`/api/classes/{class}`)
- [ ] Implement starting equipment based on class (`/api/classes/{class}/starting-equipment`)

### 4. Ability Scores
- [ ] Implement ability score generation methods:
  - [ ] Standard array (15, 14, 13, 12, 10, 8)
  - [ ] Point buy system
  - [ ] Random dice rolls (4d6 drop lowest)
- [ ] Allow manual assignment of scores to abilities
- [ ] Calculate and display ability modifiers
- [ ] Apply racial bonuses to ability scores

### 5. Background Selection
- [ ] Fetch available backgrounds from the API (`/api/backgrounds`)
- [ ] Display background options to the user
- [ ] Apply background features, proficiencies, and equipment

### 6. Skills and Proficiencies
- [ ] Fetch available skills from the API (`/api/skills`)
- [ ] Allow selection of skill proficiencies based on class and background
- [ ] Fetch and apply proficiency bonus (`/api/proficiency-bonus`)
- [ ] Implement tool, weapon, and armor proficiencies

### 7. Equipment and Items
- [ ] Fetch equipment from the API (`/api/equipment`)
- [ ] Implement starting equipment based on class and background
- [ ] Allow customization of equipment within constraints
- [ ] Calculate armor class based on equipment and ability scores

### 8. Spells (for spellcasting classes)
- [ ] Fetch available spells from the API (`/api/spells`)
- [ ] Filter spells by class
- [ ] Implement spell selection based on class restrictions
- [ ] Calculate spell save DC and attack bonus

### 9. Character Sheet Generation
- [ ] Compile all character data into a comprehensive character sheet
- [ ] Calculate derived statistics (initiative, saving throws, etc.)
- [ ] Generate a printable/exportable version

## API Implementation Ideas

### Extending the Current API Client
- [ ] Add methods to `CalabozosApi.php` for each required endpoint:
  ```php
  public function getRaces(): array
  {
      $response = $this->get('/races');
      return $response->json();
  }
  
  public function getRaceDetails(string $race): array
  {
      $response = $this->get("/races/{$race}");
      return $response->json();
  }
  
  public function getClassDetails(string $class): array
  {
      $response = $this->get("/classes/{$class}");
      return $response->json();
  }
  
  // Additional methods for other endpoints
  ```

### Character Generation Service
- [ ] Create a `CharacterGenerationService` to orchestrate the character creation process
- [ ] Implement validation for character creation choices
- [ ] Handle the integration of different character aspects (race, class, abilities, etc.)

### Database Structure
- [ ] Design database tables to store character data
- [ ] Create relationships between character and their features
- [ ] Implement caching of API responses to reduce API calls

### User Interface Considerations
- [ ] Create a step-by-step wizard for character creation
- [ ] Implement real-time updates as choices are made
- [ ] Provide tooltips and help text for D&D concepts
- [ ] Add visualization of character stats and features

## Next Steps
- [ ] Prioritize the implementation of core features
- [ ] Create detailed specifications for each component
- [ ] Develop a testing strategy for character generation
- [ ] Consider how to handle homebrew content or house rules
