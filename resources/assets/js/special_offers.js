import Noty from 'noty';

$('.add-feature').click(({target}) => {
    let self = $(target);
    self.before(special_offer_feature);
});

$('.feature-delete').click(({target}) => {
    let self = $(target);
    let parent = self.parent();
    do {
        parent = parent.parent();
    } while (!parent.hasClass('row'));
    parent.remove(); // Remove whole input group
});

$('.delete-offer').click(event => {
    event.preventDefault();
    let self = $(event.target);
    let route = self.attr('href');
    if (!route) {
        route = self.parent().attr('href');
    }
    let parent = self.parent();
    do {
        parent = parent.parent();
    } while (!parent.hasClass('offer'));
    let lang = $('#toggle_select_lang').data('lang');
    let message = 'Delete this special offer?';
    if (lang === 'ru') {
        message = 'Удалить это специальное предложение?';
    }
    bootbox.confirm(message,
        result => {
            if (result) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    success: () => {
                        parent.fadeOut(200);
                    },
                    error: error => {
                        new Noty({
                            type: 'warning',
                            timeout: 4000,
                            text: error.responseJSON.message,
                        }).show();
                    }
                });
            }
        });
});

$('form[name=special-offer]').submit(event => {
    event.preventDefault();

    let form = $(event.target);
    let offer_id = form.data('id');
    let search_query = form.find('input[name=query]').val();
    let package_name = form.find('input[name=package_name]').val();
    let amount = form.find('input[name=amount]').val();

    let modal = $('#buyModal');

    modal.find('input[name=ik_x_special_offer_id]').val(offer_id);
    modal.find('input[name=ik_x_search_query]').val(search_query);
    modal.find('input[name=ik_x_package_name]').val(package_name);
    modal.find('input[name=ik_am]').val(amount);

    modal.find('form[name=pay-from-balance]').find('input[name=id]').val(offer_id);
    modal.find('form[name=pay-from-balance]').find('input[name=search_query]').val(search_query);
    modal.find('form[name=pay-from-balance]').find('input[name=package_name]').val(package_name);

    modal.modal('show');
});

const special_offer_feature = '<div class="row">' +
    '<div class="col-xs-11">' +
    '<input name="features[]" class="form-control mb20"/>' +
    '</div>' +
    '<div class="col-xs-1 feature-delete-wrapper ">' +
    '<button title="Delete" type="button" class="feature-delete icon-button">' +
    '<i class="icons8-delete"></i>' +
    '</button>' +
    '</div>' +
    '</div>';