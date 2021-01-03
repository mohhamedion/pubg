@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    @if(is_null($application->id))
        {{-- Form of adding new application to order --}}
        <div class="panel panel-add-app">
            <h1 class="panel-title">@lang('labels.platform')</h1>

            <div class="platforms ">
               
                    <div class="platforms-item platforms-item__android"></div>
               
                    <div class="right-panel">

                    <div class="platforms-item platforms-item__ios"></div>

                         <form action="{{ route('apps::store') }}" method="POST">
                            {{ csrf_field() }}
                            {!! Form::hidden('device_type', '', ['id' => 'device_type']) !!}
                            <div class="form-group form-group__package_name">
                                <label for="package_name">@lang('labels.input_package_name_or_url_android')</label>
                                <input class="form-control" id="package_name" name="package_name"
                                    {{--value="{{ $application->package_name }}"--}}
                                    placeholder="@lang('labels.placeholder_package_name_url')"/>
                                <button type="button" class="button primary" id="find_app">
                                    @lang('labels.find_app')
                                </button>
                            </div>

                            <div class="application_preview">
                                <div class="application_preview__logo">
                                    <img src="//lh3.googleusercontent.com/jVXglyWWL5J2y1vRN-7Jy3_ozvvZc4w5486IAkbAIrWcNN_vn7YuIvhc1JDtGq43BqGl=w300"
                                        id="application_logo">
                                    <input type="hidden" name="image_url" value=""/>
                                </div>
                                <div class="application_preview__name">
                                    <h3 id="app_name"></h3>
                                    <input type="hidden" name="title">
                                    <h5 id="package_name_preview"></h5>
                                    <input class="button primary" type="submit" value="@lang('labels.continue')"/>
                                </div>
                            </div>
                        </form>
                    </div>
                   
       
            </div>
            
        </div>
    @else
        {{-- Form of edit existing application --}}
        @if($auth_user->id === $application->user_id && !$application->paid)
            <div class="panel panel-buttons panel-buttons_payment">
                <a class="button primary pay-from-balance"
                   data-route="{{ route('apps::pay_balance', ['application' => $application->id]) }}">
                    @lang('labels.buttons.pay_from_balance')
                    (<span id="pay_value">{{ number_format($application->amount_for_user, 2, '.', '') }}</span>
                    @lang("labels.currency.${country}.name"))
                </a>
                </form>
            </div>
        @endif

        @include('admin._appModerating', compact('application'))

        <div class="panel panel-edit-app">
            <div class="app-header">
                <div class="image"><img src="{{ $application->image }}" alt="{{ $application->name }}"></div>
                <h1 class="title">
                    <a href="{{ route('apps::show', $application) }}" target="_blank">{{ $application->name }}</a>
                </h1>
                <button type="button" class="icon-button refresh-app" title="@lang('labels.refresh_app')">
                    <i class="fa fa-refresh"></i>
                </button>
            </div>

            <form class="form-horizontal" action="{{ route('apps::update', ['id' => $application->id]) }}"
                  name="app_form" method="POST">
                {{ csrf_field() }}
                {!! Form::hidden('device_type', $application->device_type, ['readonly']) !!}
                {!! Form::hidden('package_name', $application->package_name, ['readonly']) !!}
                {{--                {!! Form::hidden('name', $application->name, ['readonly']) !!}--}}
                {!! Form::hidden('image_url', $application->image, ['readonly']) !!}
                {!! Form::hidden('slug', $application->slug, ['readonly']) !!}

                <div class="form-item row">
                    <div class="form-item_header">
                        <div class="option-icon app-name"></div>
                        <h2>@lang('labels.application_name')</h2>
                    </div>
                    <div class="form-item_body col-lg-8">
                        <div class="row">
                            <input type="text" class="form-control" name="title" value="{{$application->title}}" required>
                        </div>
                    </div>
                </div>

                <div class="form-item row">
                    <div class="form-item_header">
                        <div class="option-icon geotarget"></div>
                        <h2>@lang('labels.geotargeting')</h2>
                        <div class="switch-status">
                        <label class="switch" title="@lang('labels.promotion_type')">
                            <input type="checkbox" name="promotion_type" value="0" class="switch" id="geo-promotion"
                                   checked onclick="return false"
                                   @if(!$can_be_changed) disabled @endif/>
                            <span class="slider round"></span>
                        </label>
                        </div>
                    </div>
                    <div class="form-item_body col-lg-8">
                        <div class="row flex-row">
                            <div class="geotarget-select">
                                <select name="country_group" id="country_group" required
                                        data-groups="{{ json_encode($countryGroups) }}"
                                        @if(!$can_be_changed) disabled @endif>
                                    <option value="" selected disabled>@lang('labels.empty.countryGroup')</option>
                                    @foreach(array_keys($countryGroups) as $group)
                                        <option value="{{ $group }}"
                                                {{ $application->country_group === $group ? 'selected' : '' }}
                                        >@lang("labels.country_group.$group")</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="geotarget-select">
                                {!! Form::select('country', $countries, $application->country_id, [
                                        'id' => 'country',
                                        'data-placeholder' => trans('labels.all.countries'),
                                        'disabled' => !$can_be_changed
                                        ]) !!}
                            </div>
                            <div class="geotarget-select">
                                {!! Form::select('city', $cities, $application->city_id, [
                                        'id' => 'city',
                                        'data-placeholder' => trans('labels.all.cities'),
                                        'disabled' => !$can_be_changed
                                        ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Here will be loaded campaign parameters depending on selected group of countries (CIS/Other) --}}
                <div class="custom-params">
                    <div class="loader-wrapper form-item row">
                        <div class="form-item_body col-lg-8">
                            <div class="loader">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                                            stroke-miterlimit="10"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="custom-params-wrapper"></div>
                </div>


                {{--Deferred campaign start--}}
                <div class="form-item row">
                    <div class="form-item_header">
                    <div class="option-icon schedule"></div>
                        <h2>@lang('labels.tasks.scheduled_launch')</h2>
                        <div class="switch-status">
                        <label class="switch" title="@lang('labels.tasks.scheduled_launch')">
                            <input type="checkbox" name="min_tasks_limit_active"
                                   id="min_tasks_limit_active" value="1" class="switch"
                                    {{ $application->deferred_start ? 'checked disabled' : '' }}
                            />
                            <span class="slider round"></span>
                        </label>
                        </div>
                    </div>
                    <div class="form-item_body col-lg-8 min_tasks_limit_count">
                        <div class="row">
                            <label for="min_tasks_limit" class="mb10">
                                @lang('labels.tasks.scheduled_launch')</label>

                            <div class="input-append date" id="datetimepicker"
                                 data-date="{{ Carbon\Carbon::now() }}"
                                 data-date-format="dd-mm-yyyy hh:ii">
                                <input class="span2 form-control" name="deferred_start" size="16" type="text"
                                       value="{{ $application->deferred_start }}"
                                        {{ $application->deferred_start ? 'disabled': '' }}
                                >
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>

                        </div>
                    </div>
                </div>

                @if($is_admin)
                    <div class="form-item row">
                        <div class="form-item_header">
                            <i class="icons8-user"></i>
                            <h2>@lang('labels.user')</h2>
                        </div>
                        <div class="form-item_body col-lg-8">
                            <div class="row">
                                <select class="form-control" name="user_id" id="user_id" data-width="100%"
                                        title="@lang('labels.user')">
                                    @foreach($users as $id => $email)
                                        <option value="{{ $id }}"
                                                {{ $application->user_id === $id ? 'selected' : '' }}
                                        >{{ $email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-item row">
                        <div class="form-item_header">
                            <i class="icons8-dollar"></i>
                            <h2>@lang('labels.pay_from_manager_balance')</h2>
                            <div class="switch-status">
                            <label class="switch" title="@lang('labels.pay_from_manager_balance')">
                                <input type="checkbox" name="pay_manager" value="1" class="switch"/>
                                <span class="slider round"></span>
                            </label>
                                </div>
                        </div>
                    </div>
                @endif

                {{--Activate clickcs--}}
                <div class="form-item row @if($is_manager && $application->limit < 1000) hidden @endif">
                    <div class="form-item_header">
                        <i class="icons8-tap"></i>
                        <h2>@lang('labels.activate_clicks')</h2>
                        <div class="switch-status">
                        <label class="switch" title="@lang('labels.activate_clicks')">
                            <input type="checkbox" name="clicks" value="1" class="switch"
                                    {{ $application->clicks ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>
                     </div>
                        <p style="{{ $application->clicks ? 'display: inline-block;' : 'display: none;' }} vertical-align: top; margin-top: 7px; margin-left: 4px"
                           id="description_price_label">
                            + {{ $settings['click_price'] . ' ' . $currency }}
                        </p>
                    </div>
                </div>

                @if($is_admin)
                  <!--   <div class="form-item row">
                        <div class="form-item_header">
                            <i class="icons8-tap"></i>
                            <h2>appdoor.xyz</h2>
                            <label class="switch" title="lang('labels.activate_clicks')">
                                <input type="checkbox" name="appdoor" value="1" class="switch"
                                        {{ $application->appdoor ? 'checked' : '' }}/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-item row">
                        <div class="form-item_header">
                            <i class="icons8-tap"></i>
                            <h2>newdoor.xyz</h2>
                            <label class="switch" title="@lang('labels.activate_clicks')">
                                <input type="checkbox" name="newdoor" value="1" class="switch"
                                        {{ $application->newdoor ? 'checked' : '' }}/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-item row">
                        <div class="form-item_header">
                            <i class="icons8-tap"></i>
                            <h2>Bitcoin</h2>
                            <label class="switch" title="@lang('labels.activate_clicks')">
                                <input type="checkbox" name="bitcoin" value="1" class="switch"
                                        {{ $application->bitcoin ? 'checked' : '' }}/>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div> -->


                @endif
                <div class="form-item row">
                    <div class="form-item_header">
                    <div class="option-icon campaign_amount"></div>
                        <h2>@lang('labels.campaign_amount')</h2>
                    </div>
                    <div class="form-item_body col-lg-8">
                        <div class="row mb20">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="amount"
                                           value="{{ number_format($application->amount_for_user, 2, '.', '') }}"
                                           title="Price" step="0.01" required readonly/>
                                    <span class="input-group-addon">{{ $currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::hidden('custom_price', $application->custom_price, ['id' => 'custom_price']) !!}
                {!! Form::hidden('surcharge', 0, ['id' => 'surcharge']) !!}
                @if($can_be_changed)
                    <div class="form-item row">
                        <div class="form-item_body col-lg-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <input type="submit" id="form-submit" class="button bordered"
                                           value="@lang('labels.save')"/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($application->canBeCancelled())
                    <hr/>
                    <div class="form-item row">
                        <div class="form-item_body col-lg-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <input type="button" class="button bordered btn-danger btn-cancel-task"
                                           data-id="{{ $application->id }}"
                                           data-amount="{{ $application->amount_for_user - $application->amount_wasted }}"
                                           value="@lang('labels.cancel_task')"/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    @endif

    @include('apps._surchargeModal')
@endsection

@push('scripts')
    <script>
        const application = @json($application);
        const settings = @json($settings);
        const prices = @json($prices);
                @if(!empty($application->user))
        const application_owner_admin = "{{ $application->user->role === 1 ? 'true' : 'false' }}";
                @else
        const application_owner_admin = "true";
                @endif
        const is_manager = Boolean("{{ $is_manager }}");

        const selected_currency = "{{ $selected_currency }}";


        var init = function () {
            const cur = "{{ $currency }}";
            const user_type = "{{ $user_type }}";
            const is_manager = Boolean("{{ $is_manager }}");
            var country_group = $('#country_group').val();
            var task_24h = $('.days-range-wrapper').hasClass('h24');
            var task_48h = $('.days-range-wrapper').hasClass('h48');
            var task_72h = $('.days-range-wrapper').hasClass('h72');
            var description_price = settings.description_price;
            var description_active = application.description_active;
            var clicks_price = settings.click_price;
            var clicks_active = application.clicks;
            var top_price = settings.top_price;
            var top_active = application.top;
            var keywords = $('#keywords');
            var review_keywords = $('#review_keywords');
            var run_after = $('#run_after');
            var tracking_service = $('select[name=tracking_service]');
            keywords.select2({tags: true, selectOnClose: true});
            review_keywords.select2({tags: true, selectOnClose: true});
            tracking_service.select2();
            var days_select = $('select#days');

            if (days_select.length) {
                days_select.select2();
            }

            $('#time_delay').select2({minimumResultsForSearch: Infinity});
            $('#duration').select2({minimumResultsForSearch: Infinity});

            $('#limit_range').bind('change input', function () {
                var value = parseInt($(this).val());
                $('#limit').val(value);
                $('#limit').trigger('change');
                $('#limit_range').val(value);
                setAmount();
                if (application.paid) {
                    processSurchargeChange();
                }
            });

            $('#country_group').change(function () {
                country_group = $(this).val();
            });

            run_after.change(function () {
                setAmount();
            });

            checkReviewsStatus();
            setAmount();

            $('#limit').bind('keyup mouseup change', function () {
                var value = $(this).val();
                $('#limit').val(value);
                $('#limit_range').val(value);

                var review_rates_value = $('#review_percent_rates_range').val();
                $('#review_percent_rates_range').prop('max', value);
                if (review_rates_value > value) {
                    $('#review_percent_rates_range').val(value);
                }
                $('#review_percent_rates_range').trigger('change');

                // If limit range > 1000 and user = manager
                // show "active click" block
                if (value >= 1000 && is_manager) {
                    $('input[name="clicks"]').closest('.form-item').removeClass('hidden');
                }
                if (value < 1000 && is_manager) {
                    $('input[name="clicks"]').closest('.form-item').addClass('hidden');
                    $('input[name="clicks"]').prop('checked', false);
                    clicks_active = false;
                }

                setAmount();
                if (application.paid) {
                    processSurchargeChange();
                }

                //Temporary

                application.custom_price = false;
                renderTimeDelay();
                setAmount();
                const prefix = 'android_';
                const delay = getDelay();
                const duration = String($('#duration').val()) + 's';
                var priceLabels = $('.price_labels');

                //TODO price for duration
                var price_duration = parseFloat(prices[prefix + duration + '_price_' + user_type]).toFixed(2);

                var price_first = Number(parseFloat(prices[prefix + delay + '_price_first_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_second = Number(parseFloat(prices[prefix + delay + '_price_second_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_third = Number(parseFloat(prices[prefix + delay + '_price_third_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_fourth = Number(parseFloat(prices[prefix + delay + '_price_fourth_' + user_type]).toFixed(2)) + Number(price_duration);


                if (selected_currency === 'Ukraine') {
                    price_first = (price_first / settings.exchange_rate_rub_uah).toFixed(2);
                    price_second = (price_second / settings.exchange_rate_rub_uah).toFixed(2);
                    price_third = (price_third / settings.exchange_rate_rub_uah).toFixed(2);
                    price_fourth = (price_fourth / settings.exchange_rate_rub_uah).toFixed(2);
                }
                /*
                 * FIX ISSUE WITH ONLY RUB VALUE
                 */
                priceLabels.find('#first').html(price_first + ' ' + cur);
                priceLabels.find('#second').html(price_second + ' ' + cur);
                priceLabels.find('#third').html(price_third + ' ' + cur);
                priceLabels.find('#fourth').html(price_fourth + ' ' + cur);

                renderTimeDelay();
            });

            $('#days').bind('input', function () {
                //Manager cannot set days < current days setted (application.days)
                if (is_manager && $(this).val() < application.days)
                    $(this).val(application.days);

                //if user click days range - disable custom price
                application.custom_price = false;
                $('#custom_price').val(false);

                setAmount();
                setDaysTooltip();
                checkReviewsStatus();
            });

            $('body').on('change', '#duration', function() {

                application.custom_price = false;
                renderTimeDelay();
                setAmount();
                const prefix = 'android_';
                const delay = getDelay();
                const duration = String($('#duration').val()) + 's';
                var priceLabels = $('.price_labels');

                //TODO price for duration
                var price_duration = parseFloat(prices[prefix + duration + '_price_' + user_type]).toFixed(2);

                var price_first = Number(parseFloat(prices[prefix + delay + '_price_first_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_second = Number(parseFloat(prices[prefix + delay + '_price_second_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_third = Number(parseFloat(prices[prefix + delay + '_price_third_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_fourth = Number(parseFloat(prices[prefix + delay + '_price_fourth_' + user_type]).toFixed(2)) + Number(price_duration);

                if (selected_currency === 'Ukraine') {
                    price_first = (price_first / settings.exchange_rate_rub_uah).toFixed(2);
                    price_second = (price_second / settings.exchange_rate_rub_uah).toFixed(2);
                    price_third = (price_third / settings.exchange_rate_rub_uah).toFixed(2);
                    price_fourth = (price_fourth / settings.exchange_rate_rub_uah).toFixed(2);
                }
                /*
                 * FIX ISSUE WITH ONLY RUB VALUE
                 */
                priceLabels.find('#first').html(price_first + ' ' + cur);
                priceLabels.find('#second').html(price_second + ' ' + cur);
                priceLabels.find('#third').html(price_third + ' ' + cur);
                priceLabels.find('#fourth').html(price_fourth + ' ' + cur);

                renderTimeDelay();
            });

            $('#time_delay').bind('change', function () {
                application.custom_price = false;
                renderTimeDelay();
                setAmount();
                const prefix = 'android_';
                const delay = getDelay();
                const duration = String($('#duration').val()) + 's';
                var priceLabels = $('.price_labels');

                //TODO price for duration
                var price_duration = parseFloat(prices[prefix + duration + '_price_' + user_type]).toFixed(2);

                var price_first = Number(parseFloat(prices[prefix + delay + '_price_first_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_second = Number(parseFloat(prices[prefix + delay + '_price_second_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_third = Number(parseFloat(prices[prefix + delay + '_price_third_' + user_type]).toFixed(2)) + Number(price_duration);
                var price_fourth = Number(parseFloat(prices[prefix + delay + '_price_fourth_' + user_type]).toFixed(2)) + Number(price_duration);

                if (selected_currency === 'Ukraine') {
                    price_first = (price_first / settings.exchange_rate_rub_uah).toFixed(2);
                    price_second = (price_second / settings.exchange_rate_rub_uah).toFixed(2);
                    price_third = (price_third / settings.exchange_rate_rub_uah).toFixed(2);
                    price_fourth = (price_fourth / settings.exchange_rate_rub_uah).toFixed(2);
                }
                /*
                 * FIX ISSUE WITH ONLY RUB VALUE
                 */
                priceLabels.find('#first').html(price_first + ' ' + cur);
                priceLabels.find('#second').html(price_second + ' ' + cur);
                priceLabels.find('#third').html(price_third + ' ' + cur);
                priceLabels.find('#fourth').html(price_fourth + ' ' + cur);

                renderTimeDelay();
            });

            $(document).ready(function () {
                setTimeout(setDaysTooltip, 250);

                var min_tasks_limit_active = $('#min_tasks_limit_active');
                var min_tasks_limit_count = $('.min_tasks_limit_count');

                if (min_tasks_limit_active.prop('checked')) {
                    min_tasks_limit_count.removeClass('hidden');
                } else {
                    min_tasks_limit_count.addClass('hidden');
                }

                min_tasks_limit_active.change(function () {
                    var value = $(this).prop('checked');
                    if (value) {
                        min_tasks_limit_count.removeClass('hidden');
                    } else {
                        min_tasks_limit_count.addClass('hidden');
                    }
                });

                var tracking_service_checkbox = $('input[name=tracking_service]');
                var tracking_service = $('.tracking_service_body');
                var tracking_link_input = $('input[name=tracking_link]');
                tracking_service_checkbox.change(function () {
                    var value = $(this).prop('checked');
                    if (value) {
                        tracking_service.removeClass('hidden');
                        tracking_link_input.prop('disabled', false);
                    } else {
                        tracking_service.addClass('hidden');
                        tracking_link_input.prop('disabled', true);
                    }
                });

                var description_active_checkbox = $('input[name=description_active]');
                var description_body = $('.description_body');
                var description_price_label = $('#description_price_label');
                description_active_checkbox.change(function () {
                    var value = $(this).prop('checked');
                    if (value) {
                        description_body.removeClass('hidden');
                        description_price_label.css('display', 'inline-block');
                        description_active = true;
                    } else {
                        description_body.addClass('hidden');
                        description_price_label.css('display', 'none');
                        description_active = false;
                    }
                    setAmount();
                });

                var top_checkbox = $('input[name=top]');
                var top_price_label = $('#top_price_label');
                top_checkbox.change(function () {
                    var value = $(this).prop('checked');
                    if (value) {
                        top_price_label.css('display', 'inline-block');
                        top_active = true;
                    } else {
                        top_price_label.css('display', 'none');
                        top_active = false;
                    }
                    setAmount();
                });

                $('input[name="clicks"]').change(function () {
                    checked = $(this).prop('checked');
                    pTag = $(this).closest('.form-item_header').find('p');

                    if (checked) {
                        clicks_active = true;
                        pTag.css('display', 'inline-block');
                    }
                    else {
                        pTag.css('display', 'none');
                        clicks_active = false;
                    }

                    setAmount();
                })
            });

            $('#collapse-navbar').click(function () {
                setTimeout(setDaysTooltip, 250);
            });

            var review_stars = $('#review_stars');
            var review_stars_range = $('#review_stars_range');
            review_stars.bind('keyup mouseup change', function () {
                review_stars_range.val($(this).val());
            });
            review_stars_range.bind('change input', function () {
                review_stars.val($(this).val());
            });

            $('#price').bind('change', function () {
                $('#custom_price').val(true);
                application.custom_price = true;
                setAmount();
            });

            $('input[name=promotion_type][value="2"]').bind('change', function () {
                const checked = $(this).prop('checked');
                if (country_group !== 'cis') {
                    let value = prices['other_price'];
                    if (checked) {
                        value = prices['other_price_keywords'];
                    }
                    $('#price').val(value.toFixed(2));
                }
                setAmount();
            });

            function setAmount() {
                const prefix = 'android_';
                const delay = getDelay();
                var days = $('#days').val();
                const duration = String($('#duration').val()) + 's';

                var priceManager = 0;
                var priceUser = 0;
 
                var price_duration_manager = parseFloat(prices[prefix + duration + '_price_manager']).toFixed(2);
                var price_duration_user = parseFloat(prices[prefix + duration + '_price_user']).toFixed(2);

                var price_install_manager = parseFloat(prices[prefix + 'install' + '_price_manager']).toFixed(2);
                var price_install_user = parseFloat(prices[prefix + 'install' + '_price_user']).toFixed(2);

                const keywords_active = $('input[name=promotion_type][value="2"]').prop('checked');
                const run_after = $('input[name=run_after][value="1"]').prop('checked');
                if (country_group !== 'cis') {
                    priceUser = parseFloat(prices['other_price']);
                    priceManager = parseFloat(prices['other_price']);
                    if (keywords_active) {
                        priceManager = prices['other_price_keywords'];
                        priceUser = prices['other_price_keywords'];
                    } else {
                        priceManager = prices['other_price'];
                        priceUser = prices['other_price'];
                    }
                    $('input[name="price"]').val(priceUser  || 0);
                    $('input[name="price_for_user"]').val(priceManager || 0);

                } else {
                    if (application.custom_price) {
                        priceUser = parseFloat($('#price').val()).toFixed(2);
                        priceManager = priceUser;
                        $('input[name="price"]').val(priceUser  || 0);
                        $('input[name="price_for_user"]').val(priceManager || 0);
                    } else {
                        if (task_48h) {
                            if (days >= 2 && days <= 10) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_first_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_first_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 11 && days <= 20) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_second_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_second_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 21 && days <= 30) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_third_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_third_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 31 && days <= 50) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_fourth_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_fourth_user']).toFixed(2)) + Number(price_duration_user);
                            }
                        } else {
                            if (days >= 1 && days <= 6) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_first_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_first_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 7 && days <= 14) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_second_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_second_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 15 && days <= 29) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_third_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_third_user']).toFixed(2)) + Number(price_duration_user);
                            } else if (days >= 30 && days <= 50) {
                                priceManager = Number(parseFloat(prices[prefix + delay + '_price_fourth_manager']).toFixed(2)) + Number(price_duration_manager);
                                priceUser = Number(parseFloat(prices[prefix + delay + '_price_fourth_user']).toFixed(2)) + Number(price_duration_user);
                            }
                        }

                        if (top_active) {
                            priceManager += top_price;
                        }

                        $('input[name="price"]').val(priceUser  || 0);
                        $('input[name="price_for_user"]').val(priceManager || 0);
                    }
                }

                if (selected_currency === 'Ukraine' && application.custom_price == false) {
                    priceManager = (priceManager / settings.exchange_rate_rub_uah).toFixed(2);
                    priceUser = (priceUser / settings.exchange_rate_rub_uah).toFixed(2);
                }

                let time_delay = parseInt($('#time_delay').val()) / 24; // Seconds to full day
                if (parseInt($('#time_delay').val()) === 73) {
                    priceUser = parseFloat($('#price').val()).toFixed(2);
                    time_delay = 3;

                    if (run_after) {
                        priceUser = parseFloat(priceUser) + parseFloat(settings.run_after_price);
                    }

                    priceManager = priceUser;

                    $('input[name="price"]').val(priceUser  || 0);
                    $('input[name="price_for_user"]').val(priceManager || 0);
                }
                days = Math.ceil(days / time_delay);

                checkReviewsStatus();

                if (country_group == 'cis' && !(parseInt($('#time_delay').val()) === 73)) {
                    var expectedPriceManager = parseFloat(priceManager * days + parseFloat(price_install_manager)).toFixed(2);
                    var expectedPriceUser = parseFloat(priceUser * days + parseFloat(price_install_user)).toFixed(2);
                } else {
                    var expectedPriceManager = parseFloat(priceManager * days).toFixed(2);
                    var expectedPriceUser = parseFloat(priceUser * days).toFixed(2);
                }

                $('input[name="install_price_for_user"]').val(price_install_manager || 0);
                $('input[name="install_price"]').val(price_install_user || 0);
                $('input[name="expected_price_for_user"]').val(expectedPriceManager);
                $('input[name="expected_price"]').val(expectedPriceUser);

                var review_rates = parseInt($('input[name=review_rates]').val());
                var comment_rates = parseInt($('input[name=review_comments]').val());

                var users_limit = $('input[name="limit"]').val();

                //var amount = 0;

                if (country_group === 'cis') {
                    amount = users_limit * expectedPriceManager;
                    if (parseInt($('#time_delay').val()) !== 73) {
                        //amount += (review_rates * settings.review_price) + (comment_rates * settings.review_comment_price);
                    }
                    if (description_active) {
                        amount += users_limit * description_price;
                    }

                } else {
                    if (keywords_active) {
                        amount = users_limit * prices['other_price_keywords'];
                    } else {
                        amount = users_limit * prices['other_price'];
                    }
                }

                $('input[name="amount"]').val(amount.toFixed(2));

                //set daily budget
                setDailyInstalls();

                //set hourly budget
                setHourlyInstalls();


                if (application.paid) {
                    processSurchargeChange();
                }
                $('.panel-buttons_payment').slideUp(200);
            }

            //Daily install recalc and set value
            function setDailyInstalls() {
                daily_install_range = $('#daily_budget_installs_limit_range');
                daily_install_amount = $('#daily_budget_amount');
                daily_install_number_field = $('#daily_budget_installs_limit');

                current_amount = $('input[name="amount"]').val();

                max_range = +$('#limit_range').val();
                min_range = +Math.round($('#limit_range').val() / +$('#days').val());

                //Set max value
                if (+daily_install_range.attr('max') > max_range || +daily_install_range.attr('max') < max_range) {
                    daily_install_range.attr('max', max_range);

                    if (+daily_install_number_field.val() !== +daily_install_range.val())
                        daily_install_number_field.val(+daily_install_range.val());

                }

                //Set min value
                if (+daily_install_range.attr('min') < min_range || +daily_install_range.attr('min') > min_range) {
                    daily_install_range.attr('min', min_range);

                    if (+daily_install_number_field.val() !== +daily_install_range.val())
                        daily_install_number_field.val(+daily_install_range.val());

                }

                daily_install_amount.val((current_amount / max_range * +daily_install_range.val()).toFixed(2));
            }

            //Daily install events
            $('#daily_budget_installs_limit_range').bind('input keyup keydown', function () {
                $('#daily_budget_installs_limit').val($(this).val());
                setDailyInstalls();

            });

            $('#daily_budget_installs_limit').bind('input keyup keydown', function () {
                $('#daily_budget_installs_limit_range').val($(this).val());
                setDailyInstalls();
            });

            function setHourlyInstalls() {
                hourly_install_range = $('#hourly_budget_installs_limit_range');
                hourly_install_amount = $('#hourly_budget_amount');
                hourly_install_number_field = $('#hourly_budget_installs_limit');

                current_amount = $('input[name="amount"]').val();

                max_range = +$('#limit_range').val();
                min_range = +Math.round($('#limit_range').val() / +$('#days').val());

                //Set max value
                if (+hourly_install_range.attr('max') > max_range || +hourly_install_range.attr('max') < max_range) {
                    hourly_install_range.attr('max', max_range);

                    if (+hourly_install_number_field.val() !== +hourly_install_range.val())
                        hourly_install_number_field.val(+hourly_install_range.val());

                }

                //Set min value
                if (+hourly_install_range.attr('min') < min_range || +hourly_install_range.attr('min') > min_range) {
                    hourly_install_range.attr('min', min_range);

                    if (+hourly_install_number_field.val() !== +hourly_install_range.val())
                        hourly_install_number_field.val(+hourly_install_range.val());

                }

                hourly_install_amount.val((current_amount / max_range * +hourly_install_range.val()).toFixed(2));
            }

            //Hourly install events
            $('#hourly_budget_installs_limit_range').bind('input keyup keydown', function () {
                $('#hourly_budget_installs_limit').val($(this).val());
                setHourlyInstalls();

            });

            $('#hourly_budget_installs_limit').bind('input keyup keydown', function () {
                $('#hourly_budget_installs_limit_range').val($(this).val());
                setHourlyInstalls();
            });

            function setDaysTooltip() {
                var self = $('#days');

                var value = parseInt(self.val());

                // Measure width of range input
                var width = self.width();

                // Figure out placement percentage between left and right of input
                var newPoint = (self.val() - self.attr('min')) / (self.attr('max') - self.attr('min'));

                var offset = -1;
                var newPlace = 0;

                var window_width = document.body.clientWidth;
                // Prevent bubble from going beyond left or right (unsupported browsers)
                if (newPoint < 0) {
                    newPlace = 0;
                } else if (newPoint > 1) {
                    newPlace = width;
                    if (window_width <= 1440) {
                        offset = -6.5;
                    }
                } else if (newPoint > 0.8) {
                    newPlace = width * newPoint;
                    offset = -3.3;
                    if (window_width <= 1440) {
                        offset = -5;
                    }
                } else if (newPoint > 0.5) {
                    newPlace = width * newPoint;
                    offset = -2.5;
                    if (window_width <= 1440) {
                        offset = -3.5;
                    }
                } else {
                    newPlace = width * newPoint + offset;
                    offset -= newPoint;
                }

                // Move bubble
                self
                    .next('output')
                    .css({
                        left: newPlace,
                        marginLeft: offset + '%'
                    })
                    .text(self.val());

                if (task_48h) {
                    if (value && (value === 6 || value === 10 || value === 20 || value === 30 || value === 50)) {
                        $('output').css('opacity', 0);
                    } else if (value) {
                        $('output').css('opacity', 1);
                    }
                }
                else if (task_24h) {
                    if (value && (value === 1 || value === 3 || value === 7 || value === 15 || value === 30 || value === 50)) {
                        $('output').css('opacity', 0);
                    } else if (value) {
                        $('output').css('opacity', 1);
                    }
                }
                else if (task_72h) {
                    if (value && (value === 3 || value === 7 || value === 15 || value === 30 || value === 50)) {
                        $('output').css('opacity', 0);
                    } else if (value) {
                        $('output').css('opacity', 1);
                    }
                }
            }

            function getDelay() {
                const time_delay = parseInt($('#time_delay').val());
                var delay = '24h';
                switch (time_delay) {
                    case 24:
                        delay = '24h';
                        break;
                    case 48:
                        delay = '48h';
                        break;
                    case 72:
                        delay = '72h';
                        break;
                    case 72 + 1:
                        delay = '72h';
                        break;
                }
                return delay;
            }

            function renderTimeDelay() {
                var delay = getDelay();

                if (delay === '24h') {
                    $('.days-range-wrapper').removeClass('h48');
                    $('.days-range-wrapper').removeClass('h72');
                    $('.days-range-wrapper').addClass('h24');
                    task_48h = false;
                    $('#days').attr('min', 1);
                    $('#days').attr('max', 50);
                    $('#days').attr('step', 1);

                    $('#range_first').text(1);
                    $('#range_second').text(7);
                    $('#range_third').text(15);
                    $('#range_fourth').text(30);
                    $('#range_fifth').text(50);
                }

                if (delay === '48h') {
                    $('.days-range-wrapper').removeClass('h24');
                    $('.days-range-wrapper').removeClass('h72');
                    $('.days-range-wrapper').addClass('h48');
                    task_48h = true;
                    $('#days').attr('min', 2);
                    $('#days').attr('step', 2);
                    $('#days').val(application.days % 2 == 0 && application.days >= 6 ? application.days : 6);

                    $('#range_first').text(6);
                    $('#range_second').text(10);
                    $('#range_third').text(20);
                    $('#range_fourth').text(30);
                    $('#range_fifth').text(50);
                }

                if (delay === '72h') {
                    task_48h = false;
                    $('.days-range-wrapper').removeClass('h48');
                    $('.days-range-wrapper').removeClass('h24');
                    $('.days-range-wrapper').addClass('h72');

                    $('#days').attr('min', 3);
                    $('#days').attr('step', 1);

                    $('#range_first').text(3);
                    $('#range_second').text(7);
                    $('#range_third').text(15);
                    $('#range_fourth').text(30);
                    $('#range_fifth').text(50);
                }

                setDaysTooltip();
            }

            // Review task
            var review_percent_rates_range = $('#review_percent_rates_range');
            var review_percent_rates = $('#review_percent_rates');
            var rates_label = $('input[name=review_rates]');
            var comments_percent_range = $('#review_percent_comments_range');
            var comment_percent = $('#review_percent_comments');
            var comments_label = $('input[name=review_comments]');

            review_percent_rates_range.bind('change input', function () {
                var users = $('input[name=limit]').val();
                var value = $(this).val();
                var percents = Math.round(value / users * 100);
                comments_percent_range = $('#review_percent_comments_range');
                review_percent_rates.val(percents);
                comments_percent_range.prop('max', value);
                if (percents <= parseInt(comments_percent_range.val())) {
                    comments_percent_range.val(value);
                    comments_percent_range.trigger('change');
                }
                rates_label.val(value);
                setAmount();
            });

            review_percent_rates.bind('keyup mouseup change', function () {
                var users = $('input[name=limit]').val();
                var value = $(this).val();
                var percents = Math.round(value / users * 100);
                comments_percent_range = $('#review_percent_comments_range');
                review_percent_rates_range.val(percents);
                comments_percent_range.prop('max', percents);
                rates_label.val(Math.round(users / 100 * value));
                setAmount();
            });

            rates_label.bind('keyup mouseup change', function () {
                var users = $('input[name=limit]').val();
                var value = $(this).val();
                var percents = value / users * 100;
                review_percent_rates_range.val(percents);
                review_percent_rates.val(percents);
                setAmount();
            });

            comments_percent_range.bind('change input', function () {
                var users = $('input[name=limit]').val();
                var value = $(this).val();
                var percent_value = Math.round(value / users * 100);
                comment_percent.val(percent_value);
                comments_label.val(value);
                setAmount();
            });

            comment_percent.bind('keyup mouseup change', function () {
                var users = $('input[name=limit]').val();
                var value = $(this).val();
                comments_percent_range = $('#review_percent_comments_range');
                comments_percent_range.val(value);
                comments_label.val(Math.round(users / 100 * value));
                setAmount();
            });

            comments_label.bind('keyup mouseup change', function () {
                var value = $(this).val();
                var percents = Math.round(value / rates_label.val() * 100);
                comments_percent_range.val(percents);
                comment_percent.val(percents);
                setAmount();
            });

            $('input[name=promotion_type]').change(function () {
                var val = parseInt($(this).val());
                var checked = $(this).prop('checked');
                if (val === 2) { // Keywords promotion type id
                    $('#keywords').prop('disabled', !checked);
                }
            });

            $('.range_count').click(function () {
                $('#days').val(+this.innerHTML);
                setDaysTooltip();
            });


            $('select[name=tracking_service]').change(function () {
                if ($(this).val() == 'null') {
                    $('input[name=tracking_link]').prop('disabled', true);
                } else {
                    $('input[name=tracking_link]').prop('disabled', false);
                }
            });

            dailyBudgetCheck();
            hourlyBudgetCheck();

            $('input[name=daily_budget]').bind('change', () => {
                dailyBudgetCheck();
            });

            $('input[name=hourly_budget]').bind('change', () => {
                hourlyBudgetCheck();
            });

            var expected_price_for_user = $('#expected_price_for_user');


            if (!expected_price_for_user.val()) {
                expected_price_for_user = $('#price');
            }


            $('#form-submit').click(function (event) {
                setAmount();
                var surcharge = parseFloat($('input[name=surcharge]').val());

                // If surcharge exists and application owner is not admin and current editor is manager
                if (surcharge > 0 && application_owner_admin == 'false' && is_manager) {
                    event.preventDefault();

                    var modal = $('#surchargeModal');
                    $('#surcharge_amount').html(surcharge.toFixed(2));
                    $('input[name=ik_am]').val(surcharge.toFixed(2));
                    $('input[name=ik_x_app_id]').val(application.id);
                    $('input[name=ik_x_app]').val($('form[name=app_form]').serialize());
                    modal.modal('show');
                }
            });

            reviewsCheck();

            $('input[name=review]').bind('change', () => {
                reviewsCheck();
            });

            $('.submit-surcharge-balance').click(() => {
                $('form[name=app_form]').submit();
            });
        }

        function processSurchargeChange() {
            //Show surcharge modal only if app paid and manager want to increase some options.
            // var difference = application.paid && is_manager ? calculateSurchargeDifference() : 0;
            var difference = application.paid ? calculateSurchargeDifference() : 0;
            if (difference !== 0) {
                $('#surcharge').val(difference.toFixed(2));
            }
            else {
                $('#surcharge').val(0);
                // if (is_manager)
                // $('input[name=amount]').val(application.amount_for_user.toFixed(2));
            }

            sessionStorage.setItem('app', JSON.stringify({
                app_id: application.id,
                surcharge: difference
            }));
        }

        // When application paid - user can change params and pay in addition
        function calculateSurchargeDifference() {
            var current_amount = application.amount_for_user;
            var amount_with_surcharge = parseFloat($('input[name=amount]').val());

            return amount_with_surcharge - current_amount;
        }

        // Review task available only after 3 run (but if not less than 3 runs in total)
        function checkReviewsStatus() {
            var time_delay = parseInt($('#time_delay').val()) / 24; // Seconds to full day
            var days = parseInt($('#days').val());
            var times = Math.ceil(days / time_delay);

            //Enable review switch if app runs more then 2 times
            if (times > 2) {
                $('input[name=review]').prop('disabled', false);
            } else {
                $('input[name=review]').prop('checked', false);
                $('.reviews_wrapper').slideUp();
                $('input[name=review]').prop('disabled', true);
                $('input[name=review]').parent().attr('title', "{{ trans('labels.reviews_locked_tip') }}");
            }
        }

        function dailyBudgetCheck() {
            let checkbox = $('input[name=daily_budget]');
            let wrapper = $('.daily_budget_wrapper');

            if (checkbox.prop('checked')) {
                wrapper.slideDown(250);
            } else {
                wrapper.slideUp(250);
            }
        }

        function hourlyBudgetCheck() {
            let checkbox = $('input[name=hourly_budget]');
            let wrapper = $('.hourly_budget_wrapper');

            if (checkbox.prop('checked')) {
                wrapper.slideDown(250);
            } else {
                wrapper.slideUp(250);
            }
        }

        function reviewsCheck() {
            let checkbox = $('input[name=review]');
            let wrapper = $('.reviews_wrapper');

            if (checkbox.prop('checked')) {
                wrapper.slideDown(250);
            } else {
                wrapper.slideUp(250);
            }
        }


        init();

        var customParamsWrapper = document.querySelector('.custom-params-wrapper');
        if (customParamsWrapper) {
            var observer = new MutationObserver(function () {
                init();
                processSurchargeChange();
            });
            observer.observe(customParamsWrapper, {childList: true});
        }

    </script>
@endpush