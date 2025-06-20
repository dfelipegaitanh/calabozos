import React from 'react';
import { ApiReference } from '@/types/classDetails';

interface ProficienciesProps {
    proficiencies: ApiReference[];
}

export function Proficiencies({ proficiencies }: ProficienciesProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Competencias</h4>
            <ul className="list-inside list-disc space-y-1">
                {proficiencies.map((prof) => (
                    <li key={prof.index}>{prof.name}</li>
                ))}
            </ul>
        </div>
    );
}
