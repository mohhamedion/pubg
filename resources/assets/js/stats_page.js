$(document).ready(function () {
    let wrapper = $('#data-wrapper');
    if (wrapper.length) {
        let date_from_input = $('input[name=date_from]');
        let date_to_input = $('input[name=date_to]');
        let promocodes_select = $('select[name=promocodes]');

        let date_from_query_value = getQueryStringValue('date_from');
        let date_to_query_value = getQueryStringValue('date_to');
        let promocodes_value = getQueryStringValue('promocodes');

        if (date_from_query_value && date_from_query_value.length) {
            date_from_input.val(date_from_query_value);
        }
        if (date_to_query_value && date_to_query_value.length) {
            date_to_input.val(date_to_query_value);
        }
        if (promocodes_value && promocodes_value.length) {
            promocodes_select.val(promocodes_value).change();
        }

        promocodes_select.change(function () {
            let date_from = date_from_input.val();
            let date_to = date_to_input.val();
            let promocodes = promocodes_select.val();
            let pathname = window.location.href.split('?')[0];
            history.pushState(null, null, pathname + '?date_from=' + date_from + '&date_to=' + date_to + '&promocodes=' + promocodes);
            getStatisticsData(wrapper);
        });

        date_from_input.on('changeDate', () => {
            let date_from = date_from_input.val();
            let date_to = date_to_input.val();
            let promocodes = promocodes_select.val();
            let pathname = window.location.href.split('?')[0];
            history.pushState(null, null, pathname + '?date_from=' + date_from + '&date_to=' + date_to + '&promocodes=' + promocodes);
            getStatisticsData(wrapper);
        });

        date_to_input.on('changeDate', () => {
            let date_from = date_from_input.val();
            let date_to = date_to_input.val();
            let promocodes = promocodes_select.val();
            let pathname = window.location.href.split('?')[0];
            history.pushState(null, null, pathname + '?date_from=' + date_from + '&date_to=' + date_to + '&promocodes=' + promocodes);
            getStatisticsData(wrapper);
        });

        getStatisticsData(wrapper);
    }
});

function getStatisticsData(wrapper) {
    if (wrapper.length) {
        wrapper.html(loader());
        const route = wrapper.data('route');
        $.get({
            url: route,
            data: {
                date_from: getQueryStringValue('date_from'),
                date_to: getQueryStringValue('date_to'),
                promocodes: getQueryStringValue('promocodes'),
            },
            success: function (response) {
                wrapper.html(response);
            }
        });
    }
}

function loader() {
    return '<div class="loader">' +
        '<svg class="circular" viewBox="25 25 50 50">' +
        '<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>' +
        '</svg>' +
        '</div>';
}

function getQueryStringValue(key) {
    return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[.+*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
}