<?php

namespace App\Contracts\Services;

use App\Exceptions\AppPricesNotFoundException;
use App\Models\Task;

interface ApplicationApiServiceInterface
{

    /**
     * Get through expression of days count to get price for one run.
     *
     * @param Task $application
     * @return float
     * @throws AppPricesNotFoundException
     */
    public function getApplicationPrice(Task $application): float;

    public function generateCountryGroups(Task $application): array;
}
