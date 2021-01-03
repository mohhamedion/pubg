<div class="row">
    <div class="days-range">
        <?php
        $constDays = [
            24 => [1, 7, 15, 30, 50],
            48 => [2, 10, 20, 30, 50],
            72 => [3, 7, 15, 30, 50]
        ]
        ?>
        <label class="range_count" id="range_first">{{ $constDays[$application->time_delay][0] }}</label>
        <label class="range_count" id="range_second">{{ $constDays[$application->time_delay][1] }}</label>
        <label class="range_count" id="range_third">{{ $constDays[$application->time_delay][2] }}</label>
        <label class="range_count" id="range_fourth">{{ $constDays[$application->time_delay][3] }}</label>
        <label class="range_count" id="range_fifth">{{ $constDays[$application->time_delay][4] }}</label>
        <input type="range"
               min="{{ $constDays[$application->time_delay][0] }}"
               max="{{ $constDays[$application->time_delay][4] }}"
               step="{{ $application->time_delay === 48 ? '2' : '1' }}"
               value="@if(($application->days == 3 || $application->days == 1) && $application->time_delay == 24)1"
               @elseif(($application->days == 3 || $application->days == 1) && $application->time_delay == 48)2"
               @elseif(($application->days == 3 || $application->days == 1) && $application->time_delay == 72)3"
               @else{{ $application->days }}"@endif
               name="days" id="days" title="@lang('labels.install-limit-days')"
               @if(!$application->canBeChanged()) disabled readonly @endif
        />

        <output for="days" id="days_range_tooltip">
            {{ $application->days }}
        </output>

    </div>
</div>
