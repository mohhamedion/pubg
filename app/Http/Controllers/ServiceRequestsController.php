<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestType;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lang;

class ServiceRequestsController extends BaseController
{
    /** @var ServiceRequestType */
    private $type;

    public function __construct(Request $request, CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);

        if ($request->route()) {
            $name = $request->route()->parameter('service_type');
        } else {
            $name = 'top';
        }

        $this->type = ServiceRequestType::whereName($name)->first();
        $title = null;
        $title = Lang::trans('labels.nav.to_top2');
        if (isset($this->type->name)){
            switch ($this->type->name) {
                case 'top':
                    $title = Lang::trans('labels.nav.to_top2');
                    break;
                case 'aso':
                    $title = Lang::trans('labels.nav.aso_opt');
                    break;
                case 'comments':
                    $title = Lang::trans('labels.nav.testimonials');
                    break;
            }
        }


        view()->share([
            'type' => $this->type,
            'title' => $title,
        ]);
    }

    public function index(): View
    {
        $requests = [];

        // if ($this->is_admin) {
            // $requests = $this->type->requests;
        // }

        return view('service_request.index', compact('requests'));
    }

    public function show(Request $request)
    {
		$requests = [];
		return view('service_request.index', compact('requests'));
        $request_id = (int) $request->route('service_request');

        /** @var ServiceRequest $request */
        $request = ServiceRequest::query()->find($request_id);

        if (!$request->is_read) {
            $request->update(['is_read' => true]);
        }

        return view('service_request.request', compact('request'));
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = array_filter($request->all('email', 'url', 'skype_telegram', 'description'));
        $service_request = new ServiceRequest($attributes);

        $service_request->type()->associate($this->type);
        $service_request->user()->associate($this->auth_user);

        $service_request->save();

        Flash::success(Lang::trans('messages.service_request_success'));

        return redirect()->back();
    }

    public function destroy(Request $request): JsonResponse
    {
        $request_id = (int) $request->route('service_request');

        ServiceRequest::query()->find($request_id)->delete();

        return response()->json([], 201);
    }
}
