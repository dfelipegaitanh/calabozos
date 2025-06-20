import React from 'react';
import { ProficiencyChoice, OptionItem } from '@/types/classDetails';

interface ProficiencyChoicesProps {
    proficiencyChoices: ProficiencyChoice[];
}

export function ProficiencyChoices({ proficiencyChoices }: ProficiencyChoicesProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Opciones de Competencias</h4>
            {proficiencyChoices.map((choice, idx) => (
                <div key={idx} className="mb-3">
                    <p className="mb-1 font-medium">{choice.desc}</p>
                    <p className="text-sm text-gray-600 dark:text-gray-300">
                        Elige {choice.choose} de:
                    </p>
                    <ul className="ml-4 list-inside list-disc text-sm">
                        {choice.from.options?.map((option: OptionItem, optIdx: number) => {
                            if (option.option_type === 'reference' && option.item) {
                                return (
                                    <li key={optIdx}>
                                        {option.item.name}
                                    </li>
                                );
                            } else if (option.option_type === 'choice' && option.choice) {
                                return (
                                    <li key={optIdx}>
                                        [{option.choice.desc}]
                                    </li>
                                );
                            }
                            return null;
                        })}
                    </ul>
                </div>
            ))}
        </div>
    );
}
