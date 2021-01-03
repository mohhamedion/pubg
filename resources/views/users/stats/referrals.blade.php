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
                <table data-toggle="table"
                       data-sort-order="desc"
                       data-route="{{ route('users::index') }}"
                       data-url="{{ route('users::show::referrals', $user) }}"
                       data-page-size="10"
                       data-locale="ru-RU"
                       data-filter-control="true"
                       data-filter-show-clear="true"
                       data-filter-starts-with-search="true"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-query-params="queryParams">
                    <thead>
                    <tr>
                        <th data-field="identifier"
                            data-formatter="userIdentifierFormatter">@lang('labels.identifier')</th>

                        <th data-field="balance_formatted"
                            data-sortable="true">@lang('labels.balance')</th>

                        <th data-field="referrals_count"
                            data-sortable="true">@lang('labels.referrals')</th>

                        <th data-field="banned" data-formatter="banned" data-sortable="true">Забанен</th>

                        <th data-field="created_at"
                            data-sortable="true">@lang('labels.registered_at')
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection