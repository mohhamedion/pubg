<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon users"></div>
        <h2>@lang('labels.users_count')</h2>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            @php
                $min_installs = $settings['application_downloads_min_limit'];
                if (!$is_admin && $application->paid) { $min_installs = $application->limit; }
            @endphp
            <input type="range"
                   max="100000" step="1"
                   value="{{ $application->limit > 0 ? $application->limit : $settings['application_downloads_min_limit'] }}"
                   id="limit_range"
                   title="@lang('labels.users_count')"
                   min="{{ $settings['application_downloads_min_limit'] }}"
                   @if(!$can_be_changed) disabled @endif/>
        </div>
        <div class="row">
            <div class="form-group form-group-info">
                <label class="control-label col-md-5 col-lg-5" for="limit">
                    @lang('labels.users_count_descr')
                </label>
                <div class="col-md-3">
                    <input type="number" step="1"
                           value="{{ $application->limit > 0 ? $application->limit :  $settings['application_downloads_min_limit']  }}"
                           name="limit"
                           id="limit" class="form-control" required
                           min="{{  $settings['application_downloads_min_limit']  }}"
                           @if(!$can_be_changed) readonly @endif/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon taps"></div>
        <h2>@lang('labels.time_delay')</h2>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            <div class="time-delay">
                @php
                    $delays = [
                            24 => trans('labels.24_h'),
                            48 => trans('labels.48_h'),
                            72 => trans('labels.72_h'),
                            72 + 1 => trans('labels.once'),
                        ];
                @endphp
                {!! Form::select('time_delay', $delays, $application->time_delay, [
                        'id' => 'time_delay',
                        'style' => 'width: 100%',
                        'disabled' => !$can_be_changed
                        ]) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon clock"></div>
        <h2>@lang('labels.session_duration')</h2>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            <div class="duration">
                 @php
                    $durations = [
                            30 => trans('labels.30_sec'),
                            60 => trans('labels.1_min'),
                            120 => trans('labels.2_min'),
                            300 => trans('labels.5_min'),
                        ];
                @endphp
                {!! Form::select('duration', $durations, $application->duration, [
                        'id' => 'duration',
                        'style' => 'width: 40%',
                        'disabled' => !$can_be_changed
                        ]) !!}
                         
            </div>
        </div>
        
    </div>
</div>
<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon days"></div>
        <h2>@lang('labels.install-limit-days')</h2>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="days-range-wrapper h{{$application->time_delay}}">

            @include('apps._appDaysRange', compact('application', 'prices'))

            @php
                $user_prices = [
                    (float) number_format((float)($prices["{$application->device_type}_{$delay}_price_first_{$user_type}"]) + 1, 2, '.', ''),
                    (float) number_format((float)($prices["{$application->device_type}_{$delay}_price_second_{$user_type}"]) + 1, 2, '.', ''),
                    (float) number_format((float)($prices["{$application->device_type}_{$delay}_price_third_{$user_type}"]) + 1, 2, '.', ''),
                    (float) number_format((float)($prices["{$application->device_type}_{$delay}_price_fourth_{$user_type}"]) + 1, 2, '.', ''),
                ];
            @endphp

            <div class="row">
                <div class="price_labels">
                    <div id="first">
                        {{ $user_prices[0] . ' ' . $currency }}</div>
                    <div id="second">
                        {{ $user_prices[1] . ' ' . $currency }}</div>
                    <div id="third">
                        {{ $user_prices[2] . ' ' . $currency }}</div>
                    <div id="fourth">
                        {{ $user_prices[3] . ' ' . $currency }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="price">
                @lang('labels.install-price')
            </label>
            <div class="col-sm-3">
                <div class="input-group">
                    @if($is_manager)
                        <input type="number" class="form-control" id="install_price_for_user"
                               value="{{ number_format($application->install_price_for_user, 2) }}"
                               title="@lang('labels.install-price')"
                               name="install_price_for_user"
                               step="0.01" readonly required/>
                        <input type="number" name="install_price" id="install_price"
                               value="{{ number_format($application->install_price, 2, '.', '') }}"
                               title="@lang('labels.install-price')"
                               step="0.01" hidden>
                    @else
                        <input type="number" class="form-control" name="install_price" id="install_price"
                               value="{{ number_format($application->install_price, 2, '.', '') }}"
                               title="@lang('labels.install-price')"
                               step="0.01" required>
                    @endif
                    <span class="input-group-addon">{{ $currency }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3" for="price">
                    @lang('labels.run_price')
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        @if($is_manager)
                            <input type="number" class="form-control" id="price_for_user"
                                   value="{{ number_format($application->price_for_user, 2) }}"
                                   title="@lang('labels.run_price')"
                                   name="price_for_user"
                                   step="0.01" readonly required/>
                            <input type="number" name="price" id="price"
                                   value="{{ number_format($application->price, 2, '.', '') }}"
                                   title="@lang('labels.price')"
                                   step="0.01" hidden>
                        @else
                            <input type="number" class="form-control" id="price"
                                   value="{{ number_format($application->price, 2, '.', '') }}"
                                   title="@lang('labels.price')"
                                   name="price"
                                   step="0.01" required/>
                        @endif
                        <span class="input-group-addon">{{ $currency }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="price">
                @lang('labels.user_price')
            </label>
            <div class="col-sm-3">
                <div class="input-group">
                    @if($is_manager)
                        <input type="number" class="form-control" id="expected_price_for_user"
                               value="{{ number_format($application->expected_price_for_user, 2) }}"
                               name="expected_price_for_user"
                               step="0.01" title="@lang('labels.user_price')"
                               readonly required/>
                    @else
                        <input type="number" class="form-control" id="expected_price_for_user"
                               value="{{ number_format($application->user_task_price, 2) }}"
                               name="expected_price"
                               title="@lang('labels.user_price')"
                               step="0.01" required/>
                    @endif
                    <span class="input-group-addon">{{ $currency }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon search"></div>
        <h2>@lang('labels.by_keywords')</h2>
        <div class="switch-status">
        <label class="switch" title="@lang('labels.promotion_type')">
            <input type="checkbox" name="promotion_type" value="2" class="switch"
                   {{ $application->promotion_type === 2 ? 'checked' : '' }}
                   @if(!$can_be_changed) disabled @endif/>
            <span class="slider round"></span>
        </label>
            </div>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            <select name="keywords[]" class="form-control" id="keywords"
                    title="@lang('labels.search_query')" multiple
                    style="width: 100%"
                    data-placeholder="@lang('labels.search_query')"
                    @if(!$can_be_changed || $application->promotion_type !== 2) disabled @endif>
                @if($application->keywords)
                    @foreach(unserialize($application->keywords) as $keyword)
                        <option value="{{ $keyword }}" selected>{{ $keyword }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="row">
            <label class="control-label col-md-12 field-description">
                {!! trans('labels.search_query_descr') !!}
            </label>
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon tracking"></div>
        <h2>@lang('labels.tracking_link')</h2>
        <div class="switch-status">
        <label class="switch" title="@lang('labels.tracking_link')">
            <input type="checkbox" name="tracking_service" value="true" class="switch"
                   {{ $application->tracking_service ? 'checked' : '' }}
                   @if(!$can_be_changed) disabled @endif/>
            <span class="slider round"></span>
        </label>
        </div>
    </div>
    <div class="form-item_body col-lg-8 tracking_service_body{{ $application->tracking_service ? '' : ' hidden' }}">
        <div class="row">
            {!! Form::url('tracking_link',  $application->tracking_link, [
                'class' => 'form-control',
                'readonly' => !$can_be_changed,
                'disabled' => !$application->tracking_service
                ]) !!}
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon installs"></div>
        <h2>@lang('labels.daily_budget')</h2>
        <div class="switch-status">
        <label class="switch" title="@lang('labels.daily_budget')">
            <input type="checkbox" name="daily_budget" value="1" class="switch"
                   {{ $application->daily_budget ? 'checked' : '' }}
                   @if(!$can_be_changed) disabled @endif/>
            <span class="slider round"></span>
        </label>
        </div>
    </div>
    <div class="form-item_body col-lg-8 daily_budget_wrapper">
        <div class="row">
            <input type="range" min="1" step="1"
                   max="{{ $application->limit }}"
                   {{--                                      max="{{ $application->amount_for_user ---}}
                   {{--($application->price_for_user *  $application->getUsersCount()) }}"--}}
                   value="{{ $application->daily_budget_installs_limit ?? 1 }}"
                   id="daily_budget_installs_limit_range"
                   title="@lang('labels.users_count')"
                   @if(!$can_be_changed) disabled @endif/>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3" for="daily_budget_amount">
                    @lang('labels.amount')
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="daily_budget_amount"
                               value="{{ number_format($application->daily_budget_amount, 2, '.', '') or number_format($application->expected_price_for_user, 2, '.', '') }}"
                               name="daily_budget_amount"
                               title="@lang('labels.user_price')"
                               readonly/>
                        <span class="input-group-addon">{{ $currency }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="daily_budget_installs_limit">
                    @lang('labels.installs')
                </label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="daily_budget_installs_limit"
                           min="1"
                           value="{{ $application->daily_budget_installs_limit or 1 }}"
                           name="daily_budget_installs_limit"
                           @if(!$can_be_changed) readonly @endif
                           title="@lang('labels.user_price')"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
        <div class="installs"><i class="fas fa-arrow-circle-down"></i></div>
        <h2>@lang('labels.hourly_budget')</h2>
        <div class="switch-status">
            <label class="switch" title="@lang('labels.hourly_budget')">
                <input type="checkbox" name="hourly_budget" value="1" class="switch"
                       {{ $application->hourly_budget ? 'checked' : '' }}
                       @if(!$can_be_changed) disabled @endif/>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
    <div class="form-item_body col-lg-8 hourly_budget_wrapper">
        <div class="row">
            <input type="range" min="1" step="1"
                   max="{{ $application->limit }}"
                   {{--                                      max="{{ $application->amount_for_user ---}}
                   {{--($application->price_for_user *  $application->getUsersCount()) }}"--}}
                   value="{{ $application->hourly_budget_installs_limit ?? 1 }}"
                   id="hourly_budget_installs_limit_range"
                   title="@lang('labels.users_count')"
                   @if(!$can_be_changed) disabled @endif/>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3" for="hourly_budget_amount">
                    @lang('labels.amount')
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="hourly_budget_amount"
                               value="{{ number_format($application->hourly_budget_amount, 2, '.', '') or number_format($application->expected_price_for_user, 2, '.', '') }}"
                               name="hourly_budget_amount"
                               title="@lang('labels.user_price')"
                               readonly/>
                        <span class="input-group-addon">{{ $currency }}</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="hourly_budget_installs_limit">
                    @lang('labels.installs')
                </label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="hourly_budget_installs_limit"
                           min="1"
                           value="{{ $application->hourly_budget_installs_limit or 1 }}"
                           name="hourly_budget_installs_limit"
                           @if(!$can_be_changed) readonly @endif
                           title="@lang('labels.user_price')"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
        <i class="icons8-description"></i>
        <h2>@lang('labels.description')</h2>
        <div class="switch-status">
        <label class="switch" title="@lang('labels.description')">
            <input type="checkbox" name="description_active" value="1" class="switch"
                    {{ $application->description_active ? 'checked' : '' }}/>
            <span class="slider round"></span>
        </label>
        </div>
        <p style="{{ $application->description_active ? 'display: inline-block;' : 'display: none;' }} vertical-align: top; margin-top: 7px; margin-left: 4px"
           id="description_price_label">
            + {{ $settings['description_price'] . ' ' . $currency }}
        </p>
    </div>
    <div class="form-item_body col-lg-8 description_body{{ $application->description_active ? '' : ' hidden' }}">
        <div class="row">
                                <textarea class="form-control" id="body"
                                          rows="7" title="@lang('labels.description')" name="description"
                                          @if(!$can_be_changed)
                                          readonly @endif>{{ $application->description }}</textarea>
        </div>
        <div class="row">
            <label class="control-label col-md-12 field-description">
                {!! trans('labels.description_descr') !!}
            </label>
        </div>
    </div>
</div>

<div class="form-item row">
    <div class="form-item_header">
        <i class="fas fa-sort-amount-up"></i>
        <h2>@lang('labels.top')</h2>
        <div class="switch-status">
        <label class="switch" title="Top">
            <input type="checkbox" id="top" name="top" value="1" class="switch"
                    {{ $application->top ? 'checked' : '' }}/>
            <span class="slider round"></span>
        </label>
        </div>
        <p style="{{ $application->top ? 'display: inline-block;' : 'display: none;' }} vertical-align: top; margin-top: 7px; margin-left: 4px"
           id="top_price_label">
            + {{ $settings['top_price'] . ' ' . $currency }}
        </p>
    </div>
</div>


@if($is_admin)
    <div class="form-item row">
        <div class="form-item_header">
            <i class="icons8-success"></i>
            <h2>@lang('labels.tasks_limit')</h2>
            <div class="switch-status">
            <label class="switch" title="@lang('labels.promotion_type')">
                <input type="checkbox" name="min_tasks_limit_active"
                       id="min_tasks_limit_active" value="1" class="switch"
                        {{ $application->min_tasks_limit_active ? 'checked' : '' }}/>
                <span class="slider round"></span>
            </label>
            </div>
        </div>
        <div class="form-item_body col-lg-8 min_tasks_limit_count">
            <div class="row">
                <label for="min_tasks_limit" class="mb10">
                    @lang('labels.min_tasks_limit')</label>
                <input type="number" class="form-control"
                       name="min_tasks_limit" value="{{ $application->min_tasks_limit }}"
                       title="@lang('labels.min_tasks_limit')" min="0"/>
            </div>
        </div>
    </div>
@endif

<div class="form-item row">
    <div class="form-item_header">
    <div class="option-icon comments"></div>
        <h2>@lang('labels.nav.testimonials')</h2>
        <div class="switch-status">
        <label class="switch" title="@lang('labels.nav.testimonials')">
            <input type="checkbox" name="review" value="1" class="switch"
                   {{ $application->review ? 'checked' : '' }}
                   @if(!$can_be_changed) disabled @endif/>
            <span class="slider round"></span>
        </label>
        </div>
    </div>
    <div class="form-item_body col-lg-8 reviews_wrapper">
        <div class="row">
            <div class="col-lg-8">
                <input type="range" min="0" step="1" max="{{ $application->limit }}"
                       value="{{ $application->review ? round($application->review->rates / $application->limit * 100) : 0 }}"
                       id="review_percent_rates_range"
                       title="@lang('labels.users_count')"
                       @if(!$can_be_changed) disabled @endif/>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-4" for="review_percent_rates">
                    @lang('labels.percent_rates')
                </label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="number" class="form-control" id="review_percent_rates"
                               value="{{ $application->review ? round($application->review->rates / $application->limit * 100) : 0 }}"
                               name="review_percent_rates"
                               step="1" title="@lang('labels.percent_rates')"
                               @if(!$can_be_changed) readonly @endif/>
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control"
                           value="{{ $application->review ? $application->review->rates : 0}}"
                           name="review_rates" title="@lang('labels.users_count')"
                           step="1" title="@lang('labels.percent_rates')"
                           @if(!$can_be_changed) readonly @endif/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <input type="range" min="0" step="1"
                       max="{{ $application->review ? round($application->review->rates / $application->limit * 100) : $application->limit }}"
                       value="{{ $application->review ? round($application->review->comments / $application->limit * 100) : 0 }}"
                       id="review_percent_comments_range"
                       title="@lang('labels.users_count')"
                       @if(!$can_be_changed) disabled @endif/>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-4" for="review_percent_comments">
                    @lang('labels.percent_comments')
                </label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="number" class="form-control" id="review_percent_comments"
                               value="{{ $application->review ? round($application->review->comments / $application->limit * 100) : 0 }}"
                               name="review_percent_comments" min="0" step="1"
                               title="@lang('labels.percent_comments')"
                               @if(!$can_be_changed) readonly @endif/>
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control"
                           value="{{ $application->review ? $application->review->comments : 0 }}"
                           name="review_comments" min="0" step="1"
                           title="@lang('labels.users_count')"
                           @if(!$can_be_changed) readonly @endif/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-4" for="review_keywords">
                    @lang('labels.review_keywords')
                </label>
                <div class="col-sm-4">
                    <select name="review_keywords[]" class="form-control" id="review_keywords"
                            title="@lang('labels.review_keywords')" multiple
                            style="width: 100%"
                            data-placeholder="@lang('labels.review_keywords')"
                            @if(!$can_be_changed) disabled @endif>
                        @if($application->review && $application->review->keywords)
                            @foreach(unserialize($application->review->keywords) as $keyword)
                                <option value="{{ $keyword }}" selected>{{ $keyword }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3" for="review_stars">
                    @lang('labels.review_stars')
                </label>
                <div class="col-sm-2">
                    <input type="number" name="review_stars" id="review_stars"
                           class="form-control" min="1" step="1" max="5" value="5"
                           value="{{ optional($application->review)->stars }}"/>
                </div>
                <div class="col-sm-4">
                    <input type="range" min="1" step="1" max="5" value="5"
                           value="{{ optional($application->review)->stars }}"
                           id="review_stars_range" title="@lang('labels.review_stars')"
                           @if(!$can_be_changed) disabled @endif/>
                </div>
            </div>
        </div>
    </div>
</div>
