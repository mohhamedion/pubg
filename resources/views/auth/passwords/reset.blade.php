@extends('layouts.auth')

@section('title', trans('labels.buttons.password_reset'))

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
        <form method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}"/>

            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"/>

            <input type="password" name="password" placeholder="@lang('labels.password')"/>

            <input type="password" name="password_confirmation" placeholder="@lang('labels.confirm_password')"/>

            <input class="button primary" type="submit" value="@lang('labels.buttons.change')"/>
        </form>
    </div>
@endsection