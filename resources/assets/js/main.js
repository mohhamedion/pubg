/**
 * Query params function for server side pagination
 *
 * @param params
 * @returns {{limit: *, offset: *, search: *}}
 */
function queryParams(params) {
    var toolbar = $('#toolbar');
    params.status = toolbar.find('select[name=status]').val();
    params.search = toolbar.find('input[name=search]').val();
    params.promocode = toolbar.find('input[name=promocode]').val();
    params.promocodes = toolbar.find('select[name=promocodes]').val();
    params.role = toolbar.find('select[name=role]').val();
    params.date_from = $('input[name=date_from]').val();
    params.date_to = $('input[name=date_to]').val();
    params.manager_id = $('select[name=manager]').val();

    return {
        limit: params.limit,
        offset: params.offset,
        sort: params.sort,
        order: params.order,
        search: params.search,
        promocode: params.promocode,
        promocodes: params.promocodes,
        status: params.status,
        role: params.role,
        date_from: params.date_from,
        date_to: params.date_to,
        manager_id: params.manager_id,
    };
}

/**
 * table - variable to contain table
 * route - named of route which have to be prepended to links (for edit / delete / update actions)
 */
var table, route, identifier, app_image, package_name, a_class, span_class, status, appDone, role, locale, currency;

/**
 * Document ready event
 * get table id split it and store in route variable
 * needed for links in formatter
 */
$(document).ready(function () {
    table = $('.table-responsive').find('table.table.table-hover');
    route = table.attr('data-route');
    role = table.attr('data-role');
    locale = table.attr('data-locale') === 'ru-RU' ? 'ru' : 'en';
    currency = table.attr('data-currency');
    var select_status = $('select[name=status]');
    var select_role = $('select[name=role]');
    var select_manager = $('select[name=manager]');
    var select_promocodes = $('select[name=promocodes]');

    if (select_status.attr('id') === 'status') {
        select_status.select2({width: '100%'});
    } else {
        select_status.select2({search: false, minimumResultsForSearch: -1});
    }

    select_status.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_role.select2({search: false, minimumResultsForSearch: -1});
    select_role.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_manager.select2();
    select_manager.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=search]').on('keyup', function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=promocode]').on('keyup', function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_promocodes.select2();
    select_promocodes.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=date_from]').change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=date_to]').change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });
});


function ids(value) {
    return identifier = value;
}

function packages(value) {
    return package_name = value;
}

function statuses_hidden(value) {
    return status = value;
}

function image(value) {
    return app_image = value;
}

function app_names(value, row) {
    var image = row.image;

    if (row.hasOwnProperty('app') && !row.app) {
        return '-';
    }

    if (!image && row.app) {
        // In case if row is Task
        if (row.app.hasOwnProperty('image')) {
            image = row.app.image;
        }
    }

    var app_id = row.application_id ? row.application_id : row.id;

    if (!image) {
        return '<a href="' + route + '/show/' + row.id + '" class="block-link">' +
            '<div class="app-table-group">' +
            '<p>' + value + '</p>' +
            '</div>' +
            '</a>';
    }

    return '<a href="' + route + '/show/' + app_id + '" class="block-link">' +
        '<div class="app-table-group">' +
        '<img src="' + image + '" class="app-img"/>' +
        '<p>' + value + '</p>' +
        '</div>' +
        '</a>';
}

function device_type(value) {
    var device_icon;
    switch (value) {
        case 'android':
            device_icon = '<i class="fa fa-android fa-2x"></i>';
            break;
        case 'ios':
            device_icon = '<i class="fa fa-apple fa-2x"></i>';
            break;
    }
    return device_icon;
}

/**
 * Formatter for table actions button
 * edit/delete
 *
 * @param id
 */
function userActions(id) {
    var info_word = 'Info';
    var delete_word = 'Delete';
    if (locale === 'ru') {
        info_word = 'Информаия';
        delete_word = 'Удалить';
    }

    var info_button = '<a title="' + info_word + '" href="' + route + '/show/' + id + '" class="icon-button user-info-button">' +
        '<div class="edit-user"></div> ' +
        '</a>';

    var delete_button = '<button title="' + delete_word + '" type="button" data-id="' + id + '" ' +
        'class="delete-user del-user icon-button delete-icon">' +
        '</button>';

    return info_button + delete_button;
}

/**
 * Formatter to return edit button
 * @returns {string}
 */
function editFormatter(id) {
    var edit_word = 'Edit';
    if (locale === 'ru') {
        edit_word = 'Редактировать';
    }
    return '<a title="' + edit_word + '" href="' + route + '/edit/' + id + '" class="icon-button">' +
        '<i class="icons8-edit"></i>' +
        '</a>';
}

function done(value) {
    return appDone = value;
}

function app_actions(id, app) {
    var edit_word = 'Edit';
    var start_word = 'Start campaign';
    var pause_word = 'Pause campaign';
    var stats_word = 'Statistics';
    var delete_word = 'Delete';
    if (locale === 'ru') {
        edit_word = 'Редактировать';
        start_word = 'Запустить кампанию';
        pause_word = 'Приостановить кампанию';
        stats_word = 'Статистика';
        delete_word = 'Удалить';
    }

    var edit =
        '<a title="' + edit_word + '" href="' + route + '/edit/' + id + '" class="btn-task-status">' +
        '<div class="actions_items edit"> </div> ' +
        '</a>';

    var start =
        '<a title="' + start_word + '" class=" btn-task-status" ' +
        'data-id="' + app.id + '">' +
        '<div class="actions_items start"> </div>' +
        '</a>';

    if (!app.paid || !app.moderated || !app.accepted || app.done) {
        start =
            '<a title="' + start_word + '" class="btn-task-status not-active">' +
            '<div class="actions_items start"> </div>' +
            '</a>';
    }

    if (app.active) {
        start = '<a title="' + pause_word + '" class=" btn-task-status"' +
            'data-id="' + app.id + '">' +
            '<div class="actions_items start"> </div>' +
            '</a>';
    }

    var stats =
        '<a title="' + stats_word + '" href="' + route + '/show/' + id + '" class="">' +
        '<div class="actions_items stats"> </div>' +
        '</a>';

    var restore = app.paid && (!app.canceled && !app.done);
    var del =
        '<button title="' + delete_word + '" type="button" class="delete actions_items del" ' +
        'data-amount="' + app.amount_for_user + '" data-wasted="' + app.amount_wasted +
        '" data-restore="' + restore + '" data-id="' + id + '">' +
        
        '</button>';

    if (app.paid && !app.moderated) {
        del = '<button title="' + delete_word + '" type="button" class=" not-active">' +
            '<div class="actions_items del"> </div>' +
            '</button>';
    }

    return edit + start + stats + del;
}

function active(value, app) {
    var appId = app.id;
    var apps = sessionStorage.getItem('apps');
    if (apps) {
        apps = JSON.parse(apps);
        if (apps.activate.indexOf(appId) !== -1) {
            value = true;
        } else if (apps.deactivate.indexOf(appId) !== -1) {
            value = false;
        }
    }

    if (value === true) {
        a_class = "btn-success visible";
        span_class = "glyphicon-ok";
    } else {
        a_class = "btn-danger";
        span_class = "glyphicon-remove";
    }
    var disabledBtn = (appDone || !app.moderated || !app.accepted || !app.paid)
    && value === false ? 'disabled data-disabled="true"' : '';

    return '<a data-id=' + identifier + ' class="active active-item btn ' + a_class + '"' + disabledBtn + '><span class="glyphicon ' + span_class + '"></span></a>';
}

/**
 * Formatter for banned state
 *
 * @param value
 * @returns {string}
 */
function banned(value) {
    if (value === 1)
        return '<i title="Пользователь забанен" class="fa fa-2x fa-ban text-danger"></i>';
}

function statusFormatter(value) {
    return '<span class="label label-' + value['class'] + '">' + value['label'] + '</span>';
}

function booleanFormatter(result_success) {
    var icon = '<i class="fa fa-2x fa-times text-danger"></i>';
    if (result_success) {
        return '<i class="fa fa-2x fa-check text-success"></i>';
    }
    return icon;
}

function manualFormatter(value) {
    var icon = null;
    if (value === true) {
        icon = 'fa-hand-paper-o';
    } else {
        icon = 'fa-cogs';
    }
    return '<i class="fa fa-2x ' + icon + '"></i>';
}

function userIdentifierFormatter(id, user) {
    return '<a href="/users/show/' + user.id + '">' + id + '</a>';
}

/**
 * @object object
 * @any value
 * @returns {string}
 */
function getKeyByValue(object, value) {
    return Object.keys(object).find(function (key) {
        return object[key] === value
    });
}

/**
 * Formatter for displaying all users who did task
 *
 * @param index
 * @param value
 * @returns {string}
 */
function detailFormatter(index, value) {
    var data = "";
    $.each(value.users_list, function (index, val) {
        data += '<div class="well well-sm primary">' + val.name + ' ' + val.email + ' ' + val.date + '</div>';
    });
    return data;
}

function amount(value) {
    return '<b>' + value + " " + currency + '</b>';
}

/**
 * Deleting record from table
 */
$('body').on('click', '.delete', function () {
    var self = $(this);
    var id = self.attr('data-id');
    var message = 'Are You sure that You want delete application?';

    var app_amount = self.data('amount');
    var restore = self.data('restore');

    if (restore) {
        var old_balance = parseFloat($('#balance-value').html());
        var wasted = parseFloat(self.data('wasted'));
        var to_restore = app_amount - wasted;
        var new_balance = old_balance + to_restore;
    }

    if (locale === 'ru') {
        message = 'Вы уверены, что хотите удалить приложение?';
    }
    bootbox.confirm(message, function (result) {
        if (result) {
            $.ajax({
                url: route + '/edit/' + id,
                type: 'DELETE',
                success: function () {
                    table.bootstrapTable('refresh');
                    if (restore) {
                        $('#balance-value').html(new_balance.toFixed(2));
                    }
                },
                error: function () {
                    new Noty({
                        type: 'warning',
                        timeout: 4000,
                        text: 'Can not delete application',
                    }).show();
                }
            });
        }
    });
});