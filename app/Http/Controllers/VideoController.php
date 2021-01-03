<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    public function index()
    {
        $title = trans('labels.nav.videos');

		$lang = Config::get('app.locale');
		
		$videos = Video::where('lang', $lang)->get();

        return view('videos.index', compact(['videos', 'title']));
    }

    public function updateTop(Video $video)
    {
        $video->top = $video->top ? false : true;

        $video->save();

        return response()->json(null, 200);
    }

    public function updateAvailable(Video $video)
    {
        $video->available = $video->available ? false : true;

        $video->save();

        return response()->json(null, 200);
    }

}
