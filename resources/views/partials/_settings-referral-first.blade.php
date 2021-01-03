<!--- First referral system balance limit Field --->
<div class="form-group">
    {!! Form::label('referral_first_balance_limit', trans('labels.referral_first_balance_limit') . ', ' . $currency, '') !!}
    {!! Form::input('referral_first_balance_limit', 'referral_first_balance_limit', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- First referral system reward percentage Field --->
<div class="form-group">
    {!! Form::label('referral_first_reward_percentage', trans('labels.referral_first_reward_percentage')) !!}
    {!! Form::input('referral_first_reward_percentage', 'referral_first_reward_percentage', null, ['class' => 'form-control', 'required']) !!}
</div>