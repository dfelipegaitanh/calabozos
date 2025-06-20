import React, { useState } from 'react';
import { ClassCard } from './calabozos/ClassCard';
import { ClassDetailsModal } from './calabozos/ClassDetailsModal';
import { SpellcastingData } from '@/types/spellcasting';
import { ClassData } from '@/types/classDetails';

interface ClassItem {
    index: string;
    name: string;
    url: string;
}

interface CalabozosClasesProps {
    className?: string;
    classes: ClassItem[];
}

export function CalabozosClases({ className, classes = [] }: CalabozosClasesProps) {
    const [selectedClass, setSelectedClass] = useState<ClassData | null>(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [spellcastingData, setSpellcastingData] = useState<SpellcastingData | null>(null);

    const handleClassClick = () => {
        const mockClassData: ClassData = {
            "index": "monk",
            "name": "Monk",
            "hit_die": 8,
            "proficiency_choices": [
                {
                    "desc": "Choose two from Acrobatics, Athletics, History, Insight, Religion, and Stealth",
                    "choose": 2,
                    "type": "proficiencies",
                    "from": {
                        "option_set_type": "options_array",
                        "options": [
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-acrobatics",
                                    "name": "Skill: Acrobatics",
                                    "url": "/api/2014/proficiencies/skill-acrobatics"
                                }
                            },
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-athletics",
                                    "name": "Skill: Athletics",
                                    "url": "/api/2014/proficiencies/skill-athletics"
                                }
                            },
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-history",
                                    "name": "Skill: History",
                                    "url": "/api/2014/proficiencies/skill-history"
                                }
                            },
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-insight",
                                    "name": "Skill: Insight",
                                    "url": "/api/2014/proficiencies/skill-insight"
                                }
                            },
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-religion",
                                    "name": "Skill: Religion",
                                    "url": "/api/2014/proficiencies/skill-religion"
                                }
                            },
                            {
                                "option_type": "reference",
                                "item": {
                                    "index": "skill-stealth",
                                    "name": "Skill: Stealth",
                                    "url": "/api/2014/proficiencies/skill-stealth"
                                }
                            }
                        ]
                    }
                }
            ],
            "proficiencies": [
                {
                    "index": "simple-weapons",
                    "name": "Simple Weapons",
                    "url": "/api/2014/proficiencies/simple-weapons"
                },
                {
                    "index": "shortswords",
                    "name": "Shortswords",
                    "url": "/api/2014/proficiencies/shortswords"
                }
            ],
            "saving_throws": [
                {
                    "index": "str",
                    "name": "STR",
                    "url": "/api/2014/ability-scores/str"
                },
                {
                    "index": "dex",
                    "name": "DEX",
                    "url": "/api/2014/ability-scores/dex"
                }
            ],
            "starting_equipment": [
                {
                    "equipment": {
                        "index": "dart",
                        "name": "Dart",
                        "url": "/api/2014/equipment/dart"
                    },
                    "quantity": 10
                }
            ],
            "starting_equipment_options": [
                {
                    "desc": "(a) a shortsword or (b) any simple weapon",
                    "choose": 1,
                    "type": "equipment",
                    "from": {
                        "option_set_type": "options_array",
                        "options": []
                    }
                }
            ],
            "multi_classing": {
                "prerequisites": [
                    {
                        "ability_score": {
                            "index": "dex",
                            "name": "DEX",
                            "url": "/api/2014/ability-scores/dex"
                        },
                        "minimum_score": 13
                    },
                    {
                        "ability_score": {
                            "index": "wis",
                            "name": "WIS",
                            "url": "/api/2014/ability-scores/wis"
                        },
                        "minimum_score": 13
                    }
                ],
                "proficiencies": [
                    {
                        "index": "simple-weapons",
                        "name": "Simple Weapons",
                        "url": "/api/2014/proficiencies/simple-weapons"
                    },
                    {
                        "index": "shortswords",
                        "name": "Shortswords",
                        "url": "/api/2014/proficiencies/shortswords"
                    }
                ]
            },
            "subclasses": [
                {
                    "index": "way-of-the-open-hand",
                    "name": "Way of the Open Hand",
                    "url": "/api/2014/subclasses/way-of-the-open-hand"
                }
            ]
        };

        const mockSpellcastingData: SpellcastingData = {
            "level": 1,
            "spellcasting_ability": {
                "index": "cha",
                "name": "CHA",
                "url": "/api/2014/ability-scores/cha",
                "_id": "6854c19aa54f8aaa772b59b9"
            },
            "info": [
                {
                    "_id": "6854c19aa54f8aaa772b59ba",
                    "name": "Cantrips",
                    "desc": [
                        "At 1st level, you know four cantrips of your choice from the sorcerer spell list. You learn additional sorcerer cantrips of your choice at higher levels, as shown in the Cantrips Known column of the Sorcerer table."
                    ]
                },
                {
                    "_id": "6854c19aa54f8aaa772b59bb",
                    "name": "Spell Slots",
                    "desc": [
                        "The Sorcerer table shows how many spell slots you have to cast your spells of 1st level and higher. To cast one of these sorcerer spells, you must expend a slot of the spell's level or higher. You regain all expended spell slots when you finish a long rest.",
                        "For example, if you know the 1st-level spell burning hands and have a 1st-level and a 2nd-level spell slot available, you can cast burning hands using either slot."
                    ]
                },
                {
                    "_id": "6854c19aa54f8aaa772b59bc",
                    "name": "Spells Known of 1st Level and Higher",
                    "desc": [
                        "You know two 1st-level spells of your choice from the sorcerer spell list.",
                        "The Spells Known column of the Sorcerer table shows when you learn more sorcerer spells of your choice. Each of these spells must be of a level for which you have spell slots. For instance, when you reach 3rd level in this class, you can learn one new spell of 1st or 2nd level. ",
                        "Additionally, when you gain a level in this class, you can choose one of the sorcerer spells you know and replace it with another spell from the sorcerer spell list, which also must be of a level for which you have spell slots."
                    ]
                },
                {
                    "_id": "6854c19aa54f8aaa772b59bd",
                    "name": "Spellcasting Ability",
                    "desc": [
                        "Charisma is your spellcasting ability for your sorcerer spells, since the power of your magic relies on your ability to project your will into the world. You use your Charisma whenever a spell refers to your spellcasting ability. In addition, you use your Charisma modifier when setting the saving throw DC for a sorcerer spell you cast and when making an attack roll with one.",
                        "Spell save DC = 8 + your proficiency bonus + your Charisma modifier.",
                        "Spell attack modifier = your proficiency bonus + your Charisma modifier."
                    ]
                },
                {
                    "_id": "6854c19aa54f8aaa772b59be",
                    "name": "Spellcasting Focus",
                    "desc": [
                        "You can use an arcane focus as a spellcasting focus for your sorcerer spells."
                    ]
                }
            ],
            "_id": "6854c19aa54f8aaa772b59bf"
        };

        setSelectedClass(mockClassData);
        setSpellcastingData(mockSpellcastingData);
        setIsModalOpen(true);
    };

    return (
        <>
            <div className={`p-4 ${className}`}>
                <h3 className="mb-4 text-lg font-medium">Clases de Personaje</h3>
                <div className="grid grid-cols-2 gap-2 sm:grid-cols-3">
                    {classes.map((classItem) => (
                        <ClassCard
                            key={classItem.index}
                            classItem={classItem}
                            onClick={handleClassClick}
                        />
                    ))}
                    {classes.length === 0 && (
                        <p className="col-span-full text-center text-sm text-neutral-600 dark:text-neutral-400">No hay clases disponibles</p>
                    )}
                </div>
            </div>

        <ClassDetailsModal
            classData={selectedClass}
            spellcastingData={spellcastingData || undefined}
            isOpen={isModalOpen}
            onClose={() => setIsModalOpen(false)}
        />
        </>
    );
}
