<div class="row">
    <div class="col-md-6">
        <div class="stats">
            <div class="stats-item"><span>@lang('labels.users_amount'): </span><span>{{ $stats['users_count'] }}</span></div>
            <div class="stats-item"><span>@lang('labels.total_earned'): </span><span>{{ $stats['users_earned'] }}</span></div>
            <div class="stats-item"><span>@lang('labels.earned_by_tasks'): </span><span>{{ $stats['task_earned'] }}</span></div>
            <div class="stats-item"><span>@lang('labels.earned_by_videos'): </span><span>{{ $stats['video_earned'] }}</span></div>
            <div class="stats-item"><span>@lang('labels.earned_by_partners'): </span><span>{{ $stats['partner_earned'] }}</span></div>
            <div class="stats-item"><span>@lang('labels.earned_by_referals'): </span><span>{{ $stats['referral_earned'] }}</span></div>
        </div>
    </div>
</div>