@extends('layouts.app')

@section('title', trans('labels.buttons.transactions'))

@section('content')
    @include('flash::message')

    <div class="panel transactions-panel">
        <div class="row mb20">
            <div class="col-md-12">
                <h2 class="panel-title">@lang('labels.buttons.transactions')</h2>
    
                <div class="flex-wrap">
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
        </div>

        <div class="row table-responsive" style="width: auto;">

            <div id="toolbar">
                <div class="form-inline mb20" role="form">
                    <div class="form-group">
                        <select name="status" title="@lang('labels.status.status')" style="width: 205px;color: #616161;">
                            <option value="all">@lang('labels.all_statuses')</option>
                            @foreach($statuses as $value => $status)
                                <option value="{{ $value }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="input-group date">
                            <input class="form-control col-md-1" name="date_from" data-provide="datepicker"
                                   placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="date-icon"></span>
                            </div>
                            <input class="form-control col-md-1" name="date_to" data-provide="datepicker"
                                   placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="search" class="form-control"
                               placeholder="@lang('labels.search')"/>
                    </div>
                </div>
            </div>

            <table id="transactions-table"
                   class="table-transactions"
                   data-route="{{ route('transactions::index')  }}"
                   data-url="{{ route('transactions::get') }}"
                   data-toggle="table"
                   data-page-size="10"
                   data-search="false"
                   data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                   data-side-pagination="server"
                   data-pagination="true"
                   data-query-params="queryParams">
                <thead>
                    <tr>
                        <th data-field="user_identifier">@lang('labels.transactions.identifier')</th>

                        <th data-field="phone"
                            data-sortable="true">@lang('labels.transactions.data')</th>

                        <th data-field="status_for_view"
                            data-formatter="statusFormatter"
                            data-sortable="true">@lang('labels.transactions.status')</th>

                        <th data-field="amount_formatted"
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

                        <th data-field="created_at"
                            data-sortable="true">@lang('labels.transactions.created_at')</th>                            

                        <th data-formatter="editFormatter" class="actions_column" data-field="id"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('[data-action="link"]').click(function () {
            let link = $(this).closest('[data-action="link"]').data('href');
            window.open(link);
        });
    </script>
@endsection