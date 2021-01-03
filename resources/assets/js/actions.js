import Noty from 'noty';

let body = $('body');

body.on('click', '.btn-task-status', function () {
    const id = $(this).data('id');
    const self = $(this);

    if (self.hasClass('is-loading')) {
        return false;
    }

    let child = self.find('i');
    self.addClass('is-loading');
    //child[0].className = 'fa fa-spinner fa-spin fa-fw';

    $.ajax({
        url: route,
        type: 'POST',
        data: {
            id: id
        },
        success: () => {
            table.bootstrapTable('refresh');
        },
        error: error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        },
        complete: function () {
            child[0].className = 'icons8-play';
            self.removeClass('is-loading');
        }
    });
});

$('#sendPushNotification').click(({target}) => {
    let self = $(target);
    const url = self.data('url');
    let message = $('#pushMessage').val();
    let button_text = self.html();
    self.html('<i class="fa fa-spinner fa-pulse fa-fw"></i> ' + button_text);
    $.post(
        url,
        {message: message},
        response => {
            new Noty({
                type: 'success',
                timeout: 4400,
                text: response,
            }).show();
            self.html(button_text);
            $('#sendPushNotificationModal').modal('hide');
        })
        .fail(error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        });
});

$('#sendAppPushNotification').click(({target}) => {
    let self = $(target);
    const url = self.data('url');
    let message = $('#pushMessage').val();
    let id = self.data('id');
    let button_text = self.html();
    self.html('<i class="fa fa-spinner fa-pulse fa-fw"></i> ' + button_text);
    $.post(
        url,
        {
            message: message,
            id: id
        },
        response => {
            new Noty({
                type: 'success',
                timeout: 4400,
                text: response,
            }).show();
            self.html(button_text);
            $('#sendPushNotificationModal').modal('hide');
        })
        .fail(error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        });
});

// Service requests (Admin)
$('.request-delete').click(function (event) {
    event.preventDefault();

    let self = $(this);
    const route = self.attr('href');

    $.ajax({
        url: route,
        type: 'DELETE',
        statusCode: {
            201: () => {
                self.parent().parent().parent().remove();

                const pathArray = window.location.pathname.split('/');
                const segment_1 = pathArray[1];
                let counter;
                switch (segment_1) {
                    case 'top':
                        counter = $('#top_count');
                        break;
                    case 'aso':
                        counter = $('#aso_count');
                        break;
                    case 'comments':
                        counter = $('#comments_count');
                        break;
                    case 'special-offers':
                        counter = $('#special_offers');
                        break;
                }
                let prevCount = parseInt(counter.html());
                if (prevCount === 1) {
                    counter.remove();
                } else {
                    counter.html(prevCount - 1);
                }
            }
        },
        error: error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.error,
            }).show();
        }
    });
});

// Faq delete (Admin)
$('.faq-delete').click(function (event) {
    event.preventDefault();

    let self = $(this);
    const route = self.attr('href');

    $.ajax({
        url: route,
        type: 'DELETE',
        statusCode: {
            201: () => {
                self.parent().parent().remove();
            }
        },
        error: error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.error,
            }).show();
        }
    });
});

/** ADMIN HOME PAGE CHARTS */

$(document).ready(() => {
    $('input[name=date_from][data-chart]').each(function (index, input) {
        let date_to = $(input).siblings('input[name=date_to]');
        date_to.datepicker('setStartDate', input.value);
    });

    $('input[name=date_to][data-chart]').each(function (index, input) {
        let date_from = $(input).siblings('input[name=date_from]');
        date_from.datepicker('setEndDate', input.value);
    });

    /** ASYNC LOAD OF CHARTS AFTER PAGE DISPLAYING */
    let usersTasksChartDiv = $('#users_task_chart');
    if (usersTasksChartDiv.length) {
        const route = usersTasksChartDiv.data('route');
        updateChart(usersTasksChartDiv, route, '', '');
    }

    let registerChartDiv = $('#register_chart');
    if (registerChartDiv.length) {
        const route = registerChartDiv.data('route');
        updateChart(registerChartDiv, route, '', '');
    }

    let awardsChartDiv = $('#awards_chart');
    if (awardsChartDiv.length) {
        const route = awardsChartDiv.data('route');
        updateChart(awardsChartDiv, route, '', '');
    }

    let earnedChartDiv = $('#earned_chart');
    if (earnedChartDiv.length) {
        const route = earnedChartDiv.data('route');
        updateChart(earnedChartDiv, route, '', '');
    }

    let transactionsChartDiv = $('#transactions_chart');
    if (transactionsChartDiv.length) {
        const route = transactionsChartDiv.data('route');
        updateChart(transactionsChartDiv, route, '', '');
    }

    let transactionsAmountChartDiv = $('#transactions_amount_chart');
    if (transactionsAmountChartDiv.length) {
        const route = transactionsAmountChartDiv.data('route');
        updateChart(transactionsAmountChartDiv, route, '', '');
    }

    let locationsChartDiv = $('#locations_chart');
    if (locationsChartDiv.length) {
        const route = locationsChartDiv.data('route');
        updateChart(locationsChartDiv, route, '', '');
    }

    let locationsPieChartDiv = $('#locations_pie_chart');
    if (locationsPieChartDiv.length) {
        const route = locationsPieChartDiv.data('route');
        updateChart(locationsPieChartDiv, route, '', '');
    }
});

$('input[name=date_from]').change(function () {
    let input = $(this);
    const route = input.data('route');
    let chart_id = input.data('chart');
    if (chart_id) {
        let chart = $(`#${chart_id}`);
        let date_to = input.siblings('input[name=date_to]');
        date_to.datepicker('setStartDate', input.val());

        updateChart(chart, route, input.val(), date_to.val());
    }
});

$('input[name=date_to]').change(function () {
    let input = $(this);
    const route = input.data('route');
    let chart_id = input.data('chart');
    if (chart_id) {
        let chart = $(`#${chart_id}`);
        let date_from = input.siblings('input[name=date_from]');
        date_from.datepicker('setEndDate', input.val());

        updateChart(chart, route, date_from.val(), input.val());
    }
});

function updateChart(chart, route, date_from, date_to) {
    chart.html(loader());
    $.ajax({
        url: route,
        data: {
            date_from: date_from,
            date_to: date_to
        },
        success: html => {
            chart.html(html);
        },
        error: error => {
            console.log(error);
            chart.html(showError());
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        }
    });
}

function loader() {
    return '<div class="chart-load-wrapper">' + '<div class="loader">' +
        '<svg class="circular" viewBox="25 25 50 50">' +
        '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>' +
        '</svg>' +
        '</div>' + '</div>';
}

function showError() {
    return '<div class="chart-error-wrapper">' +
        '<h2>Error!</h2>' +
        '<h3>Something went wrong</h3>' +
        '</div>';
}

/*_________________________*/

body.on('click', '.delete-user', function () {
    let route = '/users/edit/' + $(this).data('id');
    $.ajax({
        url: route,
        type: 'DELETE',
        success: () => {
            table.bootstrapTable('refresh');
        },
        error: error => {
            new Noty({
                type: 'warning',
                timeout: 4000,
                text: error.responseJSON.message,
            }).show();
        }
    })
});

/**
 * Article images page
 */
$('.btn-copy').click(function () {
    var input = $(this).siblings('input');
    input.select();
    document.execCommand("Copy");
    new Noty({
        type: 'info',
        timeout: 2000,
        text: 'Link copied to clipboard.',
    }).show();
});

$('.btn-delete').click(function () {
    var self = $(this);
    var url = $(this).data('url');
    self.prop('disabled', true);
    self.siblings('button').prop('disabled', true);
    $.ajax({
        url: url,
        type: 'DELETE',
        statusCode: {
            204: function () {
                self.parent().parent().parent().remove();
            },
            404: function () {
                new Noty({
                    type: 'warning',
                    timeout: 4000,
                    text: 'Image not found.',
                }).show();
                self.prop('disabled', false);
                self.siblings('button').prop('disabled', false);
            },
            500: function () {
                new Noty({
                    type: 'danger',
                    timeout: 4000,
                    text: 'Can not delete image.',
                }).show();
                self.prop('disabled', false);
                self.siblings('button').prop('disabled', false);
            }
        }
    })
});

$('body').on('click', '#closeSystemNotification', function () {
    $('.notification-wrapper').slideUp(200);
    $('.content').removeClass('has-notification');
    $('.header').removeClass('has-notification');
    $('.nav').removeClass('has-notification');
    $.get('system-notification');
});