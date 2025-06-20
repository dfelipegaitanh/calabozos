import React from 'react';
import { ClassData, ApiReference } from '@/types/classDetails';

interface BasicInfoProps {
    classData: ClassData;
}

export function BasicInfo({ classData }: BasicInfoProps) {
    return (
        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
            <h4 className="mb-2 text-lg font-semibold">Información Básica</h4>
            <div className="space-y-2">
                <div>
                    <span className="font-medium">Dado de Vida:</span> d{classData.hit_die}
                </div>
                <div>
                    <span className="font-medium">Subclases:</span>{' '}
                    {classData.subclasses.map((sc: ApiReference) => sc.name).join(', ')}
                </div>
            </div>
        </div>
    );
}
