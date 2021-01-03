@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if(!empty($user->device_token))
                <button type="button" class="btn btn-primary btn-lg pull-right mt5" data-toggle="modal"
                        data-target="#sendPushNotificationModal">
                    @lang('labels.send_push_notification')
                </button>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 participants">
            @include('flash::message')

                <table data-sort-order="desc"
                       data-route="users"
                       data-toggle="table"
                       data-url="{{ route('users::getUsersEvent') }}"
                       data-page-size="10"
                       data-filter-show-clear="true"
                       data-filter-starts-with-search="true"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-query-params="queryParams">
                    <thead>
                    <tr>
                        <th data-field="identifier">@lang('labels.identifier')</th>

                        <th data-field="role_name"
                            data-sortable="true">@lang('labels.role')</th>

                        <th data-field="balance_formatted"
                            data-sortable="true">@lang('labels.balance')</th>

                        <th data-field="referrals_count"
                            data-sortable="true">@lang('labels.referrals')</th>

                        <th data-field="banned" data-align="center" data-formatter="banned"
                            data-sortable="true">@lang('labels.banned')
                        </th>
                        
                        <th data-field="created_at" data-sortable="true">@lang('labels.registered_at')</th>

                        <th data-field="id" class="actions_column actions_user"
                            data-formatter="userActions">@lang('labels.actions') </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection