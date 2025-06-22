import { ClassData } from '@/types/classDetails';
import { SpellcastingData } from '@/types/spellcasting';
import { Dialog, Transition } from '@headlessui/react';
import { XMarkIcon } from '@heroicons/react/24/outline';
import { Fragment } from 'react';
import { BasicInfo } from './class-details/BasicInfo';
import { MulticlassingRequirements } from './class-details/MulticlassingRequirements';
import { Proficiencies } from './class-details/Proficiencies';
import { ProficiencyChoices } from './class-details/ProficiencyChoices';
import { SavingThrows } from './class-details/SavingThrows';
import { StartingEquipmentComponent } from './class-details/StartingEquipment';
import { SpellcastingDetails } from './SpellcastingDetails';

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
                    <div className="bg-opacity-25 fixed inset-0 bg-black" />
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
                                    <Dialog.Title as="h3" className="text-2xl leading-6 font-bold text-gray-900 dark:text-white">
                                        {classData.name}
                                    </Dialog.Title>
                                    <button
                                        type="button"
                                        className="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none dark:bg-neutral-800 dark:hover:text-gray-300"
                                        onClick={onClose}
                                    >
                                        <span className="sr-only">Cerrar</span>
                                        <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>

                                <div className="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-6">
                                        <BasicInfo classData={classData} />
                                        <SavingThrows savingThrows={classData.saving_throws} />
                                        <Proficiencies proficiencies={classData.proficiencies} />
                                    </div>

                                    <div className="space-y-6">
                                        <ProficiencyChoices proficiencyChoices={classData.proficiency_choices} />
                                        <StartingEquipmentComponent
                                            startingEquipment={classData.starting_equipment}
                                            startingEquipmentOptions={classData.starting_equipment_options}
                                        />
                                        <MulticlassingRequirements multiclassing={classData.multi_classing} />
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
                                        className="rounded-lg border border-primary/30 bg-white px-4 py-2 text-primary hover:bg-primary/5 dark:bg-neutral-800 dark:hover:bg-neutral-700"
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
