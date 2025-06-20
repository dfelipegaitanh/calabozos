import React from 'react';

interface SpellcastingAbility {
    index: string;
    name: string;
    url: string;
    _id: string;
}

interface InfoItem {
    _id: string;
    name: string;
    desc: string[];
}

interface SpellcastingDetails {
    level: number;
    spellcasting_ability: SpellcastingAbility;
    info: InfoItem[];
    _id: string;
}

interface SpellcastingDetailsProps {
    spellcastingData: SpellcastingDetails;
}

export function SpellcastingDetails({ spellcastingData }: SpellcastingDetailsProps) {
    if (!spellcastingData) return null;

    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h3 className="text-xl font-bold text-gray-900 dark:text-white">
                    Lanzamiento de Hechizos - Nivel {spellcastingData.level}
                </h3>
                <span className="rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">
                    {spellcastingData.spellcasting_ability.name}
                </span>
            </div>

            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                {spellcastingData.info.map((item) => (
                    <div 
                        key={item._id}
                        className="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-all hover:border-primary/30 dark:border-gray-700 dark:bg-neutral-800"
                    >
                        <h4 className="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                            {item.name}
                        </h4>
                        <div className="space-y-2">
                            {item.desc.map((paragraph, idx) => (
                                <p 
                                    key={idx} 
                                    className="text-sm text-gray-700 dark:text-gray-300"
                                >
                                    {paragraph}
                                </p>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
