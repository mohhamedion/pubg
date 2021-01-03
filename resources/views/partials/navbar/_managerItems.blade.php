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
    <a href="{{ route('account::balance') }}" title="@lang('labels.nav.balance')"
       class="{{ request()->url() === route('account::balance') ? 'active' : '' }}">
        <i class="icons8-dollar"></i>
        <span class="menu-text">@lang('labels.nav.balance')</span>
    </a>
</li>

<li>
    <a href="{{ route('special_offers::index') }}" title="@lang('labels.nav.special_offers')"
       class="spec_offer_menu_item {{ request()->url() === route('special_offers::index') ? 'active' : '' }}">
       <span class="panelIcon special_offers"></span>
        <span class="menu-text">@lang('labels.nav.special_offers')</span>
    </a>
</li>

{{--<li>
    <a href="{{ route('service::index', 'top') }}" title="@lang('labels.nav.to_top2')"
       class="{{ request()->url() === route('service::index', 'top') ? 'active' : '' }}">
        <i class="icons8-rocket-top"></i>
        <span class="menu-text">@lang('labels.nav.to_top2')</span>
    </a>
</li>--}}

<li>
    <a href="{{ route('service::index', 'aso') }}" title="@lang('labels.nav.aso_opt')"
       class="{{ request()->url() === route('service::index', 'aso') ? 'active' : '' }}">
       <span class="panelIcon aso"></span>
        <span class="menu-text">@lang('labels.nav.aso_opt')</span>
    </a>
</li>

<li>
    <a href="{{ route('service::index', 'comments') }}" title="@lang('labels.nav.testimonials')"
       class="{{ request()->url() === route('service::index', 'comments') ? 'active' : '' }}">
       <span class="panelIcon comment"></span>
        <span class="menu-text">@lang('labels.nav.testimonials')</span>
    </a>
</li>

<li>
    <a href="{{ route('news.index') }}" title="@lang('labels.nav.news')"
       class="{{ request()->url() === route('news.index') ? 'active' : '' }}">
       <span class="panelIcon news"></span>
        <span class="menu-text">@lang('labels.nav.news')
            @if($unread_articles)
                <span class="menu-badge danger" id="comments_count">{{ $unread_articles }}</span>
            @endif
        </span>
    </a>
</li>


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