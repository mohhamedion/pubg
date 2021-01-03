<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AppPricesNotFoundException extends ModelNotFoundException
{

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     * @internal param Request $request
     */
    public function render(): JsonResponse
    {
        return new JsonResponse(['error' => 'app_prices_not_found'], 404);
    }
}
