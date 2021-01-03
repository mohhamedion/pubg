@if($reviews->count())
    @foreach($reviews as $review)
        <div class="task-review">
            <div class="task-review_title">
                <h5>{{ $review->title }}</h5>
            </div>
            <div class="task-review_image">
                <a href="{{ $review->screenshot_url }}" target="_blank" class="block-link">
                    <img src="{{ $review->screenshot_url }}"/>
                </a>
            </div>
            <div class="task-review_user">
                <a href="{{ route('users::show::index', $review->user) }}">
                    {{ $review->user->device_token }}
                </a>
            </div>
            <div class="task-review_moderate">
                <button class="button btn-primary moderate-review" data-id="{{ $review->id }}"
                        data-reason="true">
                    @lang('labels.buttons.moderate_accept')
                </button>
                <button class="button btn-danger moderate-review" data-id="{{ $review->id }}"
                        data-reason="false">
                    @lang('labels.buttons.moderate_decline')
                </button>
            </div>
        </div>
    @endforeach
@endif