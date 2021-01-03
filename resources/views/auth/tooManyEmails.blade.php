@extends('layouts.auth')

@section('title', trans('labels.buttons.password_reset'))

@section('content')
    <p style="padding-left: 20px">@lang('auth.too_many_emails')</p>
@endsection