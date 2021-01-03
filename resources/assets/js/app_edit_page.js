import Noty from 'noty';

require('select2/dist/js/select2.min');

Noty.overrideDefaults({
    layout: 'topRight',
    theme: 'metroui',
    closeWith: ['click', 'button'],
    progressBar: true,
    animation: {
        open: 'noty_effects_open',
        close: 'noty_effects_close',
        container: false
    }
});

$(document).ready(() => {
    let package_name_group = $('.form-group__package_name');
    let package_name_input = $('#package_name');
    let find_app_button = $('#find_app');
    let application_preview = $('.application_preview');
    let device_type = 'android';

    $('.platforms-item').click(function () {
        $('.platforms-item').removeClass('active');
        
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
         } 

        if ($(this).hasClass('platforms-item__android')) {
            device_type = 'android';
            package_name_group.slideDown(100);
        }

        

        if ($(this).hasClass('platforms-item__ios')) {
            device_type = 'ios';
            package_name_group.slideDown(100);
        }
        $('#device_type').val(device_type);
        package_name_input.focus();
    });

    package_name_input.keypress(function (event) {
        let key = event.which;
        // "Enter" key code
        if (key === 13) {
            if (event.target.value !== '') {
                $('#find_app').trigger('click');
                return false;
            }
            return false;
        }
    });

    find_app_button.click(function () {
        find_app_button.prop('disabled', true);
        find_app_button.html(find_app_button.html() + '<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        let package_name = package_name_input.val();
        if (package_name.length > 0) {
            switch (device_type) {
                case 'android':
                    $.get("/apps/android-info?query=" + package_name, ({app}) => {
                        application_preview.slideDown();
                        // Preview block
                        $('#app_name').html(app.title);
                        $('#package_name_preview').html(app.id);
                        $('#application_logo').attr('src', app.image);
                        // Form inputs
                        $('input[name=title]').val(app.title);
                        $('input[name=image_url]').val(app.image);
                    })
                        .fail(error => {
                            new Noty({
                                type: 'warning',
                                timeout: 4000,
                                text: error.responseJSON.message,
                            }).show();
                        })
                        .always(() => {
                            find_app_button.prop('disabled', false);
                            $('.fa-spinner').remove();
                        });
                    break;
                case 'ios':
                    break;
            }
        }
        else {
            package_name_input.addClass('danger');
        }
    });
});

let country_group_select = $('#country_group');
let country_select = $('#country');
let city_select = $('#city');
country_group_select.select2({width: '100%'});
country_select.select2({width: '100%'});
city_select.select2({width: '100%'});
$('#time_delay').select2({minimumResultsForSearch: Infinity});
$('#duration').select2();
$('#user_id').select2();

if (country_group_select.val()) {
    loadParams();
}


/**
 * Update country input depend on selected country group
 */
function updateCountryInput() {
    let group = country_group_select.val();
    let countries = country_group_select.data('groups')[group];
    country_select.empty();
    city_select.empty();
    $.each(countries, function (countryId, countryName) {
        country_select.append($("<option></option>")
            .attr("value", countryId).text(countryName));
    });

    loadParams();
}

/**
 * Update city input depend on selected country
 */
function updateCityInput() {
    let group = country_group_select.val();
    let countryId = country_select.val();
    city_select.empty();
    if (parseInt(countryId) !== 0) {
        // get all cities for selected country
        $.get(`/country/${countryId}/${group}/cities`, data => {
            $.each(data, function (value, key) {
                city_select.append($("<option></option>")
                    .attr("value", value).text(key));
            });
        });
    }
}

/**
 * Country Groups input change event.
 * Load countries list on change.
 */
country_group_select.change(() => {
    updateCountryInput();
});

/**
 * Country input change event.
 * Load cities list on change.
 */
country_select.change(() => {
    updateCityInput();
});

let time_delay_select = $('#time_delay');

city_select.change(({target}) => {
    if (target.value) {
        $('#geo-promotion').val(1);
    } else {
        $('#geo-promotion').val(0);
    }
});



$('body').on('change', '#time_delay', function() {
    loadParamsAfter();
});

let body = $('body');

body.on('click', '.btn-cancel-task', function () {
    let id = $(this).data('id');
    let amount = $(this).data('amount') ? parseFloat($(this).data('amount')) : 0;
    let container = $(this).parent().parent().parent().parent(); // Get whole .form-item div
    let lang = $('#toggle_select_lang').data('lang');
    let message = 'Funds will back on Your balance ';
    if (lang === 'ru') {
        message = 'Средства будут возвращены на Ваш баланс ';
    }
    let old_balance = parseFloat($('#balance-value').html());
    let new_balance = amount + old_balance;
    bootbox.confirm(message + amount,
        function (result) {
            if (result) {
                $.ajax({
                    url: '/apps/cancel/' + id,
                    method: 'POST',
                    success: function (response) {
                        container.siblings('hr').remove();
                        container.remove();
                        new Noty({
                            type: 'success',
                            timeout: 5000,
                            text: response.message,
                        }).show();
                        $('#balance-value').html(new_balance.toFixed(2));
                    },
                    error: function (error) {
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

body.on('click', '.moderate-app', function () {
    let self = $(this);
    const id = self.data('id');
    const reason = self.data('reason');
    $('.moderate-app').prop('disabled', true);
    self.html(self.html() + '<i class="fa fa-spinner fa-pulse fa-fw"></i>');

    $.ajax({
        url: '/apps/moderating/',
        method: 'PUT',
        data: {
            id: id,
            reason: reason
        },
        success: () => {
            $('.moderate-app').closest('.panel').slideUp(200); // Remove whole parent element
            let moderatingAppsLabel = $('#moderating_apps');
            let old_val = parseInt(moderatingAppsLabel.html());
            if (old_val > 1) {
                moderatingAppsLabel.html(old_val - 1);
            } else {
                moderatingAppsLabel.remove();
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
            $('.moderate-app').prop('disabled', false);
            $('.fa-spinner').remove();
        }
    });
});

$('.pay-from-balance').click(function () {
    let self = $(this);
    self.prop('disabled', true);
    self.html(self.html() + '<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    const route = $(this).data('route');

    $.ajax({
        url: route,
        type: 'POST',
        complete: function (response) {
            self.prop('disabled', false);
            $('.fa-spinner').remove();
            if (response.responseJSON && response.responseJSON.hasOwnProperty('url')) {
                window.location.replace(response.responseJSON.url);
            } else {
                window.location.replace(window.location.origin);
            }
        }
    });
});

$('.refresh-app').click(({target}) => {
    let self = $(target);
    self.addClass('fa-spin');

    let package_name = application.package_name; // Application variable involved at view file via PHP
    let package_country = $( "#country option:selected" ).text();
    if (package_name.length > 0 && package_country.length > 0) {
        switch (application.device_type) {
            case 'android':
                $.get("/apps/android-info?query=" + package_name + "&lang=" + package_country + "&country=" + package_country, ({app}) => {
                    $('.title').html(app.title);
                    $('div.image img').attr('src', app.image);
                    // Form inputs
                    $('input[name=name]').val(app.title);
                    $('input[name=image]').val(app.image);
                })
                    .fail(error => {
                        new Noty({
                            type: 'warning',
                            timeout: 4000,
                            text: error.responseJSON.message,
                        }).show();
                    })
                    .always(() => {
                        self.removeClass('fa-spin');
                    });
                break;
            case 'ios':
                break;
        }
    }
});

$('#country').on('change', function(){
    let package_name = application.package_name; // Application variable involved at view file via PHP
    let package_country = $( "#country option:selected" ).text();
    if (package_name.length > 0 && package_country.length > 0) {
        switch (application.device_type) {
            case 'android':
                $.get("/apps/android-info?query=" + package_name + "&lang=" + package_country + "&country=" + package_country, ({app}) => {
                    $('.title').html(app.title);
                    $('div.image img').attr('src', app.image);
                    // Form inputs
                    $('input[name=name]').val(app.title);
                    $('input[name=image]').val(app.image);
                })
                    .fail(error => {
                        new Noty({
                            type: 'warning',
                            timeout: 4000,
                            text: error.responseJSON.message,
                        }).show();
                    })
                    .always(() => {
                        self.removeClass('fa-spin');
                    });
                break;
            case 'ios':
                break;
        }
    }
});

function loadParams() {
    let group = country_group_select.val();
    let customParams = $('.custom-params');
    customParams.addClass('is-loading');
    let appId = getAppIdFromUrl();
    $('.custom-params-wrapper').html('');
    // Depending on selected load custom parameters HTML
    $.get(`/apps/edit/${appId}/load?group=${group}`, html => {
        customParams.removeClass('is-loading');
        $('.custom-params-wrapper').html(html);

        if ($('#time_delay').val()) {
            loadParamsAfter();
        }
    });
}

function loadParamsAfter() {
    let group = country_group_select.val();
    let time_delay = $('#time_delay').val();
    let customParams = $('.custom-params');
    customParams.addClass('is-loading');
    let appId = getAppIdFromUrl();
    $('.custom-params-wrapper').html('');
    // Depending on selected load custom parameters HTML
    $.get(`/apps/edit/${appId}/load/after?group=${group}&time_delay=${time_delay}`, html => {
        customParams.removeClass('is-loading');
        $('.custom-params-wrapper').html(html);
    });
}

function getAppIdFromUrl() {
    const url = window.location.href;
    const i = url.lastIndexOf('/');
    return url.substring(i + 1);
}