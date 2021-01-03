const SELECT_CURRENCY_ROUTE = '/currency';
const SELECT_LOCALE_ROUTE = '/locale';

let toggle_select_currency = $('#toggle_select_currency');
let toggle_select_lang = $('#toggle_select_lang');
let toggle_support = $('#toggle_support');

let div_select_currency = $('div#select_currency_mod');
let div_select_lang = $('div#select_lang_mod');
let div_support = $('div#support_mod');

toggle_select_currency.click(() => {
    div_select_lang.hide();
    div_support.hide();
    div_select_currency.toggle();
});

toggle_select_lang.click(() => {
    div_select_currency.hide();
    div_support.hide();
    div_select_lang.toggle();
});

toggle_support.click(() => {
    div_select_currency.hide();
    div_select_lang.hide();
    div_support.toggle();
});

let select_currency = $('.selectCurrency');
let select_locale = $('.selectLanguage');

select_currency.click(function () {
    $.post(SELECT_CURRENCY_ROUTE, {
            'currency': $(this).data('value')
        },
        () => {
            location.reload()
        }
    );
});

select_locale.click(function () {
    $.post(SELECT_LOCALE_ROUTE, {
            'locale': $(this).data('value')
        },
        () => {
            location.reload()
        }
    );
});

$('.nav *').click(() => hideAllMods());
$('.content *').click(() => hideAllMods());

function hideAllMods() {
    div_select_currency.hide();
    div_select_lang.hide();
    div_support.hide();
}