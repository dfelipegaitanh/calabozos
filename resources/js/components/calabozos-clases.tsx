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
                    <div
                        key={classItem.index}
                        className="flex flex-col items-center justify-center rounded-lg border border-sidebar-border/70 bg-white p-3 shadow-sm transition-all hover:shadow-md dark:bg-neutral-800"
                    >
                        <div className="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                            <span className="text-xl font-bold text-primary">{classItem.name.charAt(0)}</span>
                        </div>
                        <span className="text-sm font-medium">{classItem.name}</span>
                    </div>
                ))}
                {classes.length === 0 && (
                    <p className="col-span-full text-center text-sm text-neutral-600 dark:text-neutral-400">No hay clases disponibles</p>
                )}
            </div>
        </div>
    );
}
