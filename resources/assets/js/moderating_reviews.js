$('.task-review-app-title').click(function () {
    let self = $(this);
    const id = $(this).data('id');
    let route = id ? `/${id}/reviews` : '/reviews';
    let items_wrapper = self.parent().siblings($('.task-review-items'));

    self.toggleClass('active');

    if (self.hasClass('active')) {
        items_wrapper.html(loader());
        items_wrapper.slideDown(200);

        setTimeout(function () {
            $.ajax({
                url: route,
                method: 'GET',
                success: html => {
                    items_wrapper.html(html);
                }
            });
        }, 500);
    } else {
        items_wrapper.html('');
        items_wrapper.slideUp(200);
    }
});

function loader() {
    return '<div class="loader">' +
        '<svg class="circular" viewBox="25 25 50 50">' +
        '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>' +
        '</svg>' +
        '</div>';
}

$('body').on('click', '.moderate-review', function () {
    let self = $(this);
    const id = self.data('id');
    const reason = self.data('reason');
    let badge = self.parent().parent().parent().siblings($('.title-line')).find($('.task-review-app-title')).find($('.badge'));
    let old_badge_val = parseInt(badge.html());

    $('.moderate-review').prop('disabled', true);
    self.html(self.html() + '<i class="fa fa-spinner fa-pulse fa-fw"></i>');

    let moderating_reviews_badge = $('#moderating_reviews');
    let old_val = parseInt(moderating_reviews_badge.html());

    $.ajax({
        url: '/reviews/moderate',
        type: 'POST',
        data: {
            id: id,
            reason: reason
        },
        success: () => {
            $(this).closest('.task-review').hide(); // Remove whole parent element

            let new_val = old_val - 1;
            if (new_val < 1) {
                moderating_reviews_badge.remove();
            } else {
                moderating_reviews_badge.html(new_val);
            }

            let new_badge_val = old_badge_val - 1;
            if (new_badge_val < 1) {
                badge.remove();
            } else {
                badge.html(new_badge_val);
            }
        },
        error: error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        },
        complete: () => {
            $('.moderate-review').prop('disabled', false);
            $('.fa-spinner').remove();
        }
    });
});
