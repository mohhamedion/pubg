require('./libs/bootstrap-datepicker');
require('./libs/bootstrap-datetimepicker.min');

$(document).ready(() => {
    let date_from = $('input[name=date_from]');
    let date_to = $('input[name=date_to]');

    date_from.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});
    date_to.datepicker({format: 'dd-mm-yyyy', todayHighlight: true});

    date_from.on('changeDate', () => {
        date_to.datepicker('setStartDate', date_from.val());
    });

    date_to.on('changeDate', () => {
        date_from.datepicker('setEndDate', date_to.val());
    });

    $('#datetimepicker').datetimepicker();

});

