import Noty from 'noty';

$(document).ready(() => {
    let date_from = $('input[name=date_from].app-chart ');
    let date_to = $('input[name=date_to].app-chart ');

    date_from.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});
    date_to.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});

    date_from.on('changeDate', () => {
        date_to.datepicker('setStartDate', date_from.val());
        updateChart({
            date_from: date_from.val(),
            date_to: date_to.val(),
            app_id: date_from.data('id'),
        });
    });

    date_to.on('changeDate', () => {
        date_from.datepicker('setEndDate', date_to.val());
        updateChart({
            date_from: date_from.val(),
            date_to: date_to.val(),
            app_id: date_to.data('id'),
        });
    });
});

function updateChart(params) {
    const route = '/apps/data/chart';

    $.ajax({
        url: route,
        data: params,
        success: chart => {
            $('#app_chart').html(chart);
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

$('#changes_history').click(function (event) {
    event.preventDefault();
    let button = $(this);
    let buttons = $('.panel-buttons');
    let content = $('.content');

    if (!content.has('#history').length) {
        buttons.after('<div class="panel changes-history" id="history"></div>')
    }

    let history = $('#history');
    history.html(loader());

    let route = button.attr('href');
    $.ajax({
        url: route,
        type: 'GET',
        success: html => {
            history.html(html);
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

function loader() {
    return '<div class="loader">' +
        '<svg class="circular" viewBox="25 25 50 50">' +
        '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>' +
        '</svg>' +
        '</div>';
}