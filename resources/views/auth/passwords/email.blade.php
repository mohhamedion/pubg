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

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}

            @if(!session('status'))<p>@lang('passwords.reset_message')</p>@endif

            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required/>

            <input class="button primary" type="submit" value="@lang('labels.buttons.send')"/>
        </form>
    </div>
@endsection