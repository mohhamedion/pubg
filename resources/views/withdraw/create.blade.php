@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>
    <div class="panel user-panel">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                {!! Form::open(['route' => 'users::store', 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('labels.name') . ':' ) !!}
                    {!! Form::text('name',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('email', 'email',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', trans('labels.password') . ':', ['class'=>'control-label'] ) !!}
                    {!! Form::input('password', 'password',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', trans('labels.confirm_password') . ':', ['class'=>'control-label'] ) !!}
                    {!! Form::input('password', 'password_confirmation',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('role', trans('labels.access_level') . ':') !!}
                    {!! Form::select('role', $roles, null, ['class' => 'form-control chosen width-100', 'required']) !!}
                </div>

                <input type="submit" class="button button-submit primary" value="@lang('labels.save')"/>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection