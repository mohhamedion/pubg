@extends('layouts.auth')

@section('content')
    <div class="form-wrapper">
        <p>@lang('messages.admins')</p>
        <p><a href="{{ url('/auth/logout') }}">Войти используя другие данные</a></p>
    </div>
@endsection
