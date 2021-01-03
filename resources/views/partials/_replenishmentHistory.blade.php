<div class="row">
    <h3 class="mb20">@lang('labels.replenishment_history')</h3>
    <table class="table replenishments-table">
        <thead>
        <tr>
            <th>@lang('labels.ik_inv_id')</th>
            <th>@lang('labels.amount')</th>
            <th>@lang('labels.datetime')</th>
        </tr>
        </thead>
        <tbody>
        @if(count($replenishment_history))
            @foreach($replenishment_history as $replenishment)
                <tr>
                    <td>
                        @if(empty($replenishment->ik_inv_id) && empty($replenishment->unitpayId) && empty($replenishment->app_id))
                            Admin
                        @elseif(!empty($replenishment->ik_inv_id))
                            {{ $replenishment->ik_inv_id }} (Interkassa)
                        @elseif(!empty($replenishment->unitpayId))
                            {{ $replenishment->unitpayId }} (Unitpay)
                        @elseif(!empty($replenishment->app_id))
                            <a href="{{ route('apps::show', $replenishment->app_id) }}">{{ $replenishment->app_id }}</a> (App)
                        @endif
                    </td>
                    <td>{{ $replenishment->amount . ' ' . $currency}}</td>
                    <td>{{ $replenishment->created_at->format('H:i:s d-m-Y') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">@lang('labels.replenishment_history_empty')</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>