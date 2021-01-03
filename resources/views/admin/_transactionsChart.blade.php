{!! $transactionsChart['chart'] !!}

<div class="statistics">
    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.total')</span>
        </div>
        <div class="statistics-item__amount total">
            <span>{{ $transactionsChart['total'] }}</span>
        </div>
    </div>

    <div class="statistics-item">
        <div class="statistics-item__title">
            <span>@lang('labels.transactions.plural.successful')</span>
        </div>
        <div class="statistics-item__amount successful">
            <span>{{ $transactionsChart['total_success'] }}</span>
        </div>
    </div>
    <div class="statistics-item">
    <div class="statistics-item__title">
            <span>@lang('labels.transactions.plural.rejected')</span>
        </div>
        <div class="statistics-item__amount failed">
            <span>{{ $transactionsChart['total_rejected'] }}</span>
        </div>
    </div>
</div>