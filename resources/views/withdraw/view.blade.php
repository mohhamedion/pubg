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
                                <strong>{{ $user->phone_number ?? '-' }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.locations'):</td>
                            <td class="value">
                                <strong>{{ optional($user->country)->name . ' - ' . optional($user->city)->name }}</strong>
                            </td>
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
                            <td class="name">@lang('labels.referral_first_code'):</td>
                            <td class="value">
                                <strong>{{ $user->promo_code_first }}</strong>
                            </td>
                        </tr>

                        <tr height="40px">
                            <td class="name">@lang('labels.referral_second_code'):</td>
                            <td class="value">
                                <strong>{{ $user->promo_code_second }}</strong>
                            </td>
                        </tr>

                        {{--<tr height="40px">
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
                        </tr>--}}

                        {{--<tr height="40px">
                            <td class="name">@lang('labels.referrer'):</td>
                            <td class="value"><a
                                        href="--}}{{--{{ $user->getReferrerLink() }}">{{ $user->getReferrerIdentifier() }}--}}{{--</a>
                            </td>
                        </tr>--}}
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
            <div class="col-md-12">
                {!! Form::model($user, ['url' => route('users::update', $user), 'method' => 'PUT']) !!}

                <div class="form-group">
                    {!! Form::label('name', trans('labels.name') ) !!}
                    {!! Form::text('name',  null, ['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class'=>'control-label'] ) !!}
                    {!! Form::input('email', 'email',  null, ['class'=>'form-control'] ) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('balance', trans('labels.balance'), ['class'=>'control-label'] ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">{{ $currency }}</span>
                        {!! Form::input('balance', 'balance',  null, ['class'=>'form-control'] ) !!}
                    </div>
                </div>

                {{-- Only admin can edit role of user --}}
                @if($is_admin)
                    <div class="form-group">
                        {!! Form::label('role', trans('labels.access_level')) !!}
                        {!! Form::select('role', $roles, null, ['class' => 'form-control chosen width-100']) !!}
                    </div>
                @endif

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

        <hr/>

        <div class="row">
            <div class="col-md-12">
                {!! Form::model($user, ['url' => route('users::delete', $user), 'method' => 'DELETE']) !!}

                <input type="submit" class="button bordered btn-danger" style="float: right; font-size: 16px"
                       value="@lang('labels.buttons.delete')"/>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @if($is_admin)
        <div class="panel panel-user">
            @include('partials._replenishmentHistory')
        </div>
    @endif

    @include('partials._sendPushNotificationModal', ['url' => route('users::show::send-push', ['id' => $user->id])])
@endsection