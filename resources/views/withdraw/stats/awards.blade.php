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
                       data-route="{{ url('/apps') }}"
                       data-toggle="table"
                       data-url="{{ route('users::show::awards', $user) }}"
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
                        <th data-field="id" data-formatter="ids" data-class="hidden">ID</th>

                        <th data-field="referral_system_label"
                            data-sortable="true">@lang('labels.transactions.method')</th>

                        <th data-field="amount_formatted"
                            data-sortable="true">@lang('labels.amount')</th>

                        <th data-field="app.image"
                            data-formatter="image"
                            class="hidden">
                        </th>

                        <th data-field="app.package_name" data-formatter="packages" class="hidden">
                            Package name
                        </th>

                        <th data-field="app.name"
                            data-formatter="app_names">@lang('labels.name')</th>

                        <th data-field="created_at"
                            data-sortable="true">@lang('labels.transactions.created_at')
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
