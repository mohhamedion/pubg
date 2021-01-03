<div class="row">
    <div class="days-range">
        {{--@if($application->time_delay === 48 * 60 * 60)--}}
        {{--<label class="range_count" id="range_first">6</label>--}}
        {{--<label class="range_count" id="range_second">10</label>--}}
        {{--<label class="range_count" id="range_third">20</label>--}}
        {{--<label class="range_count" id="range_fourth">30</label>--}}
        {{--<label class="range_count" id="range_fifth">50</label>--}}
        {{--<input type="range" min="6" max="50" step="2" value="{{ $application->days }}"--}}
        {{--name="days" id="days" title="@lang('labels.install-limit-days')"--}}
        {{--@if($application->paid) min="{{ $application->days }}" @endif--}}
        {{--@if(!$application->canBeChanged()) disabled readonly @endif/>--}}
        {{--@else--}}
        <label class="range_count" id="range_first">1</label>
        <label class="range_count" id="range_second">7</label>
        <label class="range_count" id="range_third">15</label>
        <label class="range_count" id="range_fourth">22</label>
        <input type="range" min="1" max="22" step="1" value="{{ $application->days }}"
               name="days" id="days" title="@lang('labels.install-limit-days')"
               @if($application->paid) min="{{ $application->days }}" @endif
               @if(!$application->canBeChanged()) disabled readonly @endif/>
        {{--@endif--}}
        <output for="days" id="days_range_tooltip">
            {{ $application->days }}
        </output>
    </div>
</div>
