<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Trait para estandarizar el registro de logs en la aplicación.
 *
 * Este trait proporciona métodos consistentes para registrar diferentes
 * niveles de logs con un formato estandarizado y contexto enriquecido.
 */
trait LoggingTrait
{
    /**
     * Registra un mensaje de depuración con contexto.
     *
     * @param  string  $message  Mensaje de depuración
     * @param  array  $context  Contexto adicional para el log
     */
    protected function logDebug(string $message, array $context = []): void
    {
        Log::debug($message, $context);
    }

    /**
     * Registra un mensaje de error con contexto enriquecido.
     *
     * @param  string  $message  Mensaje descriptivo del error
     * @param  Exception  $exception  Excepción capturada
     * @param  array  $context  Contexto adicional para el log
     */
    protected function logError(string $message, Exception $exception, array $context = []): void
    {
        $enrichedContext = array_merge([
            'exception' => $exception,
            'exception_class' => get_class($exception),
            'exception_code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ], $context);

        Log::error($message.': '.$exception->getMessage(), $enrichedContext);
    }

    /**
     * Registra un mensaje informativo con contexto.
     *
     * @param  string  $message  Mensaje informativo
     * @param  array  $context  Contexto adicional para el log
     */
    protected function logInfo(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }

    /**
     * Registra un mensaje de advertencia con contexto.
     *
     * @param  string  $message  Mensaje de advertencia
     * @param  array  $context  Contexto adicional para el log
     */
    protected function logWarning(string $message, array $context = []): void
    {
        Log::warning($message, $context);
    }
}
