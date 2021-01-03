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
        <div class="row">
            <label class="control-label col-md-12 field-description" for="time_delay">
                {!! trans('labels.time_delay_descr') !!}
            </label>
        </div>
    </div>
</div>
