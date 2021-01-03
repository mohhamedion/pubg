import Noty from 'noty';

$('.payment-system-switch').on('change', function (event) {
    event.preventDefault();

    let saving_popup = new Noty({
        type: 'info',
        text: '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Saving',
    }).show();

    let self = $(this);
    let parent = self.closest('.payment-system');
    let id = $(this).data('id');
    let checked = self.prop('checked');

    self.prop('checked', !checked);

    $.ajax({
        url: location.href,
        method: 'patch',
        data: {
            id: id,
            state: checked,
        },
        success: response => {
            new Noty({
                type: 'success',
                timeout: 4000,
                text: response.message,
            }).show();

            self.prop('checked', checked);

            if (checked) {
                parent.removeClass('non-active');
            } else {
                parent.addClass('non-active');
            }
        },
        error: () => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        },
        complete: () => {
            saving_popup.close();
        }
    });
});

$('.system-top').on('change', function({target}){
    let id = $( target ).val();
    let route = "/payment-systems/" + id + "/top";
    $.ajax({
        url: route,
        type: 'GET',
        complete: function (response) {
        }
    });
});

$('.system-active').on('change', function({target}){
    let id = $( target ).val();
    let route = "/payment-systems/" + id + "/active";
    $.ajax({
        url: route,
        type: 'GET',
        complete: function (response) {
        }
    });
});
