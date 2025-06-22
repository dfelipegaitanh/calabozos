<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Dungeon;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller for displaying Dungeons & Dragons race data in web views.
 *
 * This controller is responsible for providing race data
 * and displaying it in web views.
 */
class RaceDisplayController extends Controller
{
    /**
     * Display all available character races.
     *
     * This method provides race data and renders the Races page.
     */
    public function index(): Response
    {
        // Mocked race data
        $races = [
            [
                'index' => 'dragonborn',
                'name' => 'Dragonborn',
                'url' => '/api/2014/races/dragonborn',
            ],
            [
                'index' => 'dwarf',
                'name' => 'Dwarf',
                'url' => '/api/2014/races/dwarf',
            ],
            [
                'index' => 'elf',
                'name' => 'Elf',
                'url' => '/api/2014/races/elf',
            ],
            [
                'index' => 'gnome',
                'name' => 'Gnome',
                'url' => '/api/2014/races/gnome',
            ],
            [
                'index' => 'half-elf',
                'name' => 'Half-Elf',
                'url' => '/api/2014/races/half-elf',
            ],
            [
                'index' => 'half-orc',
                'name' => 'Half-Orc',
                'url' => '/api/2014/races/half-orc',
            ],
            [
                'index' => 'halfling',
                'name' => 'Halfling',
                'url' => '/api/2014/races/halfling',
            ],
            [
                'index' => 'human',
                'name' => 'Human',
                'url' => '/api/2014/races/human',
            ],
            [
                'index' => 'tiefling',
                'name' => 'Tiefling',
                'url' => '/api/2014/races/tiefling',
            ],
        ];

        // Datos detallados para el tooltip y slide-over
        $raceDetails = [
            'dragonborn' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+2 STR, +1 CHA',
                'description' => 'Los dragonborn son una raza de humanoides con características dracónicas. Nacidos de dragones, como su nombre indica, los dragonborn caminan orgullosamente por un mundo que los recibe con un temor incomprensible.',
                'traits' => ['Linaje Dracónico', 'Aliento de Dragón', 'Resistencia al Daño'],
                'languages' => ['Común', 'Dracónico'],
            ],
            'dwarf' => [
                'speed' => 25,
                'size' => 'Medium',
                'abilityBonus' => '+2 CON',
                'description' => 'Los enanos son sólidos y resistentes como las montañas donde construyen sus fortalezas. Son conocidos por su habilidad en combate, su resistencia a venenos y magia, y su pericia con la piedra y el metal.',
                'traits' => ['Resistencia Enana', 'Entrenamiento de Combate Enano', 'Afinidad con la Piedra'],
                'languages' => ['Común', 'Enano'],
            ],
            'elf' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+2 DEX',
                'description' => 'Los elfos son una raza mágica de gracia sobrenatural, que viven en lugares de belleza etérea. Aman la naturaleza, la magia, el arte y la artesanía.',
                'traits' => ['Sentidos Agudos', 'Linaje Feérico', 'Trance'],
                'languages' => ['Común', 'Élfico'],
            ],
            'gnome' => [
                'speed' => 25,
                'size' => 'Small',
                'abilityBonus' => '+2 INT',
                'description' => 'Los gnomos son pequeños humanoides conocidos por su entusiasmo y vitalidad. Tienen una pasión innata por la vida, que se manifiesta en una intensidad de emociones.',
                'traits' => ['Astucia Gnoma', 'Conocimiento Arcano', 'Tamaño Pequeño'],
                'languages' => ['Común', 'Gnómico'],
            ],
            'half-elf' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+2 CHA, +1 a dos habilidades',
                'description' => 'Los medio elfos combinan lo mejor de ambos mundos: la curiosidad humana con la precisión élfica. Viven mucho más que los humanos, pero considerablemente menos que los elfos.',
                'traits' => ['Versatilidad', 'Herencia Feérica', 'Habilidades Variadas'],
                'languages' => ['Común', 'Élfico', 'Un idioma adicional a elección'],
            ],
            'half-orc' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+2 STR, +1 CON',
                'description' => 'Los medio orcos combinan la físicalidad de los orcos con la ambición y versatilidad de los humanos. Muchos se convierten en aventureros, aprovechando su fuerza y tenacidad.',
                'traits' => ['Amenazante', 'Resistencia Implacable', 'Ataques Salvajes'],
                'languages' => ['Común', 'Orco'],
            ],
            'halfling' => [
                'speed' => 25,
                'size' => 'Small',
                'abilityBonus' => '+2 DEX',
                'description' => 'Los halflings son pequeños humanoides conocidos por su capacidad de mezclarse con otras culturas. Son prácticos, eficientes y optimistas.',
                'traits' => ['Suerte', 'Valiente', 'Agilidad Halfling'],
                'languages' => ['Común', 'Halfling'],
            ],
            'human' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+1 a todas las habilidades',
                'description' => 'Los humanos son la raza más adaptable, flexible y ambiciosa. Tienen una gran capacidad para trabajar juntos, pero también son individualistas.',
                'traits' => ['Versátil', 'Habilidades Extra', 'Idiomas Adicionales'],
                'languages' => ['Común', 'Un idioma adicional a elección'],
            ],
            'tiefling' => [
                'speed' => 30,
                'size' => 'Medium',
                'abilityBonus' => '+2 CHA, +1 INT',
                'description' => 'Los tieflings llevan el legado de un antiguo pacto infernal. Con apariencia demoníaca, suelen ser recibidos con desconfianza y sospecha.',
                'traits' => ['Resistencia Infernal', 'Magia Infernal', 'Visión en la Oscuridad'],
                'languages' => ['Común', 'Infernal'],
            ],
        ];

        return Inertia::render('Calabozos/RacesList', [
            'races' => $races,
            'raceDetails' => $raceDetails,
        ]);
    }
}
