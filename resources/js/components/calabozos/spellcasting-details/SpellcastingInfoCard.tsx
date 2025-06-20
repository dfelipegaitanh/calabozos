import React from 'react';
import { SpellcastingInfoItem } from '@/types/spellcasting';

interface SpellcastingInfoCardProps {
    item: SpellcastingInfoItem;
}

export function SpellcastingInfoCard({ item }: SpellcastingInfoCardProps) {
    return (
        <div 
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
    );
}
