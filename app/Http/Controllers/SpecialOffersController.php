<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Http\Requests\SpecialOfferRequest;
use App\Models\SpecialOffer;
use App\Models\User;
use DB;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SpecialOffersController extends BaseController
{
    public function index(): View
    {
        $title = trans('labels.nav.special_offers');
        $offers = SpecialOffer::all();
        if ($this->is_admin) {
            $users = User::query()->whereHas('specialOffers')->get();
        } else {
            $users = new Collection();
        }

        return view('special_offers.index', compact('title', 'offers', 'users'));
    }

    public function create(): View
    {
        $title = trans('labels.special_offer_create');
        $offer = new SpecialOffer([
            'amount' => 0,
            'features' => [],
        ]);

        return view('special_offers.edit', compact('title', 'offer'));
    }


    public function store(SpecialOfferRequest $request): RedirectResponse
    {
        $popular = filter_var($request->get('popular'));

        if ($popular) {
            SpecialOffer::wherePopular(true)->update(['popular' => false]);
        }

        if (!$request->has('features')) {
            $request['features'] = [];
        }

        SpecialOffer::query()->create(array_merge(
            $request->all('name', 'amount', 'features', 'popular'),
            [
                'popular' => $popular ? $popular : false,
            ]
        ));

        Flash::success(trans('messages.success_created'));

        return redirect()->route('special_offers::index');
    }

    public function edit(SpecialOffer $offer): View
    {
        $title = trans('labels.special_offer_edit');

        return view('special_offers.edit', compact('title', 'offer'));
    }

    public function update(SpecialOfferRequest $request, SpecialOffer $offer): RedirectResponse
    {
        $popular = filter_var($request->get('popular'));

        if ($popular) {
            SpecialOffer::wherePopular(true)->update(['popular' => false]);
        }

        if (!$request->has('features')) {
            $request['features'] = [];
        }

        $offer->update(array_merge(
            $request->all('name', 'amount', 'features', 'popular'),
            [
                'popular' => $popular,
            ]
        ));

        Flash::success(trans('messages.success_updated'));

        return redirect()->route('special_offers::index');
    }

    public function destroy(SpecialOffer $offer): JsonResponse
    {
        $offer->delete();

        return response()->json([], 201);
    }

    public function userDetach(int $user_offer): JsonResponse
    {
        DB::table('user_special_offer_pivot')->delete($user_offer);

        return response()->json([], 201);
    }

    public function payFromBalance(Request $request): RedirectResponse
    {
        /** @var SpecialOffer $offer */
        $offer = SpecialOffer::query()->findOrFail($request->get('id'));
        $user = $this->auth_user;

        if ($user->balance >= $offer->amount) {
            $user->specialOffers()->attach($offer->id, [
                'amount' => app(CurrencyServiceInterface::class)->convertToRub($offer->amount),
                // Store to DB in RUB currency
                'search_query' => $request->get('search_query'),
                'package_name' => $request->get('package_name'),
            ]);

            $user->update([
                'balance' => $user->balance - $offer->amount,
            ]);

            Flash::success('<div style="font-size: 12pt">'
                . trans('messages.special_offer_buy_success') . '</div>');
        } else {
            Flash::error('<div style="font-size: 12pt">' . trans('messages.not_enough_money')
                . ' <a href="' . route('account::balance') . '"'
                . ' class="alert-text-link">' . trans('labels.replenish') . '</a>'
                . '</div>');
        }

        return redirect()->route('special_offers::index');
    }
}
