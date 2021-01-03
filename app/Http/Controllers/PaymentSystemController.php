<?php

namespace App\Http\Controllers;

use App\Models\CardTransaction;
use App\Models\PaymentSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSystemController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $title = trans('labels.payment_systems');

        $payment_systems = CardTransaction::all();

        return view('pages.paymentSystems', compact('title', 'payment_systems'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        /** @var PaymentSystem $payment_system */
        $payment_system = CardTransaction::query()->findOrFail($request->get('id'));

        $payment_system->update([
            'active' => filter_var($request->get('state'), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json(['message' => trans('messages.success_updated')], 200);
    }

    public function updateTop(CardTransaction $card_transaction)
    {
        $card_transaction->top = $card_transaction->top ? false : true;

        $card_transaction->save();

        return response()->json(null, 200);
    }

    public function updateActive(CardTransaction $card_transaction)
    {
        $card_transaction->active = $card_transaction->active ? false : true;

        $card_transaction->save();

        return response()->json(null, 200);
    }
}
