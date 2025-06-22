import { CalabozosRaces } from '@/components/calabozos-races';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type DashboardProps } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ classes = [], races = [], raceDetails = {} }: DashboardProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="mb-4 flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Dashboard</h1>
                    <div className="flex gap-2">
                        <Link
                            href="/calabozos/classes"
                            className="rounded-lg border border-primary/30 bg-white px-4 py-2 text-primary hover:bg-primary/5 dark:bg-neutral-800 dark:hover:bg-neutral-700"
                        >
                            Ver Clases
                        </Link>
                        <Link
                            href="/calabozos/races"
                            className="rounded-lg border border-primary/30 bg-white px-4 py-2 text-primary hover:bg-primary/5 dark:bg-neutral-800 dark:hover:bg-neutral-700"
                        >
                            Crear Personaje
                        </Link>
                    </div>
                </div>
                <div className="flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <CalabozosRaces races={races} raceDetails={raceDetails} />
                </div>
            </div>
        </AppLayout>
    );
}
