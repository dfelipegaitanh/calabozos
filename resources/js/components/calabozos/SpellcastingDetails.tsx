import React from 'react';
import { SpellcastingData } from '@/types/spellcasting';
import { SpellcastingHeader } from './spellcasting-details/SpellcastingHeader';
import { SpellcastingInfoCard } from './spellcasting-details/SpellcastingInfoCard';

interface SpellcastingDetailsProps {
    spellcastingData: SpellcastingData;
}

export function SpellcastingDetails({ spellcastingData }: SpellcastingDetailsProps) {
    if (!spellcastingData) return null;

    return (
        <div className="space-y-6">
            <SpellcastingHeader 
                level={spellcastingData.level} 
                spellcastingAbility={spellcastingData.spellcasting_ability} 
            />

            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                {spellcastingData.info.map((item) => (
                    <SpellcastingInfoCard key={item._id} item={item} />
                ))}
            </div>
        </div>
    );
}
