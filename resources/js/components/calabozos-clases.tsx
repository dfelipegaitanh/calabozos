import { ClassCard } from './calabozos/ClassCard';

interface ClassItem {
    index: string;
    name: string;
    url: string;
}

interface CalabozosClasesProps {
    className?: string;
    classes: ClassItem[];
}

export function CalabozosClases({ className, classes = [] }: CalabozosClasesProps) {
    return (
        <div className={`p-4 ${className}`}>
            <h3 className="mb-4 text-lg font-medium">Clases de Personaje</h3>
            <div className="grid grid-cols-2 gap-2 sm:grid-cols-3">
                {classes.map((classItem) => (
                    <ClassCard key={classItem.index} classItem={classItem} />
                ))}
                {classes.length === 0 && (
                    <p className="col-span-full text-center text-sm text-neutral-600 dark:text-neutral-400">No hay clases disponibles</p>
                )}
            </div>
        </div>
    );
}
