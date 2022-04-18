"use strict";

export function btnUsersClick(url, token, model, title){
/* Link element to companies button on click  */
$('#dataTable, .dataTable').on('click', '.btnUsers', function () {
    $('input[type=checkbox]').prop("checked", false)
    var id = $(this).attr('user-button-line');
    $('#assignments').val(id)
    var name = $(this).attr('user-button-line-name');
    if(name=='') name = id
    $('#exampleModalCenterTitleUser').text(title+' ['+name+']')
    $('input[name=model_id]').val(id)
    var request = $.ajax({
        url: url,
        method: "POST",
        data: { id : id, _token: token, model: model },
        dataType: "html"
    })
    request.done(function( msg ) {
        $.each(JSON.parse(msg), function(i, element) {
            $('input[name=user_'+element.id+']').prop("checked", true)
        })
        $('input[name=_token]').val(token)
    })
    request.fail(function( jqXHR, textStatus ) {

    })
})
}
