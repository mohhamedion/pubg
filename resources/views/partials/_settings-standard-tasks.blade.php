<!--- Award for Video Task Field --->
{{--<div class="form-group">
    {!! Form::label('award_standard_task_video', trans('labels.award_standard_task_video') . ', ' . $currency, '') !!}
    {!! Form::input('text', 'award_standard_task_video', null, ['class' => 'form-control', 'required']) !!}
</div>

<!--- Award for Vk Group Task Field --->
<div class="form-group">
    {!! Form::label('award_standard_task_vk_group', trans('labels.award_standard_task_vk_group') . ', ' . $currency, '') !!}
    {!! Form::input('text', 'award_standard_task_vk_group', null, ['class' => 'form-control', 'required']) !!}
</div>--}}

<div class="form-group">
    {!! Form::label('review_min_task_run_limit', trans('labels.review_min_task_run_limit')) !!}
    {!! Form::number('review_min_task_run_limit', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('review_price', trans('labels.award_review') . ', ' . $currency, '') !!}
    {!! Form::input('text', 'review_price', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('review_comment_price', trans('labels.award_comment') . ', ' . $currency, '') !!}
    {!! Form::input('text', 'review_comment_price', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('review_keywords', trans('labels.review_keywords')) !!}
    <select name="review_keywords[]" class="form-control" id="review_keywords"
            title="@lang('labels.review_keywords')" multiple
            style="width: 100%">
        @if($settings->review_keywords)
            @foreach($settings->review_keywords as $keyword)
                <option value="{{ $keyword }}" selected>{{ $keyword }}</option>
            @endforeach
        @endif
    </select>
</div>