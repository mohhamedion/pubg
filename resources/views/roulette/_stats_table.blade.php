<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>@lang('labels.bets_label')</th>
        <th>@lang('labels.money')</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>@lang('labels.wins')</td>
        <td>{{ $win_rolls }}</td>
        <td>{{ $win_rolls_amount }}</td>
    </tr>
    <tr>
        <td>@lang('labels.loses')</td>
        <td>{{ $lose_rolls }}</td>
        <td>{{ $lose_rolls_amount }}</td>
    </tr>
    <tr>
        <td>@lang('labels.total')</td>
        <td>{{ $total_rolls }}</td>
        <td>{{ $total_rolls_amount }} (Баланс:
            <span class="{{ $total_rolls_balance_negative ?
                                        'text-danger' : 'text-success' }}">{{ $total_rolls_balance }})</span>
        </td>
    </tr>
    </tbody>
</table>