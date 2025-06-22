import { type RaceDetails, type RaceItem } from '@/types';
import { useState } from 'react';
import { Tooltip, TooltipContent, TooltipTrigger } from '../ui/tooltip';

interface RaceCardProps {
    raceItem: RaceItem;
    raceDetails?: RaceDetails;
    onClick: (raceItem: RaceItem) => void;
    isSelected?: boolean;
}

export function RaceCard({ raceItem, raceDetails, onClick, isSelected = false }: RaceCardProps) {
    const [isActive, setIsActive] = useState(false);
    const details = raceDetails || { speed: 30, size: 'Medium', abilityBonus: 'Desconocido' };

    return (
        <Tooltip>
            <TooltipTrigger asChild>
                <div
                    className={`flex flex-col items-center justify-center rounded-lg border ${
                        isSelected ? 'border-primary ring-2 ring-primary/30' : 'border-sidebar-border/70'
                    } bg-white p-3 shadow-sm transition-all ${
                        isActive ? 'scale-95 bg-primary/5 shadow-inner' : 'hover:scale-105 hover:border-primary/30 hover:bg-primary/5 hover:shadow-md'
                    } cursor-pointer dark:bg-neutral-800`}
                    onMouseDown={() => setIsActive(true)}
                    onMouseUp={() => {
                        setIsActive(false);
                        onClick(raceItem);
                    }}
                    onMouseLeave={() => setIsActive(false)}
                >
                    <div
                        className={`mb-2 flex h-12 w-12 items-center justify-center rounded-full ${
                            isSelected ? 'bg-primary/20' : 'bg-primary/10'
                        } transition-all ${isActive ? 'scale-90' : ''}`}
                    >
                        <span className="text-xl font-bold text-primary">{raceItem.name.charAt(0)}</span>
                    </div>
                    <span className="text-sm font-medium">{raceItem.name}</span>
                </div>
            </TooltipTrigger>
            <TooltipContent className="p-2 text-xs">
                <div className="flex flex-col gap-1">
                    <p className="font-semibold">{raceItem.name}</p>
                    <p>Velocidad: {details.speed} pies</p>
                    <p>Tamaño: {details.size}</p>
                    <p>Bonificación: {details.abilityBonus}</p>
                </div>
            </TooltipContent>
        </Tooltip>
    );
}
