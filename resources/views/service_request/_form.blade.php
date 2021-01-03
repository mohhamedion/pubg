{!! Form::open(['route' => ['service::store', $type->name]]) !!}

<div class="form-group">
    {!! Form::label('email', 'E-Mail') !!}
    {!! Form::email('email', $auth_user->email, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('url', Lang::get('labels.app_url')) !!}
    {!! Form::url('url', null, ['class' => 'form-control', 'required',
        'placeholder' => 'https://play.google.com/store/apps/details?id=com.google.android.googlequicksearchbox']) !!}
</div>

<div class="form-group">
    {!! Form::label('skype_telegram', Lang::get('labels.skype_telegram')) !!}
    {!! Form::text('skype_telegram', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', Lang::get('labels.description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::submit(Lang::get('labels.send_request'), ['class' => 'button bordered']) !!}
</div>

{!! Form::close() !!}