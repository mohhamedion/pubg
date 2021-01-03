<div class="modal fade" id="surchargeModal" tabindex="-1" role="dialog"
     aria-labelledby="surchargeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display: inline-block">@lang('labels.surcharge_amount'): <span
                            id="surcharge_amount"></span> @lang("labels.currency.{$country}.name")</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb10">
                    <div class="col-md-6">
                        <button class="button bordered button-wrap col-md-3 col-lg-3 submit-surcharge-balance">
                            @lang('labels.buttons.pay_from_balance')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>