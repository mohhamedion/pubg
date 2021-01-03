@extends('layouts.auth')

@section('title', trans('labels.buttons.sign_up'))

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
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <input name="name" class="inputfield" value="{{ old('name') }}" placeholder="@lang('labels.name')" required/>

            <input type="email" name="email" class="inputfield" value="{{ old('email') }}" placeholder="Email" required/>

            <input type="password" name="password" class="inputfield" placeholder="@lang('labels.password')" required/>

            <input type="password" name="password_confirmation" class="inputfield"
                   placeholder="@lang('labels.confirm_password')" required/>

            @include('partials._googleTagManager')

            <input class="button signIn" style="margin-top: 10px" type="submit"
                   value="@lang('labels.buttons.register')"/>

        </form>
    </div>
    <a class="button button-flat-panel" href="{{ url('/login') }}">
        @lang('labels.links.have_account')
    </a>
@endsection