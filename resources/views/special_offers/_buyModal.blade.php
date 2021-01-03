<div class="modal fade" id="buyModal" tabindex="-1" role="dialog"
     aria-labelledby="buyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display: inline-block">@lang('labels.special_offer_show')</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb10">
                    <div class="col-md-6">
                        {!! Form::open(['name' => 'pay-from-balance', 'route' => 'special_offers::pay-balance', 'method' => 'post']) !!}
                        {!! Form::hidden('id') !!}
                        {!! Form::hidden('search_query') !!}
                        {!! Form::hidden('package_name') !!}
                        <input type="submit" class="button bordered button-wrap col-md-3 col-lg-3"
                               value="@lang('labels.buttons.pay_from_balance')"/>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>