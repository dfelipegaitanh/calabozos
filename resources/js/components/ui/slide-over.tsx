import * as React from "react";
import { X } from "lucide-react";
import { cn } from "@/lib/utils";

interface SlideOverProps {
    isOpen: boolean;
    onClose: () => void;
    title?: string;
    children: React.ReactNode;
    className?: string;
}

export function SlideOver({ 
    isOpen, 
    onClose, 
    title, 
    children, 
    className 
}: SlideOverProps) {
    // Capturar la tecla Escape para cerrar
    React.useEffect(() => {
        const handleEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape' && isOpen) {
                onClose();
            }
        };

        document.addEventListener('keydown', handleEscape);
        return () => document.removeEventListener('keydown', handleEscape);
    }, [isOpen, onClose]);

    // Prevenir scroll en el body cuando el slide-over está abierto
    React.useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [isOpen]);

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50 overflow-hidden">
            {/* Overlay de fondo */}
            <div 
                className="absolute inset-0 bg-black/30 transition-opacity" 
                onClick={onClose}
                aria-hidden="true"
            />
            
            {/* Panel deslizante */}
            <div className="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div 
                    className={cn(
                        "pointer-events-auto w-screen max-w-md transform transition ease-in-out duration-500",
                        "bg-white dark:bg-neutral-900 shadow-xl",
                        className
                    )}
                >
                    <div className="flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl dark:bg-neutral-900">
                        <div className="px-4 sm:px-6">
                            <div className="flex items-start justify-between">
                                {title && (
                                    <h2 className="text-lg font-medium text-neutral-900 dark:text-white">
                                        {title}
                                    </h2>
                                )}
                                <div className="ml-3 flex h-7 items-center">
                                    <button
                                        type="button"
                                        className="rounded-md bg-white text-neutral-400 hover:text-neutral-500 focus:outline-none focus:ring-2 focus:ring-primary dark:bg-neutral-900 dark:text-neutral-500 dark:hover:text-neutral-400"
                                        onClick={onClose}
                                    >
                                        <span className="sr-only">Cerrar panel</span>
                                        <X className="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div className="relative mt-6 flex-1 px-4 sm:px-6">
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
