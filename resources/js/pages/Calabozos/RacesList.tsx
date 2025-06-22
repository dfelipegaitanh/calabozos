import { RaceCard } from '@/components/calabozos/RaceCard';
import { SlideOver } from '@/components/ui/slide-over';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type RaceDetails, type RaceItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

interface RacesListPageProps {
    races: RaceItem[];
    raceDetails: Record<string, RaceDetails>;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Razas',
        href: '/calabozos/races',
    },
];

export default function RacesList({ races = [], raceDetails = {} }: RacesListPageProps) {
    const [selectedRace, setSelectedRace] = useState<RaceItem | null>(null);
    const [showDetails, setShowDetails] = useState(false);

    const handleRaceClick = (raceItem: RaceItem) => {
        setSelectedRace(raceItem);
        setShowDetails(true);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Razas de Personaje" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h1 className="mb-6 text-2xl font-semibold">Razas de Personaje</h1>
                    <p className="mb-4 text-neutral-600 dark:text-neutral-400">
                        Selecciona una raza para tu personaje. Cada raza tiene características y habilidades únicas.
                    </p>
                    <div className="relative overflow-hidden rounded-xl">
                        <div className="p-4">
                            <h3 className="mb-4 text-lg font-medium">Razas Disponibles</h3>
                            <div className="grid grid-cols-2 gap-2 sm:grid-cols-3">
                                {races.map((raceItem) => (
                                    <RaceCard
                                        key={raceItem.index}
                                        raceItem={raceItem}
                                        raceDetails={raceDetails[raceItem.index]}
                                        onClick={handleRaceClick}
                                        isSelected={selectedRace?.index === raceItem.index}
                                    />
                                ))}
                                {races.length === 0 && (
                                    <p className="col-span-full text-center text-sm text-neutral-600 dark:text-neutral-400">
                                        No hay razas disponibles
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>
                    {selectedRace && (
                        <div className="mt-6 flex justify-end">
                            <button
                                className="rounded-lg border border-primary/30 bg-white px-4 py-2 text-primary hover:bg-primary/5 dark:bg-neutral-800 dark:hover:bg-neutral-700"
                                onClick={() => {
                                    // Aquí iría la lógica para avanzar al siguiente paso
                                    console.log('Raza seleccionada:', selectedRace);
                                }}
                            >
                                Continuar
                            </button>
                        </div>
                    )}
                </div>
            </div>

            {/* SlideOver para mostrar detalles de la raza */}
            {selectedRace && (
                <SlideOver isOpen={showDetails} onClose={() => setShowDetails(false)} title={selectedRace.name}>
                    <div className="flex flex-col gap-6">
                        {/* Descripción */}
                        <div>
                            <h3 className="text-lg font-medium text-neutral-900 dark:text-white">Descripción</h3>
                            <p className="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                                {raceDetails[selectedRace.index]?.description || 'No hay descripción disponible.'}
                            </p>
                        </div>

                        {/* Características */}
                        <div>
                            <h3 className="text-lg font-medium text-neutral-900 dark:text-white">Rasgos</h3>
                            <ul className="mt-2 list-disc pl-5 text-sm text-neutral-600 dark:text-neutral-400">
                                {raceDetails[selectedRace.index]?.traits?.map((trait, index) => <li key={index}>{trait}</li>) || (
                                    <li>No hay rasgos disponibles.</li>
                                )}
                            </ul>
                        </div>

                        {/* Idiomas */}
                        <div>
                            <h3 className="text-lg font-medium text-neutral-900 dark:text-white">Idiomas</h3>
                            <ul className="mt-2 list-disc pl-5 text-sm text-neutral-600 dark:text-neutral-400">
                                {raceDetails[selectedRace.index]?.languages?.map((language, index) => <li key={index}>{language}</li>) || (
                                    <li>No hay idiomas disponibles.</li>
                                )}
                            </ul>
                        </div>

                        {/* Botón para continuar */}
                        <div className="mt-6 flex justify-end">
                            <button
                                className="rounded-lg border border-primary/30 bg-white px-4 py-2 text-primary hover:bg-primary/5 dark:bg-neutral-800 dark:hover:bg-neutral-700"
                                onClick={() => {
                                    setShowDetails(false);
                                    // Aquí iría la lógica para avanzar al siguiente paso
                                }}
                            >
                                Seleccionar y Continuar
                            </button>
                        </div>
                    </div>
                </SlideOver>
            )}
        </AppLayout>
    );
}
