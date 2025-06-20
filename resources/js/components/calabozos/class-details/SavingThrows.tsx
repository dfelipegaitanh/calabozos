import React from 'react';
import { ApiReference } from '@/types/classDetails';

interface SavingThrowsProps {
    savingThrows: ApiReference[];
}

export function SavingThrows({ savingThrows }: SavingThrowsProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Tiradas de Salvación</h4>
            <div className="flex flex-wrap gap-2">
                {savingThrows.map((save) => (
                    <span
                        key={save.index}
                        className="rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                    >
                        {save.name}
                    </span>
                ))}
            </div>
        </div>
    );
}
