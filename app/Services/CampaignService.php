<?php

namespace App\Services;

use App\Contracts\Services\CampaignServiceInterface;
use App\Models\Task;
use App\Models\User;

class CampaignService implements CampaignServiceInterface
{
    /**
     * @param Task $application
     * @param User $user
     * @return bool
     */
    public function payFromBalance(Task $application, User $user): bool
    {
        $balance_after_payment = $user->balance - $application->amount_for_user;

        if ($balance_after_payment < 0) {
            return false;
        }

        $user->update(['balance' => $balance_after_payment]);

        $user->balanceReplenishments()->create([
            'app_id' => $application->id,
            'amount' => -$application->amount_for_user
        ]);

        $application->paid = true;
        $application->save();

        return true;
    }
}
