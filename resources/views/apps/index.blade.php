@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    {{--@include('flash::message')--}}

    <div class="panel campaigns-panel">
        <div class="row">
            <div class="col-md-12">
                <h2 class="panel-title">@lang('labels.campaigns_list')</h2>

                @if($apps_count > 0)
                    <div class="row table-responsive" style="width: auto">
                        <div id="toolbar">
                            <div class="form-inline mb20" role="form">
                                <div class="form-group">
                                    <select name="status" title="@lang('labels.status.status')">
                                        <option value="all"
                                                @if($is_manager) selected @endif>@lang('labels.status.all')</option>
                                        <option value="not_paid">@lang('labels.status.pending')</option>
                                        <option value="not_moderated">@lang('labels.status.moderating')</option>
                                        <option value="declined">@lang('labels.status.declined')</option>
                                        <option value="ready">@lang('labels.status.ready')</option>
                                        <option value="active"
                                                @if($is_admin) selected @endif>@lang('labels.tasks.active')</option>
                                        <option value="done">@lang('labels.tasks.done')</option>
                                        <option value="canceled">@lang('labels.tasks.canceled')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="input-group date">
                                        <input class="form-control col-md-1" name="date_from" data-provide="datepicker"
                                               placeholder="@lang('labels.date_from')"/>
                                        <div class="input-group-addon">
                                            <span class="calendar"></span>
                                        </div>
                                        <input class="form-control col-md-1" name="date_to" data-provide="datepicker"
                                               placeholder="@lang('labels.date_to')"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input name="search" class="form-control"
                                           placeholder="@lang('labels.search')"/>
                                </div>

                                @if($is_admin)
                                    <div class="form-group">
                                        <select name="manager" title="@lang('labels.search_by_manager')">
                                            <option value="0" selected>@lang('labels.search_by_manager')</option>
                                            @foreach($managers_with_apps as $id => $email)
                                                <option value="{{ $id }}">
                                                    {{ $email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <table data-route="{{ route('apps::index') }}"
                               data-url="{{ route('apps::get.data') }}"
                               data-toggle="table"
                               data-page-size="10"
                               data-search="false"
                               data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                               data-currency="{{ $currency }}"
                               data-currency="u20BD"
                               data-role="{{ $auth_user->roles()->first()->name }}"
                               data-side-pagination="server"
                               data-sort-order="desc"
                               data-pagination="true"
                               data-query-params="queryParams">
                            <thead>
                            <tr>
                                <th data-field="name" data-formatter="app_names"
                                    data-sortable="true">@lang('labels.buttons.apps')</th>

                                <th data-field="id"
                                    data-formatter="statusFormatter">@lang('labels.status.status')</th>

                                @if($is_manager)
                                    <th data-field="price_for_user" data-sortable="true" data-width="80px"
                                        data-formatter="amount">@lang('labels.run_price')</th>
                                @else
                                    <th data-field="price" data-sortable="true" data-width="80px"
                                        data-formatter="amount">@lang('labels.run_price')</th>
                                @endif

                                <th data-field="limit_state"
                                    data-sortable="true">@lang('labels.installs')</th>

                                <th data-field="formatted_created_at"
                                    data-sortable="true" title="@lang('labels.created_at')"
                                    data-width="100px"
                                    class="thead_created_at">@lang('labels.created_at')</th>

                                <th data-field="id" class="actions_column"
                                    data-formatter="app_actions">@lang('labels.actions')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        @lang('labels.empty.campaigns')
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3" style="padding: 0;">
                        <a href="{{ route('apps::create') }}" class="button primary bordered mb20">
                            @lang('labels.create_campaign')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 