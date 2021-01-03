<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\User;
use App\Models\Video;
use App\Traits\UserLevelTrait;
use App\Traits\UserVideoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use UserVideoTrait;
    use UserLevelTrait;

    protected $user;

    private static $hidden_video_limit_attributes = [
        'id',
        'user_id',
        'last_open',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        //$this->user = User::whereToken('test1')->first();
        if ($this->user) {
            $this->initVideos($this->user);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/videos/update",
     *     summary="Update the video",
     *     tags={"videos"},
     *     operationId="Update the video",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of video",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     *     @SWG\Response(
     *         response=410,
     *         description="Video is not available",
     *     ),
     * ),
     */
    public function updateVideo(Request $request)
    {
		$vid = $request->get('id');
		
		if($vid == 1)
			$vid = 4;
		if($vid == 2)
			$vid = 5;
		if($vid == 3)
			$vid = 6;
		
		
        $video = $this->user->videos()->find($vid);

        if (!$video && ($request->get('id') == 1 || $request->get('id') == 2)) {
            $this->user->videos()->attach($request->get('id'));
            $this->initVideos($this->user);
            $video = $this->user->videos()->find($request->get('id'));
        }

        if (!$video && $request->get('id') != 1 && $request->get('id') != 2) {
            $video = $this->user->videos()->find(3);
            if (!$video) {
                $this->user->videos()->attach(3);
                $this->initVideos($this->user);
                $video = $this->user->videos()->find(3);
            }
        }


        if ($video->pivot->is_available == 0) {
            return response()->json(null, 410);
        }

        $video->pivot->views += 1;
        $video->pivot->today_views += 1;
        $video->pivot->last_open = Carbon::now()->toDateString();

        $bonus = $this->getBonus($this->user, 'video');
        $this->progress($this->user, 'video');

        $this->user->balance += $bonus;
        $video->pivot->earned = ((float) number_format($video->pivot->earned, 2, '.', '')) + $bonus;
        $this->user->logAward($bonus , Award::AWARD_VIDEO, null);
        $this->user->save();
        $video->pivot->save();

        $user_limit = $this->user->videoLimit()->first();
        $user_limit->today_viewed += 1;
        $user_limit->save();

        return response()->json(null, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/videos",
     *     summary="Get videos",
     *     tags={"videos"},
     *     operationId="Get videos",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(ref="#/definitions/VideoZone")
     *  ),
     * ),
     */
    public function getVideos()
    {
        $ru_countries = [219, 220, 221, 222, 397];
		
		
        // if (in_array($this->user->country_id, $ru_countries)) {
            // $videos = Video::whereAvailable(1)->orderBy('top')->where('lang', 'ru')->get();
        // } else {
            // $videos = Video::whereAvailable(1)->orderBy('top')->where('lang', 'en')->get();
        // }
		$videos = Video::whereAvailable(1)->orderBy('top')->where('lang', 'en')->get();
		
        $user_videos = $this->user->videos()->get();

        if(empty($user_videos)){
            return response(404);
        }

        $videoIds = $user_videos->pluck('id');

        foreach ($videos as $video) {
            $first = array_first($videoIds, function ($value) use ($video) {
                return $value == $video->id;
            });
            if ($first) {
                continue;
            } else {
                $this->user->videos()
                    ->attach($video->id);
            }
        }

        //$this->initVideos($this->user);

        $video_limit = $this->user->videoLimit()->first();

        $video_limit->makeHidden(self::$hidden_video_limit_attributes);
	

        // if (in_array($this->user->country_id, $ru_countries)) {
            // $videos = $this->user->videos()->whereAvailable(1)->where('lang', 'ru')->orderBy('top');
        // } else {
            // $videos = $this->user->videos()->whereAvailable(1)->where('lang', 'en')->orderBy('top');
        // }
		$videos = $this->user->videos()->whereAvailable(1)->where('lang', 'en')->orderBy('top');
        $videos = $videos->get()
            ->map(function ($video) {
                $video->makeHidden(self::$hidden_video_attributes);
                $video->pivot->is_available = (bool)$video->pivot->is_available;
                $video->pivot->earned = (float)number_format($video->pivot->earned, 2, '.', '');
                $video->pivot->makeHidden(self::$hidden_pivot_v_attributes);

                return $video;
            });
		foreach($videos as $v)
		{
			if($v->title == "AdMob")
			{
				$v->id = 1;
			}
			if($v->title == "AdColony")
			{
				$v->id = 2;
			}
			if($v->title == "Fyber")
			{
				$v->id = 3;
			}
		}

        return response()->json([
            'video_limit' => $video_limit,
            'videos' => $videos,
        ], 200);
    }
}
