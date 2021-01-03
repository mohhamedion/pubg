<?php

namespace App\Contracts\Services;

use App\Models\Task;
use App\Models\User;

interface CampaignServiceInterface
{
    public function payFromBalance(Task $application, User $user): bool;
}
