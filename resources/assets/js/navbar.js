function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

$(document).ready(() => {
    let collapsed = getCookie('collapsed');
    let window_width = document.body.clientWidth;


    // if (localStorage) {
    //     collapsed = localStorage.getItem('collapsed') || false;
    // }
    //
    // if (validateBoolean(collapsed)) {
    // collapseWindow();
    // }

    let collapse_button = $('#collapse-navbar');
    let nav = $('nav.nav');
    let headerLogoside = $('.header-logoside');
    let content = $('.content');

    collapse_button.click(() => {
        currentCollapse = getCookie('collapsed') ? +getCookie('collapsed') : 0;

        var date = new Date(new Date().getTime() + 1000 * 36000);
        document.cookie = "collapsed=" + +!currentCollapse + "; path=/; expires=" + date.toUTCString();

        let collapsed = navbarCollapsed(nav);
        if (collapsed) {
            nav.removeClass('collapsed');
            content.removeClass('collapsed');
            headerLogoside.removeClass('collapsed');
            localStorage.setItem('collapsed', false);
        } else {
            collapseWindow();
        }
    });

    let nav_height = $('.nav ul').height();
    let window_height = document.body.clientHeight;
    if (window_height < nav_height + 120) {
        $('.nav .nav-footer').hide();
    } else {
        if (!$('.nav').hasClass('collapsed')) {
            $('.nav .nav-footer').show();
        }
    }

    collapseByWidth(window_width);

    document.body.onresize = () => {
        let window_width = document.body.clientWidth;
        let window_height = document.body.clientHeight;

        if (window_width <= 768 && !navbarCollapsed(nav)) {
            collapseByWidth(window_width);
        }

        if (window_height < nav_height + 150) {
            $('.nav .nav-footer').hide();
        } else {
            if (!$('.nav').hasClass('collapsed')) {
                $('.nav .nav-footer').show();
            }
        }
    }
});

/**
 * Check is navbar collapsed
 * @param navbar
 * @returns boolean
 */
function navbarCollapsed(navbar) {
    return navbar.hasClass('collapsed');
}

function collapseWindow() {
    let nav = $('nav.nav');
    let headerLogoside = $('.header-logoside');
    let content = $('.content');

    nav.addClass('collapsed');
    content.addClass('collapsed');
    headerLogoside.addClass('collapsed');
    if (localStorage) {
        localStorage.setItem('collapsed', true);
    }
}

/**
 * Filter string or int to integer.
 * @string val
 * @returns {boolean}
 */
function validateBoolean(val) {
    return val === 'true' || val === true || val === '1' || val === 1;
}

function collapseByWidth(width) {
    if (width <= 768) {
        collapseWindow();
    }
}
$('#change-theme').click(function() {
    changeTheme();
});
function changeTheme() {
    let theme = $('body').attr('class');
    let route = '/themes/change?theme=' + theme;
    $.ajax({
        url: route,
        type: 'GET',
        complete: function (response) {
            location.reload();
        }
    });
}