<?php

namespace App\Http\Controllers;

use Config;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends BaseController
{
    public function index()
    {
        $title = trans('labels.nav.partners');

		$lang = Config::get('app.locale');

        $partners = Partner::where('lang', $lang)->get();

        return view('partners.index', compact(['partners', 'title']));
    }

    public function updateTop(Partner $partner)
    {
        $partner->top = $partner->top ? false : true;

        $partner->save();

        return response()->json(null, 200);
    }

    public function updateAvailable(Partner $partner)
    {
        $partner->is_available = $partner->is_available ? false : true;

        $partner->save();

        return response()->json(null, 200);
    }
}
