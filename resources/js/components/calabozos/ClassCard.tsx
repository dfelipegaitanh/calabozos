import { type ClassItem } from '@/types';
import { useState } from 'react';

interface ClassCardProps {
    classItem: ClassItem;
}

export function ClassCard({ classItem }: ClassCardProps) {
    const [isActive, setIsActive] = useState(false);

    return (
        <div
            className={`flex flex-col items-center justify-center rounded-lg border border-sidebar-border/70 bg-white p-3 shadow-sm transition-all ${isActive ? 'scale-95 bg-primary/5 shadow-inner' : 'hover:scale-105 hover:border-primary/30 hover:bg-primary/5 hover:shadow-md'} cursor-pointer dark:bg-neutral-800`}
            onMouseDown={() => setIsActive(true)}
            onMouseUp={() => setIsActive(false)}
            onMouseLeave={() => setIsActive(false)}
        >
            <div
                className={`mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 transition-all ${isActive ? 'scale-90' : ''}`}
            >
                <span className="text-xl font-bold text-primary">{classItem.name.charAt(0)}</span>
            </div>
            <span className="text-sm font-medium">{classItem.name}</span>
        </div>
    );
}
