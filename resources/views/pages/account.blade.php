@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1 class="dark-title">{{ $title }}</h1>

    {{--@include('flash::message')--}}

    <div class="panel panel-account dark-panel">
        {!! Form::model($user, ['route' => 'account::patch.index', 'method' => 'PATCH']) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', trans('labels.name')) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            @if($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb20{{ $errors->has('email') ? ' has-error' : '' }} dark-input">
            {!! Form::label('email', 'Email') !!}
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'required']) !!}
            @if($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <input type="submit" class="dark-button button primary mb40" value="@lang('labels.save')"/>
        {!! Form::close() !!}

        <!-- REST API key -->
        {{--<h1 class="dark-title second-btn">REST API key</h1>
        <p class="dark-text">
            Ваш персональный ключ для доступа к REST API запросам приложения. <br>
            Документация: <a href="" class="dark-link">https://client.my.mafia.com/</a>
        </p>
        <input type="text" class="dark-input__api" value="Y8Cz5dYlzatm1C094AUW7lCHxi7Ortlt">--}}
        <!-- /REST API key -->

        {{--@if($has_api_key)
            <h3>@lang('labels.api_key_heading')</h3>
            <!-- <hr/> -->
            <div class="form-group">
                <p class="mb10">@lang('messages.api_key_description')</p>
                <p class="mb20">@lang('messages.documentation'):
                    <a href="{{ config('app.client_api_url') . '/' . config('swaggervel.client-api-docs-route') }}"
                       target="_blank">
                        {{ config('app.client_api_url') . '/' . config('swaggervel.client-api-docs-route') }}
                    </a>
                </p>
                {!! Form::text('api_key', $api_key, ['class' => 'form-control mb20', 'readonly']) !!}
            </div>
        @endif--}}

        <h1 class="dark-title first-btn">@lang('labels.change_password')</h1>
       <!--  <hr/> -->
        {!! Form::model($user, ['route' => 'account::patch.password', 'method' => 'PATCH']) !!}
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', trans('labels.password')) !!}
            {!! Form::input('password', 'password', null,
            ['class' => 'form-control', 'placeholder' => trans('passwords.password_placeholder'), 'required']) !!}
            @if($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
            {!! Form::label('new_password', trans('labels.new_password')) !!}
            {!! Form::input('password', 'new_password', null,
            ['class' => 'form-control', 'placeholder' => trans('passwords.new_password_placeholder'), 'required']) !!}
            @if($errors->has('new_password'))
                <span class="help-block">
                    <strong>{{ $errors->first('new_password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb20">
            {!! Form::label('new_password_confirmation', trans('labels.confirm_password')) !!}
            {!! Form::input('password', 'new_password_confirmation', null,
            ['class' => 'form-control', 'placeholder' => trans('passwords.new_password_confirmation_placeholder'), 'required']) !!}
        </div>

        <input type="submit" class="dark-button button primary mb40" value="@lang('labels.buttons.change')"/>
        {!! Form::close() !!}
    </div>
@endsection

