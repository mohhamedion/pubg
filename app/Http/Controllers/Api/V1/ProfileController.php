<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\Api\V1
 */
class ProfileController extends Controller
{
    /**
     *  Contain max count of stars per level.
     */
    private const USER_STARS_PER_LEVEL = 10;

    /**
     * Contains attribute name for task level data.
     * Needed for some logic.
     */
    private const USER_TASK_PROGRESS_NAME = 'task';

    /**
     * Contains attribute name for video level data.
     * Needed for some logic.
     */
    private const USER_VIDEO_PROGRESS_NAME = 'video';

    /**
     * Contains attribute name for partner level data.
     * Needed for some logic.
     */
    private const USER_PARTNER_PROGRESS_NAME = 'partner';

    /**
     * Contains attribute name for referral level data.
     * Needed for some logic.
     */
    private const USER_REFERRAL_PROGRESS_NAME = 'referral';

    /**
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private $user = null;

    /**
     * ProfileController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))
            ->first();
    }

    /**
     * Endpoint for get profile data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json([
            'profile'  => [
                'username'   => empty($this->user->name) ? $this->user->email : $this->user->name,
                'email'  => $this->user->email,
                'phone'  => $this->user->tel_number,
                'gender' => $this->user->gender,
            ],
            'progress' => [
                'profile'   => $this->getUserProgress(),
                'tasks'     => $this->getProgress(self::USER_TASK_PROGRESS_NAME),
                'videos'     => $this->getProgress(self::USER_VIDEO_PROGRESS_NAME),
                'partners'  => $this->getProgress(self::USER_PARTNER_PROGRESS_NAME),
                'referrals' => $this->getProgress(self::USER_REFERRAL_PROGRESS_NAME),
            ],
        ], 200,[],JSON_FORCE_OBJECT);
    }

    /**
     * Endpoint for update profile data.
     *
     * @param \App\Http\Requests\Api\V1\ProfileUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        $this->user->name = empty($validated['username'])?$this->user->name:$validated['username'];
        $this->user->tel_number = empty($validated['phone'])?$this->user->tel_number:$validated['phone'];
        $this->user->gender = empty($validated['gender'])?$this->user->gender:$validated['gender'];
        $this->user->save();

        return response()->json([],200, [], JSON_FORCE_OBJECT);
    }

    /**
     * @return int
     */
    private function getUserPercent(): int
    {
        $stars = $this->user->level->stars;

        return (int)round($stars * 100 / self::USER_STARS_PER_LEVEL);
    }

    /**
     * @return array
     */
    private function getUserProgress()
    {
        return [
            'level'   => $this->user->level->level,
            'current' => $this->user->level->stars,
            'max'     => 10,
            'percent' => $this->getUserPercent(),
        ];
    }

    /**
     * @param int $current Current count of progress.
     * @param int $max Max count of progress for this lvl.
     * @return int
     */
    private function getPercents(int $current, int $max): int
    {
        return (int)round(100 * $current / $max);
    }

    /**
     * @param string $name
     * @return array
     */
    private function getProgress(string $name): array
    {
        return [
            'level'   => $this->user->level->$name[2],
            'current' => $current = $this->user->level->$name[0],
            'max'     => $max = $this->user->level->$name[1],
            'percent' => $this->getPercents($current, $max),
        ];
    }
}
