export function btnUpdate(token) {

    var btnUpdate = $('.btn-update'),
    modal = $('.modal'),
    form = $('.form');

    btnUpdate.click(function(){
        if(!confirm("Are you sure?")) return;
        var formData = form.serialize()+'&_method=PUT&_token='+token
        var updateId = form.find('input[name="id"]').val()
        $.ajax({
            type: "POST",
            url: "/" + updateId,
            data: formData,
            success: function (data) {
                if (data.success) {
                    table.draw();
                    modal.modal('hide');
                }
            }
         }); //end ajax
    })
}