@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>
        <a href="{{ route('users::show::index', $user) }}"
           class="back"><i class="fa fa-chevron-left"></i></a>
        {{ $title }}
    </h1>

    <div class="panel">
        <div class="panel-body">
            <div class="row table-responsive">
                <table data-sort-order="desc"
                       data-toggle="table"
                       data-route="{{ route('apps::index') }}"
                       data-url="{{ route('users::show::tasks', $user) }}"
                       data-page-size="10"
                       data-search="true"
                       data-locale="ru-RU"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-currency="{{ $currency }}"
                       data-query-params="queryParams">
                    <thead>
                    <tr>
                        <th data-field="app.name" data-formatter="app_names">@lang('labels.name')</th>

                        <th data-field="app.price"
                            data-formatter="amount">@lang('labels.install-price')</th>

                        <th data-field="status_for_view" data-formatter="statusFormatter"
                            data-sortable="true">@lang('labels.tasks.status')</th>

                        <th data-field="app.days">@lang('labels.install-limit-days')</th>

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
@endsection