import React from 'react';
import { StartingEquipment, StartingEquipmentOption } from '@/types/classDetails';

interface StartingEquipmentProps {
    startingEquipment: StartingEquipment[];
    startingEquipmentOptions: StartingEquipmentOption[];
}

export function StartingEquipmentComponent({ startingEquipment, startingEquipmentOptions }: StartingEquipmentProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Equipo Inicial</h4>
            <ul className="list-inside list-disc space-y-1">
                {startingEquipment.map((item, idx) => (
                    <li key={idx}>
                        {item.quantity} x {item.equipment.name}
                    </li>
                ))}
            </ul>

            <h5 className="mt-3 mb-1 font-medium">Opciones de equipo:</h5>
            <ul className="list-inside list-disc space-y-1">
                {startingEquipmentOptions.map((option, idx) => (
                    <li key={idx}>{option.desc}</li>
                ))}
            </ul>
        </div>
    );
}
