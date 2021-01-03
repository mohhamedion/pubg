@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>@lang('labels.stats')</h1>

    @include('flash::message')

    <div class="panel panel-buttons">
        <div class="row">
            @if($auth_user->id === $application->user_id && !$application->paid)
                <a class="button primary pay-from-balance"
                   data-route="{{ route('apps::pay_balance', ['application' => $application->id]) }}">
                    @lang('labels.buttons.pay_from_balance')
                    ({{ number_format($application->amount_for_user, 2, '.', '') }} @lang("labels.currency.Russia.name")
                    )
                </a>
                </form>
            @endif

            <a href="{{ route('apps::edit', ['application' => $application->id]) }}"
               class="button primary inline pull-right">@lang('labels.buttons.edit')</a>

            @if($is_admin)
                <a href="{{ route('apps::changes_history', ['application' => $application->id]) }}"
                   style="margin-right: 10px" id="changes_history"
                   class="button primary inline pull-right">@lang('labels.changes_history')</a>
            @endif
        </div>
    </div>

    @include('admin._appModerating', compact('application'))

    <div class="panel panel-application-show">
        <div class="row">
            <div class="col-md-12">
                <div class="row table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>@lang('labels.app')</th>
                            <th>@lang('labels.progress')</th>
                            <th>@lang('labels.holding')</th>
                            <th>@lang('labels.time_delay')</th>
                            <th>@lang('labels.total_price')</th>
                            <th>@lang('labels.task_balance')</th>
                            <th>@lang('labels.wasted')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="app-table-group single_app">
                                    <img src="{{ $application->image }}" alt="{{ $application->name }}"/>
                                    <p>{{ $application->name }}</p>
                                </div>
                            </td>

                            <td>{{ $application->limit_state }}</td>

                            <td>{{ $application->time_delay_formatted }}</td>

                            <td>@lang('labels.once_short')</td>

                            <td>{{ $application->price  . ' ' . $currency }}
                            </td>

                            <td>{{ $application->amount_for_user . ' ' . $currency }}</td>

                            <td>{{ $application->amount_wasted . ' ' . $currency }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
            @if($is_manager)
                <div class="col-md-12">
                    <p style="color: orangered; font-size: 18px">@lang('messages.app_statistics_warning')</p>
                </div>
            @else
                <form action="{{ route('apps::statistics.update', $application) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3 form-group">
                            {!! Form::label('limit', trans('labels.progress'), ['class' => 'mb20']) !!}
                            <input type="number" name="limit" id="limit" min="0" max="{{ $application->limit }}"
                                   class="form-control" value="{{ $application->statistics->limit }}" required
                            />
                        </div>
                    </div>
                    <button class="btn btn-primary">@lang('labels.update')</button>
                </form>
            @endif
        </div>
    </div>
@endsection
