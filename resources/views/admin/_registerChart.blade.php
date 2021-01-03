{!! $registerChart['chart'] !!}

<div class="statistics">
    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.registers_user')</span>
        </div>
        <div class="statistics-item__amount register_users">
            <span>{{ $registerChart['total_registers_user'] }}</span>
        </div>
    </div>

    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.registers_manager')</span>
        </div>
        <div class="statistics-item__amount register_manager">
            <span>{{ $registerChart['total_registers_manager'] }}</span>
        </div>
    </div>
</div>