@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    {!! Form::open(['url' => route('stats::index'), 'method' => 'GET', 'id' => 'stats-form']) !!}
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group date">
                    <input class="form-control col-md-1" name="date_from" data-provide="datepicker"
                           placeholder="@lang('labels.date_from')"/>
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                    <input class="form-control col-md-1" name="date_to" data-provide="datepicker"
                           placeholder="@lang('labels.date_to')"/>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-12">
            <div id="data-wrapper" data-route="{{ route('stats::data') }}"></div>
        </div>
    </div>

    <div class="row table-responsive">
        <div id="toolbar">
            {!! Form::open(['url' => route('stats::add_promocode'), 'method' => 'POST']) !!}
            <div class="col-md-6" style="display : flex">
                <div class="form-group">

                    <select class="form-control" name="promocodes" title="@lang('labels.promo_code')" style="width: 175px">
                        <option value="0" selected>@lang('labels.promo_code')</option>
                        @foreach($promocodes as $code)
                            <option value="{{ $code->code }}">
                                {{ $code->code }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <hr>
                <div class="form-group">
                    <input class="form-control" type="text" name="promocode" placeholder="@lang('labels.new_promocode')" style="width: 220px"/>
                </div>
                <div class="form-group">
                    <button class="button-plus">+</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>


        <div class="col-md-12">
            <table data-sort-order="desc"
                   data-route="stats"
                   data-toggle="table"
                   data-url="{{ route('stats::getUsers') }}"
                   data-page-size="10"
                   data-filter-show-clear="true"
                   data-filter-starts-with-search="true"
                   data-side-pagination="server"
                   data-pagination="true"
                   data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                   data-query-params="queryParams">
                <thead>
                <tr>
                    <th data-field="identifier">@lang('labels.identifier')</th>

                    <th data-field="earned"
                        data-sortable="true">@lang('labels.total_earned')</th>

                    <th data-field="video_earned"
                        data-sortable="true">@lang('labels.earned_by_videos')</th>

                    <th data-field="partner_earned"
                        data-sortable="true">@lang('labels.earned_by_partners')</th>

                    <th data-field="balance" data-sortable="true">@lang('labels.balance')</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let date_from = $('#date_from');
        let date_to = $('#date_to');
        $(function () {
            date_from.datetimepicker({
                format: 'YYYY-MM-DD'
            });
            date_to.datetimepicker({
                useCurrent: false,
                format: 'YYYY-MM-DD'
            });
            date_from.on("dp.change", function (e) {
                date_to.data("DateTimePicker").minDate(e.date);
            });
            date_to.on("dp.change", function (e) {
                date_from.data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
@endsection