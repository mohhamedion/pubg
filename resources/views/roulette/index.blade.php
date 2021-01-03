@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>
        <a href="{{ route('roulette::settings') }}"
           title="@lang('labels.settings')"><i class="fa fa-wrench"></i></a>
        {{ $title }}
    </h1>

    <div class="panel panel-roulette">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group date">
                        <input class="form-control col-md-1 roulette-date" name="date_from" data-provide="datepicker"
                               placeholder="@lang('labels.date_from')"/>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <input class="form-control col-md-1 roulette-date" name="date_to" data-provide="datepicker"
                               placeholder="@lang('labels.date_to')"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                <div class="row table-responsive" style="width: auto;">
                    <table id="roulette-table"
                           class="table-roulette"
                           data-route="{{ route('roulette::index') }}"
                           data-url="{{ route('roulette::rolls') }}"
                           data-toggle="table"
                           data-page-size="10"
                           data-search="false"
                           data-locale="ru-RU"
                           data-side-pagination="server"
                           data-pagination="true"
                           data-sort-order="desc"
                           data-query-params="queryParams">
                        <thead>
                        <tr>
                            <th data-field="user_identifier">@lang('labels.transactions.identifier')</th>

                            <th data-field="bet_formatted"
                                data-sortable="true">@lang('labels.bet_label')</th>

                            <th data-field="amount_formatted"
                                data-sortable="true">@lang('labels.amount_got')</th>

                            <th data-field="result"
                                data-formatter="booleanFormatter"
                                data-sortable="true">@lang('labels.result')</th>

                            <th data-field="created_at"
                                data-sortable="true">@lang('labels.date')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row">
            <div class="col-md-12">
                <h3 class="mb10">@lang('labels.stats')</h3>
                <div class="row table-responsive" id="roulette-stats" style="width: auto;">
                    @include('roulette._stats_table')
                </div>
            </div>
        </div>
    </div>
@endsection