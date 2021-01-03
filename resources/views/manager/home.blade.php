<h1>@lang('labels.nav.home')</h1>

@include('flash::message')
@if ($flash = session("message"))
    <div id="flash-message" class="alert alert-success" role="alert">
        {{ $flash }}
    </div>
@endif
<div class="panel panel-home">
    <h1 class="panel-title">
        @lang('labels.titles.home')
    </h1>
    <ul class="instructions">
        <div class="instructions-wrapper">
            <div class="instructions-image">
                <img src="{{ asset('images/main-points/main-p-1.png') }}"
                     alt="@lang('labels.instructions.create_campaign')">
                     <li class="instructions-text">@lang('labels.instructions.create_campaign')</li>  
            </div>
            
        </div>
        <div class="instructions-wrapper">
            <div class="instructions-image">
                <img src="{{ asset('images/main-points/main-p-2.png') }}"
                     alt="@lang('labels.instructions.add_app')">
                     <li class="instructions-text">@lang('labels.instructions.add_app')</li>
            </div>
           
        </div>
        <div class="instructions-wrapper">
            <div class="instructions-image">
                <img src="{{ asset('images/main-points/main-p-3.png') }}"
                     alt="@lang('labels.instructions.set_params')">
                     <li class="instructions-text">@lang('labels.instructions.set_params')</li>
            </div>
            
        </div>
        <div class="instructions-wrapper">
            <div class="instructions-image">
                <img src="{{ asset('images/main-points/main-p-4.png') }}"
                     alt="@lang('labels.instructions.pay_order')">
                     <li class="instructions-text">@lang('labels.instructions.pay_order')</li>
            </div>
           
        </div>
    </ul>
    <div class="chev-container">
        <div class="chev-container__chevron"></div>
    </div>
    <div class="buttons-container">
        <a href="{{ route('apps::create') }}" class="button primary">
            <span>@lang('labels.create_campaign')</span>
        </a>
    </div>
</div>