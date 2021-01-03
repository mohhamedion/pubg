<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppStatisticsController extends BaseController
{
    public function update(Task $application, Request $request): RedirectResponse
    {
        $limit = intval($request->input('limit'));

        if ($limit > $application->limit || $limit < 0) {
            Flash::error('<div style="font-size: 12pt">' . trans('messages.incorrect_progress_value') . '</div>');
        } else {
            $application->statistics()->update([
                'limit' => $limit,
            ]);

            // To "finish" campaign if reached limit
            if ($limit === $application->limit) {
                $application->update([
                    'active' => false,
                    'done' => true,
                ]);
            }
        }

        return redirect()->back();
    }
}
