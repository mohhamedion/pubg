{!! $usersTasksChart['chart'] !!}

<div class="statistics">
    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.installs')</span>
        </div>
        <div class="statistics-item__amount installs">
            <span>{{ $usersTasksChart['total_app_installs'] }}</span>
        </div>
    </div>

    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.runs')</span>
        </div>
        <div class="statistics-item__amount runs">
            <span>{{ $usersTasksChart['total_app_runs'] }}</span>
        </div>
    </div>
    <div class="statistics-item">
    <div class="statistics-item__title">
            <span>@lang('labels.failed')</span>
        </div>
        <div class="statistics-item__amount failed">
            <span>{{ $usersTasksChart['total_app_fails'] }}</span>
        </div>
    </div>
</div>