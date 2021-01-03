import Noty from 'noty';

$('document').ready(() => {
    let date_from = $('input[name=date_from].roulette-date  ');
    let date_to = $('input[name=date_to].roulette-date  ');

    date_from.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});
    date_to.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});

    date_from.on('changeDate', () => {
        updateRouletteStatsTable(date_from.val(), date_to.val());
    });

    date_to.on('changeDate', () => {
        updateRouletteStatsTable(date_from.val(), date_to.val());
    });
});

function updateRouletteStatsTable(date_from, date_to) {
    const route = '/roulette/stats';
    $.ajax({
        url: route,
        data: {
            date_from: date_from,
            date_to: date_to,
        },
        success: html => {
            $('#roulette-stats').html(html);
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