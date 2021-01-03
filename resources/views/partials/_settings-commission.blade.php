<!--- Withdraw limit Field --->
<div class="form-group">
    {!! Form::label('withdraw_limit', trans('labels.withdraw_limit') . ', ' . $currency, '') !!}
    {!! Form::input('withdraw_limit', 'withdraw_limit', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Withdraw commission Field --->
<div class="form-group">
    {!! Form::label('withdraw_commission', trans('labels.withdraw_commission')) !!}
    {!! Form::input('withdraw_commission', 'withdraw_commission', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Transfer commission Field --->
<div class="form-group">
    {!! Form::label('transfer_commission', trans('labels.transfer_commission')) !!}
    {!! Form::input('transfer_commission', 'transfer_commission', null, ['class' => 'form-control', 'required']) !!}
</div>