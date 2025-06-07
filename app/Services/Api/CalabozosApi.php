<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Http\Client\ConnectionException;

class CalabozosApi extends CalabozosApiClient
{
    /**
     * @throws ConnectionException
     */
    public function getClasses(): array
    {
        $response = $this->get('/classes');

        return $response->json();
    }
}
