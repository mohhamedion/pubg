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