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
                {!! Form::select('time_delay', $delays, 72 + 1, [
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
    <div class="option-icon days"></div>
        <h2>@lang('labels.run-days', ['days' => 3])</h2>
        <label class="switch" title="@lang('labels.run-days', ['days' => 3])">
            <input id="run_after" type="checkbox" type="checkbox" name="run_after" value="1" class="switch"
                   {{ $application->run_after === 1 ? 'checked' : '' }}
            @if(!$can_be_changed) disabled @endif/>
            <span class="slider round"></span>
        </label>
        <input type="text" name="days" id="days" value="3" hidden/>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-3" for="price">
                    @lang('labels.user_price')
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        @php
                            /*$price = $application->promotion_type === 2
                            ? number_format($prices->other_type_price_keywords, 2)
                            : number_format($prices->other_type_price, 2);*/
                            if ($application->promotion_type === 2) {
                                $price = number_format($prices->other_type_price_keywords, 2);
                            } else {
                                $price = number_format($prices->other_type_price, 2);
                            }
                        @endphp
                        <input type="text" class="form-control" id="price"
                               value="{{ $price }}"
                               title="@lang('labels.user_price')"
                               name="price2" readonly required/>
                        {{--<input type="text" class="form-control" id="price" value="{{ $price }}" title="@lang('labels.user_price')" name="price"/>--}}
                        <span class="input-group-addon">{{ $currency }}</span>
                    </div>
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
                    {{ $application->promotion_type === 2 ? 'checked' : '' }}/>
            <span class="slider round"></span>
        </label>
        </div>
        <p style="{{ $application->description_active ? 'display: inline-block;' : 'display: none;' }} vertical-align: top; margin-top: 7px; margin-left: 4px"
           id="description_price_label">
            {{-- DESCRIPTION PRICE FROM SETTINGS --}}
            + {{ '0.00 ' . $currency }}
        </p>
    </div>
    <div class="form-item_body col-lg-8">
        <div class="row">
            <select name="keywords[]" class="form-control" id="keywords"
                    title="@lang('labels.search_query')" multiple
                    style="width: 100%"
                    data-placeholder="@lang('labels.search_query')">
                @if($application->keywords)
                    @foreach($application->keywords as $keyword)
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