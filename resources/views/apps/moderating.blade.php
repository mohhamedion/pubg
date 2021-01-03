@extends('layouts.app')

@section('title', trans('labels.moderating_title'))

@section('content')
    @include('flash::message')

    <div class="panel campaigns-panel dark_mod">
        <div class="row">
            <div class="col-md-12">
                <h2 class="panel-title dark_mod-title">@lang('labels.moderating_title')</h2>

                @if($moderating_apps > 0)
                    <div class="row table-responsive" style="width: auto; background: black;" >

                        <table id="apps_table"
                               data-toggle="table"
                               data-route="{{ route('apps::index') }}"
                               data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                               data-currency="{{ $currency }}">
                            <thead>
                            <tr>
                                <th data-field="name" data-formatter="app_names"
                                    data-sortable="true">@lang('labels.buttons.apps')</th>

                                <th data-field="id"
                                    data-formatter="statusFormatter">@lang('labels.status.status')</th>

                                <th data-field="price" data-sortable="true" data-width="80px"
                                    data-formatter="amount">@lang('labels.install-price')</th>

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
                    <div class="alert alert-info dark_mod-alert">
                        @lang('labels.empty.moderating_campaigns')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const apps = {!! $apps !!};

        function statusFormatter(id, app) {
            let status = '';

            if (!app.paid && !app.done) {
                status = "<span class='label label-warning label-big'>@lang('labels.status.pending')</span>";
            } else if (app.paid && !app.moderated) {
                status = "<span class='label label-warning label-big'>@lang('labels.status.moderating')</span>";
            } else if (app.moderated && !app.accepted && !app.done) {
                status = "<span class='label label-danger label-big'>@lang('labels.status.declined')</span>";
            } else if (app.paid && app.moderated && app.accepted && !app.active && !app.done) {
                status = "<span class='label label-success label-big'>@lang('labels.status.ready')</span>";
            }

            if (app.paid && app.moderated && app.accepted && app.active) {
                status = "<span class='label label-info label-big'>@lang('labels.tasks.active')</span>";
            } else if (app.paid && app.moderated && app.accepted && app.done) {
                status = "<span class='label label-success label-big'>@lang('labels.tasks.done')</span>";
            }

            return status;
        }

        $(document).ready(function () {
            $('#apps_table').bootstrapTable('load', apps);
        });
    </script>
@endpush