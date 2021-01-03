<!--- Second referral system balance limit Field --->
<div class="form-group">
    {!! Form::label('referral_second_balance_limit', trans('labels.referral_second_balance_limit') . ', ' . $currency, '') !!}
    {!! Form::input('referral_second_balance_limit', 'referral_second_balance_limit', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Second referral system reward percentage Field --->
<div class="form-group">
    {!! Form::label('referral_second_reward_percentage', trans('labels.referral_second_reward_percentage')) !!}
    {!! Form::input('referral_second_reward_percentage', 'referral_second_reward_percentage', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Second referral system reward time Field --->
<div class="form-group">
    {!! Form::label('referral_second_reward_time', trans('labels.referral_second_reward_time')) !!}
    {!! Form::input('referral_second_reward_time', 'referral_second_reward_time', null, ['class' => 'form-control', 'required']) !!}
</div>