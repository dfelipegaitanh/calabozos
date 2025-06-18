import { CalabozosClases } from '@/components/calabozos-clases';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type ClassItem } from '@/types';
import { Head } from '@inertiajs/react';

interface ClasesListPageProps {
    classes: ClassItem[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Clases',
        href: '/calabozos/classes',
    },
];

export default function ClasesList({ classes = [] }: ClasesListPageProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clases de Personaje" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-neutral-800">
                    <h1 className="mb-6 text-2xl font-semibold">Clases de Personaje</h1>
                    <div className="relative overflow-hidden rounded-xl">
                        <CalabozosClases classes={classes} className="w-full" />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
