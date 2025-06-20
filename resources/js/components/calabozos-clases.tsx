import { ClassCard } from './calabozos/ClassCard';
import { ClassDetailsModal } from './calabozos/ClassDetailsModal';
import { useState } from 'react';

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
    const [selectedClass, setSelectedClass] = useState<any>(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    
    const handleClassClick = (classItem: ClassItem) => {
        // Usar el JSON de ejemplo proporcionado
        const mockClassData = {
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
        
        setSelectedClass(mockClassData);
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
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
            />
        </>
    );
}
