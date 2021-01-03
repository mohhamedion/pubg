<div class="row">
    <table class="table replenishments-table">
        <thead>
        <tr>
            <th>@lang('labels.users_count')</th>
            <th>@lang('labels.time_delay')</th>
            <th>@lang('labels.install-limit-days')</th>
            <th>@lang('labels.locations')</th>
            <th>@lang('labels.keywords')</th>
            <th>@lang('labels.transactions.updated_at')</th>
        </tr>
        </thead>
        @if($changes_history->count())
            @foreach($changes_history as $app)
                <tbody>
                <tr>
                    <td>{{ $app->limit }}</td>
                    <td>{{ $app->time_delay }}</td>
                    <td>{{ $app->days }}</td>
                    @if(!empty($app->city) && !empty($app->country))
                        <td>{{ $app->city . ', ' . $app->country }}</td>
                    @elseif(!empty($app->city))
                        <td>{{ $app->city }}</td>
                    @elseif(!empty($app->country))
                        <td>{{ $app->country }}</td>
                    @else
                        <td><p>-</p></td>
                    @endif
                    <td>
                        @if(!is_null($app->keywords) && count($app->keywords) > 0)
                            @foreach($app->keywords as $index => $keyword)
                                {{ $keyword }}{{ $index === count($app->keywords) - 1 ? '' : ', ' }}
                            @endforeach
                        @else
                            <p>-</p>
                        @endif
                    </td>
                    <td>{{ $app->created_at }}</td>
                </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="6">@lang('labels.changes_history_empty')</td>
                    </tr>
                @endif
                </tbody>
    </table>
</div>