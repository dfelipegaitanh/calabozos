import React from 'react';
import { Multiclassing } from '@/types/classDetails';

interface MulticlassingRequirementsProps {
    multiclassing: Multiclassing;
}

export function MulticlassingRequirements({ multiclassing }: MulticlassingRequirementsProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Requisitos de Multiclase</h4>
            <ul className="list-inside list-disc">
                {multiclassing.prerequisites.map((prereq, idx) => (
                    <li key={idx}>
                        {prereq.ability_score.name}: {prereq.minimum_score} mínimo
                    </li>
                ))}
            </ul>
        </div>
    );
}
