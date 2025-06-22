import { RaceCard } from '@/components/calabozos/RaceCard';
import { type RaceDetails, type RaceItem } from '@/types';
import { useState } from 'react';

interface CalabozosRacesProps {
    races: RaceItem[];
    raceDetails?: Record<string, RaceDetails>;
    className?: string;
}

export function CalabozosRaces({ races, raceDetails = {}, className = '' }: CalabozosRacesProps) {
    const [selectedRace, setSelectedRace] = useState<RaceItem | null>(null);

    const handleRaceClick = (raceItem: RaceItem) => {
        setSelectedRace(raceItem);
    };

    return (
        <div className={`flex flex-col gap-4 p-4 ${className}`}>
            <h2 className="text-xl font-semibold">Razas Disponibles</h2>
            <p className="text-neutral-600 dark:text-neutral-400">
                Selecciona una raza para tu personaje. Cada raza tiene características y habilidades únicas.
            </p>
            <div className="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                {races && races.length > 0 ? (
                    races.map((raceItem) => (
                        <RaceCard
                            key={raceItem.index}
                            raceItem={raceItem}
                            raceDetails={raceDetails[raceItem.index]}
                            onClick={handleRaceClick}
                            isSelected={selectedRace?.index === raceItem.index}
                        />
                    ))
                ) : (
                    <p className="col-span-full text-center text-sm text-neutral-600 dark:text-neutral-400">No hay razas disponibles</p>
                )}
            </div>
        </div>
    );
}
