<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.from_to', ['from' => '5 000', 'to' => '30 000'])) !!}
    {!! Form::input('text', 'cashback[first]', isset($settings->cashback['first']) ? $settings->cashback['first'] : 0, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.from_to', ['from' => '30 000', 'to' => '70 000'])) !!}
    {!! Form::input('text', 'cashback[second]', isset($settings->cashback['second']) ? $settings->cashback['second'] : 0, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.from_to', ['from' => '70 000', 'to' => '150 000'])) !!}
    {!! Form::input('text', 'cashback[third]', isset($settings->cashback['third']) ? $settings->cashback['third'] : 0, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.from_to', ['from' => '150 000', 'to' => '300 000'])) !!}
    {!! Form::input('text', 'cashback[fourth]', isset($settings->cashback['fourth']) ? $settings->cashback['fourth'] : 0, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.from_to', ['from' => '300 000', 'to' => '500 000'])) !!}
    {!! Form::input('text', 'cashback[fifth]', isset($settings->cashback['fifth']) ? $settings->cashback['fifth'] : 0, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cachback', trans('labels.cashback.more_than', ['from' => '500 000'])) !!}
    {!! Form::input('text', 'cashback[sixth]', isset($settings->cashback['sixth']) ? $settings->cashback['sixth'] : 0, ['class' => 'form-control']) !!}
</div>