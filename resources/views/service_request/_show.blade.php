@if(count($requests) > 0)
    @foreach($requests as $request)
        <div class="service-request">
            <div class="row">
                <div class="col-md-4">
                    <table>
                        <tr>
                            <td>@lang('labels.created_by'):</td>
                            <td class="value"><a href="{{ route('users::show::index', $request->user) }}">
                                    {{ !empty($request->user->name) ? $request->user->name : $request->user->email }}
                                </a></td>
                        </tr>
                        <tr>
                            <td>@lang('labels.created_at'):</td>
                            <td class="value"><strong>{{ $request->created_at }}</strong></td>
                        </tr>
                        <tr>
                            <td>Skype/Telegram:</td>
                            <td class="value"><strong>{{ $request->skype_telegram }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-7">
                    <table>
                        <tr>
                            <td>Email:</td>
                            <td class="value"><a href="mailto:{{ $request->email }}">{{ $request->email }}</a></td>
                        </tr>
                        <tr>
                            <td>@lang('labels.app_url'):</td>
                            <td class="value"><strong><a href="{{ $request->url }}">{{ $request->url }}</a></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>@lang('labels.description'):</td>
                            <td class="value">{{ $request->description }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-1 request-delete-wrapper">
                    <a href="{{ route('service::destroy', ['service_type' => $type->name, 'service_request' => $request]) }}"
                       class="request-delete block-link"
                       title="@lang('labels.buttons.delete')">
                        <i class="icons8-delete"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@else
 <div class="services-empty">
    <!--<h3>@lang('labels.no_requests')</h3>-->
	<h3>@lang('labels.no_requests2')</h3>
</div>
@endif