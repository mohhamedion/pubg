@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if(!empty($user->fcm_token))
                <button type="button" class="btn btn-primary btn-lg pull-right mt5" data-toggle="modal"
                        data-target="#sendPushNotificationModal">
                    @lang('labels.send_push_notification')
                </button>
            @endif
        </div>
    </div>

    @include('flash::message')

    <div class="panel transactions-panel">
        <div class="panel darker-panel">
            <div class="row">
                <div class="col-md-4">
                    <table>
                        @if($user->name)
                            <tr height="25px">
                                <td>
                                    <a href="{{ route('users::show::index', $user) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                            </tr>
                        @endif
                        <tr height="25px">
                            <td>
                                <a href="{{ route('users::show::index', $user) }}">
                                    {{ $user->device_token }}
                                </a>
                            </td>
                            <td style="padding-left: 10px">@lang('labels.fcm_token')</td>
                        </tr>
                        @if($user->email)
                            <td>
                                <a href="mail:{{ $user->email }}">
                                    {{ $user->email }}
                                </a>
                            </td>
                        @endif
                    </table>
                </div>
                <div class="col-md-4 col-md-offset-4 pull-right">
                    <table class="two-column-table pull-right">
                        <tbody>
                        <tr height="25px">
                            <td class="name">{{trans('labels.transactions.updated_at')}}:</td>
                            <td class="value">{{ $transaction->updated_at }}</td>
                        </tr>
                        <tr height="25px">
                            <td class="name">{{trans('labels.transactions.status')}}:</td>
                            <td class="value">
                            <span class="label label-count label-{{ $transaction->status_for_view['class'] }}">
                                {{ $transaction->status_for_view['label'] }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <table class="two-column-table mb10">
                    <tr height="40px">
                        <td class="name">@lang('labels.transactions.created_at'):</td>
                        <td class="value"><strong>{{ $transaction->created_at }}</strong></td>
                    </tr>
                    <tr height="40px">
                        <td class="name">@lang('labels.transactions.number'):</td>
                        <td class="value"><strong>{{ $transaction->phone }}</strong></td>
                    </tr>
                    @if($transaction->response)
                        <tr height="40px">
                            <td class="name">@lang('labels.transactions.response'):</td>
                            <td class="value"><strong>{{ $transaction->response }}</strong></td>
                        </tr>
                    @endif
                    <tr height="40px">
                        <td class="name">@lang('labels.transactions.method'):</td>
                        <td class="value"><strong>{{ $transaction->method }}</strong></td>
                    </tr>
                    <tr height="40px">
                        <td class="name">@lang('labels.transactions.amount'):</td>
                        <td class="value"><strong>{{ $transaction->amount . ' ' . $transaction->currency }}</strong>
                        </td>
                    </tr>
                    <tr height="40px">
                        <td class="name">@lang('labels.transactions.amount_clean'):</td>
                        <td class="value">
                            <strong>{{ $transaction->amount_clean . ' ' . $transaction->currency }}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6 col-md-offset-1 panel-info-statuses-wrapper">
                <div class="panel-info-statuses">
                    {!! Form::open(array( 'class' => 'form-horizontal', 'role' => 'form') ) !!}
                    <div class="form-group">
                        <div class="transaction-locked-wrapper mb10">
                            @if($transaction->locked)
                                <i class="fa fa-lock fa-2x"></i>
                            @else
                                <i class="fa fa-unlock fa-2x"></i>
                            @endif
                        </div>
                        <label for="status">@lang('labels.transactions.change_status')</label>
                        <br/>
                        <select name="status" id="status" class="form-control"
                                @if($transaction->locked === true) disabled @endif>
                            @foreach((array) $statuses as $status => $label)
                                <option value="{{ $status }}"
                                        @if($status === $transaction->state) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(!$transaction->locked && $transaction->manual)
                        <div class="form-group mb5">
                            <div class="warning-message alert alert-with-icon danger alert-dismissible">
                                <i class="alert-icon fa fa-exclamation-triangle"></i>
                                {!! trans('messages.transaction_will_be_restored') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   class="button primary"
                                   value="@lang('labels.update')"/>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="panel user-panel">
        <div class="panel darker-panel">
            <div class="row">
                <div class="col-md-3">
                    <table class="two-column-table mb10">
                        <tr height="40px">
                            <td class="name">@lang('labels.name'):</td>
                            <td class="value"><strong>{{ $user->name }}</strong></td>
                        </tr>

                        <tr height="40px">
                            <td class="name">Email:</td>
                            <td class="value"><strong>{{ $user->email ?? '-' }}</strong></td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.login'):</td>
                            <td class="value"><strong>{{ $user->login ?? '-' }}</strong></td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.device_type'):</td>
                            <td class="value"><strong>{{ $user->device_type ?? '-' }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.device_token'):</td>
                            <td class="value"><strong>{{ $user->device_token ?? '-' }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.phone'):</td>
                            <td class="value">
                                <strong>{{ $user->phone_number ?? '-' }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="two-column-table mb10">
                        <tr height="40px">
                            <td class="name">@lang('labels.balance'):</td>
                            <td class="value">
                                <strong>{{ $user->balance . ' ' . $currency }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.referral_first_balance'):</td>
                            <td class="value">
                                <strong>{{ $user->referral_balance . ' ' . $currency }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.boosted_at'):</td>
                            <td class="value">
                                <strong>{{ $user->boosted_at === '0000-00-00 00:00:00' ?: '-'}}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.boosted_at'):</td>
                            <td class="value">
                                <strong>{{ $user->boosted_at === '0000-00-00 00:00:00' ?: '-'}}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.activated_referral_at'):</td>
                            <td class="value">
                                <strong>{{ $user->activated_referral_at === '0000-00-00 00:00:00' ?: '-'}}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.referrer'):</td>
                            <td class="value"><a
                                        {{--href="{{ $user->getReferrerLink() }}"--}}>{{--{{ $user->getReferrerIdentifier() }}--}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-5">
                    <table class="two-column-table">
                        <tr height="40px">
                            <td class="name">{{trans('labels.registered')}}:</td>
                            <td class="value">{{ $user->created_at }}</td>
                        </tr>

                        <tr height="40px">
                            <td class="name">
                                <a href="{{ route('users::show::referralsView', $user) }}">
                                    {{trans('labels.referrals')}}:
                                </a>
                            </td>
                            <td class="value">
                                <a href="{{ route('users::show::referralsView', $user) }}">
                                    {{ $referrals_count }}
                                </a>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">
                                <a href="{{ route('users::show::tasksView', $user) }}">
                                    {{trans('labels.tasks.tasks')}}:
                                </a>
                            </td>
                            <td class="value">
                                <a href="{{ route('users::show::tasksView', $user) }}">
                                    {{ $tasks_count }}
                                </a>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">
                                <a href="{{ route('users::show::awardsView', $user) }}">
                                    {{trans('labels.awards')}}:
                                </a>
                            </td>
                            <td class="value">
                                <a href="{{ route('users::show::awardsView', $user) }}">
                                    {{ $awards_count }}
                                </a>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">
                                <a href="{{ route('users::show::transactionsView', $user) }}">
                                    {{trans('labels.buttons.transactions')}}:
                                </a>
                            </td>
                            <td class="value">
                                <a href="{{ route('users::show::transactionsView', $user) }}">
                                    {{ $transactions_count }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="additional-user-info">
                    <label class="mb20">
                        @lang('labels.earned_amount') (@lang('labels.applications')
                        ):</label> {{ "${earned_applications} ${currency}." }}<br/>
                    <label class="mb20">
                        @lang('labels.earned_amount'):</label> {{ "${earned_total} ${currency}." }}<br/>
                    <label class="mb20">
                        @lang('labels.transactions_amount') (@lang('labels.transactions.plural.successful')
                        ):</label> {{ "${success_transaction_amount} ${currency}." }}<br/>
                </div>

                {!! Form::model($user, ['url' => route('users::update', $user), 'method' => 'PUT']) !!}

                <div class="form-group">
                    {!! Form::label('balance', trans('labels.balance'), ['class'=>'control-label'] ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">{{ $currency }}</span>
                        {!! Form::input('balance', 'balance',  null, ['class'=>'form-control'] ) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="banned">@lang('labels.banned')</label><br/>
                    <label class="switch" title="@lang('labels.banned')">
                        <input type="checkbox" name="banned" value="1" class="switch"
                               id="banned" {{ $user->banned ? 'checked' : '' }}/>
                        <span class="slider round"></span>
                    </label>
                </div>

                <input type="submit" class="button primary" id="submit" value="@lang('labels.update')"/>

                {!! Form::close() !!}
            </div>
        </div>

    </div>

    @include('partials._sendPushNotificationModal', ['url' => route('users::show::send-push', ['id' => $user->id])])
@endsection

@section('scripts')
    <script>
        $('#status').change(function () {
            let status = $(this).val();
            if (status === '{{ \App\Models\Transaction::STATUS_REJECTED }}') {
                $(this).after()
            }
        })
    </script>
@endsection