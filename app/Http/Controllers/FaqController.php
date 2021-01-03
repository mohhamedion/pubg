<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\Faq;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends BaseController
{

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);
        $this->middleware('adminOnly', [
            'except' => [
                'index',
            ]
        ]);
    }

    public function index(): View
    {
        $title = trans('labels.nav.faq_full');

        $questions = Faq::all();

        return view('pages.faq', compact('title', 'questions'));
    }

    public function create(): View
    {
        $title = trans('labels.faq_create');
        $faq = new Faq();

        return view('pages.faqEdit', compact('title', 'faq'));
    }

    public function store(Request $request): RedirectResponse
    {
        Faq::query()->create($request->all([
            'question_ru',
            'answer_ru',
            'question_en',
            'answer_en',
        ]));

        Flash::success(trans('messages.success_created'));

        return redirect()->route('faq.index');
    }

    public function edit(Faq $faq): View
    {
        $title = trans('labels.faq_edit');

        return view('pages.faqEdit', compact('title', 'faq'));
    }

    public function update(Faq $faq, Request $request): RedirectResponse
    {
        $faq->update($request->all([
            'question_ru',
            'answer_ru',
            'question_en',
            'answer_en',
        ]));

        Flash::success(trans('messages.success_updated'));

        return redirect()->route('faq.index');
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json([], 201);
    }
}
