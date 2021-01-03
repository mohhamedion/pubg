<div class="form-group">
    <label for="award_standard_promo_code">@lang('labels.standard_promocode')</label>
    <input type="number" class="form-control" title="award_standard_promo_code"
           name="award_standard_promo_code" value="{{ $settings['award_standard_promo_code'] }}"
           step="0.01" >
</div>

<div class="form-group">
    <label for="award_partner_promo_code">@lang('labels.partner_promocode')</label>
    <input type="number" class="form-control" title="award_partner_promo_code"
           name="award_partner_promo_code" value="{{ $settings['award_partner_promo_code'] }}"
           step="0.01" >
</div>