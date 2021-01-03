<li>
    <a href="{{ route('home') }}" title="@lang('labels.nav.home')"
       class="{{ request()->url() === route('home') ? 'active' : '' }}">
        <span class="panelIcon home"></span>
        <span class="menu-text">@lang('labels.nav.home')</span>
    </a>
</li>

<li>
    <a href="{{ route('apps::index') }}" title="@lang('labels.nav.campaigns')"
       class="{{ request()->url() === route('apps::index') ? 'active' : '' }}">
       <span class="panelIcon campaign"></span>
        <span class="menu-text">@lang('labels.nav.campaigns')</span>
    </a>
</li>

<li>
    <a href="{{ route('partners::index') }}" title="@lang('labels.nav.partners')"
       class="{{ request()->url() === route('partners::index') ? 'active' : '' }}">
       <span class="panelIcon partners"></span>
        <span class="menu-text">@lang('labels.nav.partners')</span>
    </a>
</li>

<li>
    <a href="{{ route('videos::index') }}" title="@lang('labels.nav.videos')"
       class="{{ request()->url() === route('videos::index') ? 'active' : '' }}">
        <i class="fas fa-video" style="font-size: 14px;"></i>
        <span class="menu-text">@lang('labels.nav.videos')</span>
    </a>
</li>

<li>
    <a href="{{ route('users::index') }}" title="@lang('labels.buttons.users')"
       class="{{ request()->url() === route('users::index') ? 'active' : '' }}">
        <i class="icons8-users"></i>
        <span class="menu-text">@lang('labels.buttons.users')</span>
    </a>
</li>



<li>
    <a href="{{ route('withdraw::index') }}" title="Withdraw points"
       class="{{ request()->url() === route('withdraw::index') ? 'active' : '' }}">
        <i class="icons8-dollar"></i>
        <span class="menu-text">Withdraw points</span>
    </a>
</li>

<li>
    <a href="{{ route('questions::index') }}" title="Withdraw points"
       class="{{ request()->url() === route('questions::index') ? 'active' : '' }}">
        <i class="icons8-rocket-top"></i>
        <span class="menu-text">quizzes</span>
    </a>
</li>


<li>
    <a href="{{ route('special_offers::index') }}" title="@lang('labels.nav.special_offers')"
       class="spec_offer_menu_item {{ request()->url() === route('special_offers::index') ? 'active' : '' }}">
       <span class="panelIcon special_offers"></span>
        <span class="menu-text">@lang('labels.nav.special_offers')
            @if($special_offers)
                <span class="menu-badge danger" id="special_offers">{{ $special_offers }}</span>
            @endif
        </span>
    </a>
</li>

{{--<li>
    <a href="{{ route('service::index', 'top') }}" title="@lang('labels.nav.to_top2')"
       class="{{ request()->url() === route('service::index', 'top') ? 'active' : '' }}">
        <i class="icons8-rocket-top"></i>
        <span class="menu-text">@lang('labels.nav.to_top2')
            @if($requests_top)
                <span class="menu-badge danger" id="top_count">{{ $requests_top }}</span>
            @endif
        </span>
    </a>
</li>--}}

<li> 
    <a href="{{ route('service::index', 'aso') }}" title="@lang('labels.nav.aso_opt')"
       class="{{ request()->url() === route('service::index', 'aso') ? 'active' : '' }}">
       <span class="panelIcon aso"></span>
        <span class="menu-text">@lang('labels.nav.aso_opt')
            @if($requests_aso)
                <span class="menu-badge danger" id="aso_count">{{ $requests_aso }}</span>
            @endif
        </span>
    </a>
</li>

<li>
    <a href="{{ route('service::index', 'comments') }}" title="@lang('labels.nav.testimonials')"
       class="{{ request()->url() === route('service::index', 'comments') ? 'active' : '' }}">
       <span class="panelIcon comment"></span>
        <span class="menu-text">@lang('labels.nav.testimonials')
            @if($requests_comments)
                <span class="menu-badge danger" id="comments_count">{{ $requests_comments }}</span>
            @endif
        </span>
    </a>
</li>

<li>
    <a href="{{ route('news.index') }}" title="@lang('labels.nav.news')"
       class="{{ request()->url() === route('news.index') ? 'active' : '' }}">
       <span class="panelIcon news"></span>
        <span class="menu-text">@lang('labels.nav.news')</span>
    </a>
</li>

<li>
    <a href="{{ route('paymentSystems::index') }}" title="@lang('labels.payment_systems')"
       class="{{ request()->url() === route('paymentSystems::index') ? 'active' : '' }}">
       <span class="panelIcon payment_systems"></span>
        <span class="menu-text">@lang('labels.payment_systems')</span>
    </a>
</li>

{{--
<li>
    <a href="{{ route('video_tour.show') }}" title="@lang('labels.nav.video_tour')"
       class="{{ request()->url() === route('video_tour.show') ? 'active' : '' }}">
        <i class="icons8-video"></i>
        <span class="menu-text">@lang('labels.nav.video_tour')</span>
    </a>
</li>--}}

<li>
    <a href="{{ route('faq.index') }}" title="@lang('labels.nav.faq')"
       class="{{ request()->url() === route('faq.index') ? 'active' : '' }}">
       <span class="panelIcon faq"></span>
        <span class="menu-text">@lang('labels.nav.faq')</span>
    </a>
</li>

<li>
    <a href="{{ route('agreement.show') }}" title="@lang('labels.nav.agreement')"
       class="{{ request()->url() === route('agreement.show') ? 'active' : '' }}">
       <span class="panelIcon agreement"></span>
        <span class="menu-text">@lang('labels.nav.agreement')</span>
    </a>
</li>

<li>
    <a href="{{ route('users::event') }}" title="@lang('labels.nav.participants')"
       class="{{ request()->url() === route('users::event') ? 'active' : '' }}">
        <i class="icons8-users"></i>
        <span class="menu-text">@lang('labels.nav.participants')</span>
    </a>
</li>


