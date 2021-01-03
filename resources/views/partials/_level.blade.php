<div class="row mb20">
    <div class="col-md-6">
        <div class="form-group">
            <label for="launch_bonus">@lang('labels.levels.launch_bonus')</label>
            <input type="number" class="form-control" name="task_{{ $level->level }}" value="{{ $level->task }}" step="0.01">
        </div>

        <div class="form-group">
            <label for="video_bonus">@lang('labels.levels.video_bonus')</label>
            <input type="number" class="form-control" name="video_{{ $level->level }}" value="{{ $level->video }}" step="0.01">
        </div>

        <div class="form-group">
            <label for="partner_bonus">@lang('labels.levels.partner_bonus')</label>
            <input type="number" class="form-control" name="partner_{{ $level->level }}" value="{{ $level->partner }}" step="0.01">
        </div>

        <div class="form-group">
            <label for="referral_bonus">@lang('labels.levels.referral_bonus')</label>
            <input type="number" class="form-control" name="referral_{{ $level->level }}" value="{{ $level->referral }}" step="0.01">
        </div>
    </div>
</div>