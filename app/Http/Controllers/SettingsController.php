<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Jobs\SendNewVersionNotification;
use App\Models\AppPrice;
use App\Models\HeaderNotification;
use App\Models\RateAward;
use App\Models\Settings;
use App\Models\User;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends BaseController
{

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);
        $this->middleware('adminOnly');
    }

    /**
     * Settings index page
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $title = trans('labels.settings');
        $settings = Settings::getInstance();

        $prices = AppPrice::query()->first();
        //$headerNotification = HeaderNotification::getInstance();

        $levels = RateAward::all();

        return view('pages.settings', compact('title', 'settings', 'prices', 'levels'));//', headerNotification'));
    }

    /**
     * Handling update settings request
     * method - PATCH
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {

        $settings = [
            'email',
            'uc_rate',
            'points_rate',
            'popularity_rate',
            'version',
            'award_standard_promo_code',
            'award_partner_promo_code',
            'task_reminder_text',
            'application_downloads_min_limit',
            'balance_replenishment_min',
            'withdraw_limit',
            'withdraw_commission',
            'transfer_commission',
            //'referral_first_balance_limit',
            //'referral_first_reward_percentage',
            //'referral_second_balance_limit',
            //'referral_second_reward_percentage',
           // 'referral_second_reward_time',
            //'award_standard_task_video',
            //'award_standard_task_vk_group',
            'review_price',
            'review_comment_price',
            'review_keywords',
            'review_min_task_run_limit',
            'description_price',
            'top_price',
            'cashback'
        ];
        $setting = Settings::first();

        $old_rate = $setting->uc_rate;

        $old_version = $setting->version;

        $setting->update($request->all($settings));

        /*HeaderNotification::getInstance()->update([
            'active' => filter_var($request->input('system_notification_active'), FILTER_VALIDATE_BOOLEAN),
            'background_color' => $request->input('system_notification_background_color'),
            'text_color' => $request->input('system_notification_text_color'),
            'text' => $request->input('system_notification_text'),
        ]);*/

        $count = RateAward::all()->count();

        for ($i = 1; $i <= $count; $i++) {
            $settings[] = 'task_' . $i;
            $settings[] = 'video_' . $i;
            $settings[] = 'partner_' . $i;
            $settings[] = 'referral_' . $i;
        }

        AppPrice::getPrices()->update($request->except(array_merge([
            '_method',
            '_token',
            'system_notification_active',
            'system_notification_background_color',
            'system_notification_text_color',
            'system_notification_text',
            'cashback',
        ], $settings)));

        for ($i = 1; $i <= $count; $i++) {
            $rate = RateAward::find($i);
            $rate->update([
                'task' => $request->input('task_' . $i),
                'video' => $request->input('video_' . $i),
                'partner' => $request->input('partner_' . $i),
                'referral' => $request->input('referral_' . $i),
            ]);
        }

        $setting = Settings::first();

        $new_rate = $setting->uc_rate;

        $new_version = $setting->version;

        if ($new_rate != $old_rate) {
            for ($i = 1; $i <= $count; $i++) {
                $rate = RateAward::find($i);
                $rate->update([
                    'task' => $rate->task / $old_rate * $new_rate,
                    'video' => $rate->video / $old_rate * $new_rate,
                    'partner' => $rate->partner / $old_rate * $new_rate,
                    'referral' => $request->input('referral_' . $i),
                ]);
            }

            $users = User::searchByRole('user')->get();

            foreach ($users as $user) {
                $user->balance = $user->balance / $old_rate * $new_rate;
                $user->save();

                $games = $user->games()->get();

                foreach ($games as $game) {
                    $game->pivot->earned = (float) number_format($game->pivot->earned, 2, '.', '')
                    / $old_rate * $new_rate;
                    $game->pivot->save();
                }

                $quizzes = $user->quizzes()->get();

                foreach ($quizzes as $quiz) {
                    $quiz->pivot->earned = (float) number_format($quiz->pivot->earned, 2, '.', '')
                        / $old_rate * $new_rate;
                    $quiz->pivot->save();
                }

                $videos = $user->videos()->get();

                foreach ($videos as $video) {
                    $video->pivot->earned = (float) number_format($video->pivot->earned, 2, '.', '')
                        / $old_rate * $new_rate;
                    $video->pivot->save();
                }


            }
        }

        if ($new_version != $old_version) {
            $this->dispatch(new SendNewVersionNotification());
        }

        Flash::success(trans('messages.settings_successfully_created'));

        return redirect()->back();
    }
}
