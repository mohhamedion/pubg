@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>
        <a href="{{ route('users::show::index', $user) }}"
           class="back"><i class="fa fa-chevron-circle-left"></i></a>
        {{ $title }}
    </h1>

    <div class="panel transactions-panel">
        <div class="row mb20">
            <div class="col-md-12">
                <h2 class="panel-title">@lang('labels.buttons.transactions')</h2>

                @foreach($counts as $status)
                    <div class="label-count-wrapper">
                            <span class="label label-count label-{{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        <span class="count">{{ $status['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel-body">
            <div class="row table-responsive">
                <table data-route="{{ route('transactions::index')  }}"
                       data-url="{{ route('users::show::transactions', $user) }}"
                       data-toggle="table"
                       data-page-size="10"
                       data-search="false"
                       data-locale="ru-RU"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-query-params="queryParams">
                    <thead>
                    <tr>
                        <th data-field="id"
                            data-formatter="ids"
                            data-sortable="true">ID
                        </th>

                        <th data-field="user_identifier">@lang('labels.transactions.identifier')</th>

                        <th data-field="status_for_view"
                            data-formatter="statusFormatter"
                            data-sortable="true">@lang('labels.transactions.status')</th>

                        <th data-field="amount_formatted"
                            data-width="10%"
                            data-sortable="true">@lang('labels.transactions.amount')</th>

                        <th data-field="restored"
                            data-align="center"
                            data-formatter="booleanFormatter"
                            data-sortable="true">@lang('labels.transactions.singular.restored')</th>

                        <th data-field="method"
                            data-sortable="true">@lang('labels.transactions.method')</th>

                        <th data-field="manual"
                            data-align="center"
                            data-formatter="manualFormatter"
                            data-sortable="true">@lang('labels.transactions.manual')</th>

                        <th data-field="created_at"
                            data-sortable="true">@lang('labels.transactions.created_at')</th>

                        <th data-formatter="editFormatter"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
