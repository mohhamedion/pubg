@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <div class="panel panel-settings">
        <div class="row">
            <div class="col-md-12">
            @include('flash::message')
            {!! Form::model($settings, ['url' => '/settings', 'method' => 'PATCH']) !!}

            <!--- Email Field --->
                <div class="form-group">
                    {!! Form::label('email', trans('labels.notification_email')) !!}
                    {!! Form::input('email', 'email', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- Exchange Rate Field --->
                <div class="form-group">
                    {!! Form::label('rate', trans('labels.rate')) !!}
                    {!! Form::input('rate', 'uc_rate', null, ['class' => 'form-control', 'required']) !!}
                </div>

              <div class="form-group">
                    {!! Form::label('points rate', 'points rate') !!}
                    {!! Form::input('points_rate', 'points_rate', null, ['class' => 'form-control', 'required']) !!}
                </div>

      <!--- Exchange Rate Field --->
                <div class="form-group">
                    {!! Form::label('rate', 'popularity rate') !!}
                    {!! Form::input('rate', 'popularity_rate', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- Task Reminder Text Field --->
                <div class="form-group">
                    {!! Form::label('task_reminder_text', trans('labels.task_reminder_text')) !!}
                    {!! Form::textarea('task_reminder_text', null, ['class' => 'form-control', 'required', 'rows' => '3']) !!}
                </div>

                {{--Register user with promo reward--}}
               {{-- <div class="form-group">
                    {!! Form::label('award_register_with_promo', trans('labels.award_register_with_promo')) !!}
                    <input type="number" class="form-control" title="Application downloads minimum"
                           name="award_register_with_promo" min="1" step="1" pattern="\d+" required
                           value="{{ $settings['award_register_with_promo'] }}"/>
                </div>--}}

                <!--- Minimal Application installs in order --->
                <div class="form-group">
                    {!! Form::label('application_downloads_min_limit', trans('labels.app_minimum_downloads')) !!}
                    <input type="number" class="form-control" title="Application downloads minimum"
                           name="application_downloads_min_limit" min="1" step="1" pattern="\d+" required
                           value="{{ $settings['application_downloads_min_limit'] }}"/>
                </div>

                <!--- Minimal balance replenishment (manager) --->
                <div class="form-group">
                    {!! Form::label('balance_replenishment_min', trans('labels.balance_replenishment_min') . ', ' . $currency, '') !!}
                    <input type="number" class="form-control" title="Minimal balance replenishment"
                           name="balance_replenishment_min" value="{{ $settings['balance_replenishment_min'] }}"
                           step="0.01" required>
                </div>

                <!--- Campaign additional conditions (descriptions) price --->
                <div class="form-group">
                    {!! Form::label('description_price', trans('labels.description_price') . ', ' . $currency, '') !!}
                    <input type="number" class="form-control" title="Description price"
                           name="description_price" value="{{ $settings['description_price'] }}"
                           step="0.01" required>
                </div>

                <div class="form-group mb40">
                    {!! Form::label('top_price', trans('labels.top_price') . ', ' . $currency, '') !!}
                    <input type="number" class="form-control" title="Top price"
                           name="top_price" value="{{ $settings['top_price'] }}"
                           step="0.01" required>
                </div>

                <div class="form-group mb40">
                    {!! Form::label('version', trans('labels.version') ) !!}
                    <input style="width: 20%;" type="number" class="form-control" title="Version"
                           name="version" value="{{ $settings['version'] }}"
                           step="0.1">
                </div>

              {{--  <div class="form-group">
                    {!! Form::label('description_price', trans('labels.click_price') . ', ' . $currency, '') !!}
                    <input type="number" class="form-control" title="Clicks price"
                           name="click_price" value="{{ $settings['click_price'] }}"
                           step="0.01" required>
                </div>--}}

                <!--- Header notification --->
                {{--<div class="form-group">
                    {!! Form::label('system_notification', trans('labels.system_notification'), ['style' => 'margin-top: 5px']) !!}
                    <label class="switch" title="@lang('labels.activate_system_notification')">
                        <input type="checkbox" name="system_notification_active" value="1" class="switch"
                               id="systemNotificationActive"
                                --}}{{--{{ $headerNotification->active ? 'checked' : '' }}--}}{{--/>
                        <span class="slider round"></span>
                    </label>
                    <div class="row" id="systemNotificationWrapper">
                        <div class="row form-group" style="margin-bottom: 10px">
                            <label for="system_notification_text" class="col-md-2"
                                   style="margin-top: 10px">@lang('labels.system_notification_text')</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="system_notification_text"
                                       value="--}}{{--{{ $headerNotification->text }}--}}{{--">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="system_notification_background_color" class="col-md-2"
                                   style="margin-top: 7px">@lang('labels.system_notification_background_color')</label>
                            <div class="col-md-2">
                                <input type="color" class="form-control" name="system_notification_background_color"
                                       value="--}}{{--{{ $headerNotification->background_color }}--}}{{--">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="system_notification_text_color" class="col-md-2"
                                   style="margin-top: 7px">@lang('labels.system_notification_text_color')</label>
                            <div class="col-md-2">
                                <input type="color" class="form-control" name="system_notification_text_color"
                                       value="--}}{{--{{ $headerNotification->text_color }}--}}{{--">
                            </div>
                        </div>
                    </div>
                </div>--}}

                <!-- Nav tabs -->
                                    
                <div class="row mb40">
                    <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#commissions" aria-controls="commissions"
                                                              role="tab"
                                                              data-toggle="tab">@lang('labels.commission_settings')</a>
                    </li>
                    {{--<li role="presentation"><a href="#referral_first" aria-controls="referral_first" role="tab"
                                               data-toggle="tab">@lang('labels.referral_first')</a></li>
                    <li role="presentation"><a href="#referral_second" aria-controls="referral_second" role="tab"
                                               data-toggle="tab">@lang('labels.referral_second')</a></li>--}}
                    <li role="presentation"><a href="#standard_tasks" aria-controls="standard_tasks" role="tab"
                                               data-toggle="tab">@lang('labels.standard_tasks')</a></li>
                    <li role="presentation"><a href="#cashback_settings" aria-controls="cashback_settings" role="tab"
                                               data-toggle="tab">@lang('labels.cashback.cashback')</a></li>
                    <li role="presentation"><a href="#prices" aria-controls="prices" role="tab"
                                               data-toggle="tab">@lang('labels.prices')</a></li>
                    <li role="presentation"><a href="#promocode_rewards" aria-controls="promocode_rewards" role="tab"
                                               data-toggle="tab">@lang('labels.promocode_rewards')</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- COMMISSION TAB --}}
                    <div role="tabpanel" class="tab-pane fade in active" id="commissions">
                        @include('partials._settings-commission')
                    </div>

                    {{-- FIRST REFERRAL SYSTEM TAB --}}
                    {{--<div role="tabpanel" class="tab-pane fade" id="referral_first">
                        @include('partials._settings-referral-first')
                    </div>

                    --}}{{-- SECOND REFERRAL SYSTEM TAB --}}{{--
                    <div role="tabpanel" class="tab-pane fade" id="referral_second">
                        @include('partials._settings-referral-second')
                    </div>--}}

                    {{-- STANDARD TASKS TAB --}}
                    <div role="tabpanel" class="tab-pane fade" id="standard_tasks">
                        @include('partials._settings-standard-tasks')
                    </div>
                    {{-- Cashback settings--}}
                    <div role="tabpanel" class="tab-pane fade" id="cashback_settings">
                        @include('partials._settings-cashback')
                    </div>
                    {{-- PRICES SETTINGS--}}
                    <div role="tabpanel" class="tab-pane fade" id="prices">
                        <div class="row">
                            <div class="col-md-6 price-settings">
                                <h3 class="mb10">@lang('labels.price_settings_user')</h3>
                                @include('partials._settings-prices_user')
                            </div>

                            <div class="col-md-6 price-settings">
                                <h3 class="mb10">@lang('labels.price_settings_manager')</h3>
                                @include('partials._settings-prices_manager')
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="promocode_rewards">
                        <div class="row">
                            <div class="col-md-8 promocode_rewards">
                                @include('partials._promocode_rewards')
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                    </div>

                <div class="row mb20">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs mb10" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#24h" aria-controls="24h" role="tab"
                                   data-toggle="tab">@lang('labels.24_h')</a>
                            </li>
                            <li role="presentation">
                                <a href="#48h" aria-controls="48h" role="tab"
                                   data-toggle="tab">@lang('labels.48_h')</a>
                            </li>
                            <li role="presentation">
                                <a href="#72h" aria-controls="72h" role="tab"
                                   data-toggle="tab">@lang('labels.72_h')</a>
                            </li>
                            <li role="presentation">
                                <a href="#other" aria-controls="Other" role="tab"
                                   data-toggle="tab">@lang('labels.other_countries')</a>
                            </li>
                            <li role="presentation">
                                <a href="#other_type" aria-controls="Other_type" role="tab"
                                   data-toggle="tab">@lang('labels.other_type')</a>
                            </li>
                            <li role="presentation">
                                <a href="#for_install" aria-controls="For_install" role="tab"
                                   data-toggle="tab">@lang('labels.for_install')</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="24h">
                                @include('partials._prices_24h')
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="48h">
                                @include('partials._prices_48h')
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="72h">
                                @include('partials._prices_72h')
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="other">
                                @include('partials._prices_otherCountries')
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="other_type">
                                @include('partials._prices_otherType')
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="for_install">
                                @include('partials._prices_for_install')
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row mb20">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <h3 class="mb10">@lang('labels.levels.title')</h3>
                        <ul class="nav nav-tabs mb10" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#level_1" aria-controls="level_1" role="tab"
                                   data-toggle="tab">1</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_2" aria-controls="level_2" role="tab"
                                   data-toggle="tab">2</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_3" aria-controls="level_3" role="tab"
                                   data-toggle="tab">3</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_4" aria-controls="level_4" role="tab"
                                   data-toggle="tab">4</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_5" aria-controls="level_5" role="tab"
                                   data-toggle="tab">5</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_6" aria-controls="level_6" role="tab"
                                   data-toggle="tab">6</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_7" aria-controls="level_7" role="tab"
                                   data-toggle="tab">7</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_8" aria-controls="level_8" role="tab"
                                   data-toggle="tab">8</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_9" aria-controls="level_9" role="tab"
                                   data-toggle="tab">9</a>
                            </li>
                            <li role="presentation">
                                <a href="#level_10" aria-controls="level_10" role="tab"
                                   data-toggle="tab">10</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            @foreach ($levels as $level)
                                @if ($loop->first)
                                    <div role="tabpanel" class="tab-pane fade in active" id="level_{{$level->level}}">
                                        @include ('partials._level')
                                    </div>
                                    @continue
                                @endif
                                    <div role="tabpanel" class="tab-pane fade" id="level_{{$level->level}}">
                                        @include ('partials._level')
                                    </div>
                            @endforeach
                        </div>

                    </div>
                </div>


                <input type="submit" class="button button-submit primary" value="@lang('labels.save')"/>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var systemNotificationActive = $('#systemNotificationActive');
        var systemNotificationWrapper = $('#systemNotificationWrapper');
        checkSystemNotificationCheked();
        systemNotificationActive.change(checkSystemNotificationCheked);

        function checkSystemNotificationCheked() {
            if (systemNotificationActive.prop('checked')) {
                systemNotificationWrapper.slideDown(250);
            } else {
                systemNotificationWrapper.slideUp(250);
            }
        }
    </script>
@endpush