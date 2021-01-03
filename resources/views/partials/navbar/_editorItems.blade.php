<li>
    <a href="{{ route('home') }}" title="@lang('labels.nav.home')"
       class="{{ request()->url() === route('home') ? 'active' : '' }}">
        <i class="icons8-home"></i>
        <span class="menu-text">@lang('labels.nav.home')</span>
    </a>
</li>

<li>
    <a href="{{ route('apps::index') }}" title="@lang('labels.nav.campaigns')"
       class="{{ request()->url() === route('apps::index') ? 'active' : '' }}">
        <i class="icons8-target"></i>
        <span class="menu-text">@lang('labels.publish_ready')</span>
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
    <a href="{{ route('reviews_moderate') }}" title="@lang('labels.moderating_reviews.users')"
       class="{{ request()->url() === route('reviews_moderate') ? 'active' : '' }}">
        <i class="fa fa-comment-o"></i>
        <span class="menu-text">@lang('labels.moderating_reviews')
            @if($moderating_reviews)
                <span class="menu-badge danger" style="top: -8px" id="moderating_reviews">{{ $moderating_reviews }}</span>
            @endif
        </span>
    </a>
</li>
