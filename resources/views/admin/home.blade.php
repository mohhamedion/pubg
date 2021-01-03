<div class="panel-charts">
    <div class="row">
        <div class="col-md-6 chart-row">
            <div class="panel">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 input-group date">
                            <input class="form-control col-md-4" name="date_from"
                                value="{{ Carbon\Carbon::today()->subDays(6)->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="users_task_chart" data-route="{{ route('chart.tasks') }}"
                                placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="calendar"></span>
                            </div>
                            <input class="form-control col-md-4" name="date_to"
                                value="{{ Carbon\Carbon::today()->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="users_task_chart" data-route="{{ route('chart.tasks') }}"
                                placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <div id="users_task_chart" data-route="{{ route('chart.tasks') }}"></div>
            </div>
        </div>

        <div class="col-md-6 chart-row">
            <div class="panel">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 input-group date">
                            <input class="form-control col-md-4" name="date_from"
                                value="{{ Carbon\Carbon::today()->subDays(6)->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="register_chart" data-route="{{ route('chart.register') }}"
                                placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="calendar"></span>
                            </div>
                            <input class="form-control col-md-4" name="date_to"
                                value="{{ Carbon\Carbon::today()->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="register_chart" data-route="{{ route('chart.register') }}"
                                placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <div id="register_chart" data-route="{{ route('chart.register') }}"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 chart-row">
            <div class="panel">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 input-group date">
                            <input class="form-control col-md-4" name="date_from"
                                value="{{ Carbon\Carbon::today()->subDays(3)->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="awards_chart" data-route="{{ route('chart.awards') }}"
                                placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="calendar"></span>
                            </div>
                            <input class="form-control col-md-4" name="date_to"
                                value="{{ Carbon\Carbon::today()->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="awards_chart" data-route="{{ route('chart.awards') }}"
                                placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <h2 style="margin-top: 200px; text-align: center">Temporarily Unavailable</h2>
                {{--<div id="awards_chart" data-route="{{ route('chart.awards') }}"></div>--}}
            </div>
        </div>

        <div class="col-md-6 chart-row">
            <div class="panel">
                <div id="earned_chart" data-route="{{ route('chart.earned') }}"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 chart-row">
            <div class="panel">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 input-group date">
                            <input class="form-control col-md-4" name="date_from"
                                value="{{ Carbon\Carbon::today()->subDays(6)->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="transactions_chart" data-route="{{ route('chart.transactions') }}"
                                placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="calendar"></span>
                            </div>
                            <input class="form-control col-md-4" name="date_to"
                                value="{{ Carbon\Carbon::today()->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="transactions_chart" data-route="{{ route('chart.transactions') }}"
                                placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <div id="transactions_chart" data-route="{{ route('chart.transactions') }}"></div>
            </div>
        </div>

        <div class="col-md-6 chart-row">
            <div class="panel">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-6 input-group date">
                            <input class="form-control col-md-4" name="date_from"
                                value="{{ Carbon\Carbon::today()->subDays(6)->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="transactions_amount_chart" data-route="{{ route('chart.transactions_amount') }}"
                                placeholder="@lang('labels.date_from')"/>
                            <div class="input-group-addon">
                                <span class="calendar"></span>
                            </div>
                            <input class="form-control col-md-4" name="date_to"
                                value="{{ Carbon\Carbon::today()->format('d-m-Y') }}" data-provide="datepicker"
                                data-chart="transactions_amount_chart" data-route="{{ route('chart.transactions_amount') }}"
                                placeholder="@lang('labels.date_to')"/>
                        </div>
                    </div>
                </div>
                <div id="transactions_amount_chart" data-route="{{ route('chart.transactions_amount') }}"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 chart-row">
            <div class="panel">
                <div id="locations_chart" data-route="{{ route('chart.locations') }}"></div>
            </div>
        </div>
        <div class="col-md-4 chart-row">
            <div class="panel">
                <div id="locations_pie_chart" data-route="{{ route('chart.locations_pie') }}"></div>
            </div>
        </div>
    </div>
</div>