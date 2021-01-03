@if($is_admin && $application->paid && !$application->moderated)
    <div class="panel panel-buttons">
        <h3 class="mb20">@lang('labels.status.moderating')</h3>
        <button class="button btn-primary moderate-app" data-id="{{ $application->id }}" data-reason="true">
            @lang('labels.buttons.moderate_accept')
        </button>
        <button class="button btn-danger moderate-app" data-id="{{ $application->id }}" data-reason="false">
            @lang('labels.buttons.moderate_decline')
        </button>
    </div>
@endif