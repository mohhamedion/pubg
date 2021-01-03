@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="users">
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

    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            <div class="row table-responsive">

                <div id="toolbar">
                    <div class="form-inline mb20" role="form">
                        <div class="form-group">
                            <input name="search" class="form-control"
                                   placeholder="@lang('labels.search')"/>
                        </div>

                        <div class="form-group">
                            <input name="promocode" class="form-control"
                                   placeholder="@lang('labels.promo_code')"/>
                        </div>

                        @if($is_admin)
                            <div class="form-group">
                                <select name="role" title="@lang('labels.role')">
                                    <option value="0" selected>@lang('labels.role')</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ App::isLocale('ru') ? $role->display_name : $role->display_name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <button class="button bordered" type="button"
                                    data-toggle="modal"
                                    data-target="#sendPushNotificationModal">
                                @lang('labels.send_push_notification')
                            </button>
                        </div>
                    </div>
                </div>

                <table data-sort-order="desc"
                       data-route="users"
                       data-toggle="table"
                       data-url="{{ route('users::getUsers') }}"
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

            @if($is_admin)
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                        <a href="{{ route('users::create') }}" class="button primary bordered mb20">
                            @lang('labels.create_user')
                        </a>
                    </div>
                </div>
            @endif
            @include('partials._sendPushNotificationModal', ['url' => route('users::send-push')])
        </div>
    </div>
</div>
@endsection