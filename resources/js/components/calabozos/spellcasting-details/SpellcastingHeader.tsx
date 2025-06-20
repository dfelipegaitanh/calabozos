import React from 'react';
import { SpellcastingAbility } from '@/types/spellcasting';

interface SpellcastingHeaderProps {
    level: number;
    spellcastingAbility: SpellcastingAbility;
}

export function SpellcastingHeader({ level, spellcastingAbility }: SpellcastingHeaderProps) {
    return (
        <div className="flex items-center justify-between">
            <h3 className="text-xl font-bold text-gray-900 dark:text-white">
                Lanzamiento de Hechizos - Nivel {level}
            </h3>
            <span className="rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">
                {spellcastingAbility.name}
            </span>
        </div>
    );
}
