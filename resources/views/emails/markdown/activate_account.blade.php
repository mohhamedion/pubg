@component('vendor.mail.markdown.message')
# {{ trans('labels.confirm_registration') }}

{{ trans('labels.thanks_for_register') }}

@component('mail::button', ['url' => URL::to('activate/' . $code)])
{{ trans('messages.click_activation_link') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent