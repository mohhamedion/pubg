

$('.video-top').on('change', function({target}){
    let id = $( target ).val();
    let route = "/videos/" + id + "/top";
        $.ajax({
            url: route,
            type: 'GET',
            complete: function (response) {
            }
        });
});

$('.video-available').on('change', function({target}){
    let id = $( target ).val();
    let route = "/videos/" + id + "/available";
    $.ajax({
        url: route,
        type: 'GET',
        complete: function (response) {
        }
    });
});
