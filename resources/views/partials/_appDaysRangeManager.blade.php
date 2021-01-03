<div class="row">
    <div class="days-range">
        @if($application->time_delay === 48)
            <label class="range_count" id="range_first">2</label>
            <label class="range_count" id="range_second">6</label>
            <label class="range_count" id="range_third">10</label>
            <label class="range_count" id="range_fourth">20</label>
            <label class="range_count" id="range_fifth">22</label>
            <input type="range" min="2" max="22" step="2" value="{{ $application->days }}"
                   name="days" id="days" title="@lang('labels.install-limit-days')"
                   @if($application->paid) min="{{ $application->days }}" @endif
                   @if(!$application->canBeChanged()) disabled readonly @endif/>
        @else
            <label class="range_count" id="range_first">3</label>
            <label class="range_count" id="range_second">7</label>
            <label class="range_count" id="range_third">15</label>
            <label class="range_count" id="range_fourth">22</label>
            <input type="range" min="1" max="22" step="1" value="{{ $application->days }}"
                   name="days" id="days" title="@lang('labels.install-limit-days')"
                   @if($application->paid) min="{{ $application->days }}" @endif
                   @if(!$application->canBeChanged()) disabled readonly @endif/>
        @endif
        <output for="days" id="days_range_tooltip">
            {{ $application->days }}
        </output>
    </div>
</div>