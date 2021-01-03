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
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <input type="email" class="inputfield" name="email" value="{{ old('email') }}" placeholder="Email" required/>

            <input type="password" class="inputfield" name="password" placeholder="@lang('labels.password')" required/>

<p style="color:white;"><?php print_r(Session::has('errors')); ?></p>

			@if(isset($err))
				<p style="color: red;">{{$err}}</p>
			@endif

            @include('partials._googleTagManager')

            <a href="{{ url('/password/reset') }}" id="forgot-password-link">
                @lang('labels.links.forgot_password')
            </a>

            <input class="button signIn" type="submit" value="@lang('labels.buttons.sign_in')"/>
		
        </form>
		
    </div>
    <a class="button button-flat-panel" href="{{ route('register') }}">@lang('labels.buttons.sign_up')</a>
@endsection