/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    $ = jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * Next we will register the CSRF Token as a common header with JQuery AJAX so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    /**
     * Setting CSRF token header for ajax requests
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token.getAttribute('content'),
            'Accept': 'application/json'
        }
    });

} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}