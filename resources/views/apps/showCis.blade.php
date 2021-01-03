@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>@lang('labels.stats')</h1>

    @include('flash::message')
    @if ($flash = session("message"))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ $flash }}
        </div>
    @endif
    <h1>{{ session("message") }}</h1>
    <div class="panel panel-buttons">
        <div class="row">
            @if($auth_user->id === $application->user_id && !$application->paid)
                <a class="button primary pay-from-balance"
                   data-route="{{ route('apps::pay_balance', ['application' => $application->id]) }}">
                    @lang('labels.buttons.pay_from_balance')
                    ({{ number_format($application->amount_for_user, 2, '.', '') }} @lang("labels.currency.Russia.name")
                    )
                </a>
                </form>
            @endif

            <a href="{{ route('apps::edit', ['application' => $application->id]) }}"
               class="button primary inline pull-right">@lang('labels.buttons.edit')</a>

            @if($is_admin)
                <a href="{{ route('apps::changes_history', ['application' => $application->id]) }}"
                   style="margin-right: 10px" id="changes_history"
                   class="button primary inline pull-right">@lang('labels.changes_history')</a>
            @endif
        </div>
    </div>

    @include('admin._appModerating', compact('application'))

    <div class="panel panel-application-show">
        <div class="row">
            <div class="col-md-12">
                <div class="row table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>@lang('labels.app')</th>
                            <th>@lang('labels.progress')</th>
                            <th>@lang('labels.runs_total')</th>
                            <th>@lang('labels.installs_today')</th>
                            <th>@lang('labels.time_delay')</th>
                            <th>@lang('labels.total_price')</th>
                            <th>@lang('labels.task_balance')</th>
                            <th>@lang('labels.wasted')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="app-table-group single_app">
                                    <img src="{{ $application->image }}" alt="{{ $application->name }}"/>
                                    <p>{{ $application->name }}</p>
                                </div>
                            </td>

                            <td>{{ $application->limit_state }}</td>

                            <td>{{ $application->total_runs }}</td>

                            <td>{{ $application->installs_today }}
                                {{ $application->daily_budget && $application->active ? ' / ' . $application->daily_budget_installs_limit : '' }}
                            </td>

                            <td>{{ $application->time_delay_formatted }}</td>

                            <td>{{  number_format(
                                $is_manager ? $application->expected_price_for_user : $application->user_task_price, 2)  . ' ' . $currency }}
                            </td>

                            <td>{{ $application->amount_for_user . ' ' . $currency }}</td>

                            <td>{{ $application->amount_wasted . ' ' . $currency }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($application->review)
            <div class="row reviews-comments">
                <div class="col-md-12" style="font-size: 16px">
                    <p class="mb10"><strong>@lang('labels.success_review')</strong>: {{ $reviews['success_review'] }}
                    </p>
                    <p><strong>@lang('labels.success_comment')</strong>: {{ $reviews['success_comment'] }}</p>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 pull-right">
                    <div class="form-group">
                        <div class="input-group date">
                            <input class="form-control app-chart col-md-1" name="date_from" data-provide="datepicker"
                                   data-id="{{ $application->id }}" placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            <input class="form-control app-chart col-md-1" name="date_to" data-provide="datepicker"
                                   data-id="{{ $application->id }}" placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <h2 class="chart-heading">@lang('labels.chart')</h2>
                <div id="app_chart">
                    @include('partials._chart')
                </div>
            </div>
        </div>
        
        @if ($is_admin)
            @if ($application->users()->wherePivot('is_accepted', 1)->count() > 0)
                <br>
                <div class="row">
                    <div class="form-group">
                        <button class="button bordered" type="button"
                                data-toggle="modal"
                                data-target="#sendPushNotificationModal">
                            @lang('labels.send_push_notification')
                        </button>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="row table-responsive">
                        <table data-sort-order="desc"
                               data-route="{{ route('users::index') }}"
                               data-toggle="table"
                               data-url="{{ route('apps::users', ['id' => $application->id]) }}"
                               data-page-size="10"
                               data-search="true"
                               data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                               data-side-pagination="server"
                               data-pagination="true"
                               data-query-params="queryParams">
                            <thead>
                            <tr>
                                <th data-field="user_identifier">@lang('labels.identifier')</th>
                                <th data-field="status_for_view" data-formatter="statusFormatter"
                                    data-sortable="true">@lang('labels.tasks.status')</th>
                                <th data-field="times" data-sortable="true">@lang('labels.tasks.times')</th>
                                <th data-field="failed_times"
                                    data-sortable="true">@lang('labels.tasks.failed_times')</th>
                                <th data-field="last_open"
                                    data-sortable="true">@lang('labels.tasks.last_open')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @include('partials._sendAppPushNotificationModal', ['url' => route('users::send-app-push')])
    @endif
@endsection

@push('styles')
    {!! Charts::assets(['global', 'areaspline', 'highcharts']) !!}
@endpush