import Noty from "noty";

$('.partner-top').on('change', function({target}){
    let id = $( target ).val();
    let route = "/partners/" + id + "/top";
        $.ajax({
            url: route,
            type: 'GET',
            complete: function (response) {
            }
        });
});

$('.partner-available').on('change', function({target}){
    let id = $( target ).val();
    let route = "/partners/" + id + "/available";
    $.ajax({
        url: route,
        type: 'GET',
        complete: function (response) {
        }
    });
});
