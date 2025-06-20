import { Dialog, Transition } from '@headlessui/react';
import { Fragment } from 'react';
import { XMarkIcon } from '@heroicons/react/24/outline';
import { SpellcastingDetails } from './SpellcastingDetails';
import { SpellcastingData } from '@/types/spellcasting';
import { ClassData, ApiReference, ProficiencyChoice, OptionItem } from '@/types/classDetails';

interface ClassDetailsProps {
    classData: ClassData | null;
    isOpen: boolean;
    onClose: () => void;
    spellcastingData?: SpellcastingData;
}

export function ClassDetailsModal({ classData, isOpen, onClose, spellcastingData }: ClassDetailsProps) {
    if (!classData) return null;

    return (
        <Transition show={isOpen} as={Fragment}>
            <Dialog as="div" className="relative z-10" onClose={onClose}>
                <Transition.Child
                    as={Fragment}
                    enter="ease-out duration-300"
                    enterFrom="opacity-0"
                    enterTo="opacity-100"
                    leave="ease-in duration-200"
                    leaveFrom="opacity-100"
                    leaveTo="opacity-0"
                >
                    <div className="fixed inset-0 bg-black bg-opacity-25" />
                </Transition.Child>

                <div className="fixed inset-0 overflow-y-auto">
                    <div className="flex min-h-full items-center justify-center p-4 text-center">
                        <Transition.Child
                            as={Fragment}
                            enter="ease-out duration-300"
                            enterFrom="opacity-0 scale-95"
                            enterTo="opacity-100 scale-100"
                            leave="ease-in duration-200"
                            leaveFrom="opacity-100 scale-100"
                            leaveTo="opacity-0 scale-95"
                        >
                            <Dialog.Panel className="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-neutral-800">
                                <div className="flex items-center justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                                    <Dialog.Title as="h3" className="text-2xl font-bold leading-6 text-gray-900 dark:text-white">
                                        {classData.name}
                                    </Dialog.Title>
                                    <button
                                        type="button"
                                        className="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:bg-neutral-800 dark:hover:text-gray-300"
                                        onClick={onClose}
                                    >
                                        <span className="sr-only">Cerrar</span>
                                        <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>

                                <div className="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                                    {/* Columna izquierda */}
                                    <div className="space-y-6">
                                        {/* Información básica */}
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

                                        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
                                            <h4 className="mb-2 text-lg font-semibold">Tiradas de Salvación</h4>
                                            <div className="flex flex-wrap gap-2">
                                                {classData.saving_throws.map((save: ApiReference) => (
                                                    <span
                                                        key={save.index}
                                                        className="rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                                                    >
                                                        {save.name}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>

                                        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
                                            <h4 className="mb-2 text-lg font-semibold">Competencias</h4>
                                            <ul className="list-inside list-disc space-y-1">
                                                {classData.proficiencies.map((prof: ApiReference) => (
                                                    <li key={prof.index}>{prof.name}</li>
                                                ))}
                                            </ul>
                                        </div>
                                    </div>

                                    <div className="space-y-6">
                                        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
                                            <h4 className="mb-2 text-lg font-semibold">Opciones de Competencias</h4>
                                            {classData.proficiency_choices.map((choice: ProficiencyChoice, idx: number) => (
                                                <div key={idx} className="mb-3">
                                                    <p className="mb-1 font-medium">{choice.desc}</p>
                                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                                        Elige {choice.choose} de:
                                                    </p>
                                                    <ul className="ml-4 list-inside list-disc text-sm">
                                                        {choice.from.options?.map((option: OptionItem, optIdx: number) => {
                                                            if (option.option_type === 'reference' && option.item) {
                                                                return (
                                                                    <li key={optIdx}>
                                                                        {option.item.name}
                                                                    </li>
                                                                );
                                                            } else if (option.option_type === 'choice' && option.choice) {
                                                                return (
                                                                    <li key={optIdx}>
                                                                        [{option.choice.desc}]
                                                                    </li>
                                                                );
                                                            }
                                                            return null;
                                                        })}
                                                    </ul>
                                                </div>
                                            ))}
                                        </div>

                                        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
                                            <h4 className="mb-2 text-lg font-semibold">Equipo Inicial</h4>
                                            <ul className="list-inside list-disc space-y-1">
                                                {classData.starting_equipment.map((item, idx) => (
                                                    <li key={idx}>
                                                        {item.quantity} x {item.equipment.name}
                                                    </li>
                                                ))}
                                            </ul>

                                            <h5 className="mt-3 mb-1 font-medium">Opciones de equipo:</h5>
                                            <ul className="list-inside list-disc space-y-1">
                                                {classData.starting_equipment_options.map((option, idx) => (
                                                    <li key={idx}>{option.desc}</li>
                                                ))}
                                            </ul>
                                        </div>

                                        <div className="rounded-lg bg-gray-50 p-4 dark:bg-neutral-700">
                                            <h4 className="mb-2 text-lg font-semibold">Requisitos de Multiclase</h4>
                                            <ul className="list-inside list-disc">
                                                {classData.multi_classing.prerequisites.map((prereq, idx) => (
                                                    <li key={idx}>
                                                        {prereq.ability_score.name}: {prereq.minimum_score} mínimo
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {spellcastingData && (
                                    <div className="mt-8 border-t border-gray-200 pt-6 dark:border-gray-700">
                                        <SpellcastingDetails spellcastingData={spellcastingData} />
                                    </div>
                                )}

                                <div className="mt-6 flex justify-end">
                                    <button
                                        type="button"
                                        className="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                                        onClick={onClose}
                                    >
                                        Cerrar
                                    </button>
                                </div>
                            </Dialog.Panel>
                        </Transition.Child>
                    </div>
                </div>
            </Dialog>
        </Transition>
    );
}
