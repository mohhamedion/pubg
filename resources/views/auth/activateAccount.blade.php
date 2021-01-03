@extends('layouts.auth')

@section('title', trans('labels.buttons.sign_in'))

@section('content')
    <div class="form-wrapper">
        @if (count($errors) > 0)
            <div class="alert danger">
                <strong>@lang('labels.error')</strong><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel-body">
            <p> @lang('messages.thanks_for_register') <b>{{ $email }}</b></p>
            <p> @lang('messages.click_activation_link') </p>
        </div>
    </div>
@endsection