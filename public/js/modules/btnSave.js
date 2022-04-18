export function btnSave(token) {

    var btnSave = $('.btn-save'),
    modal = $('.modal'),
    form = $('.form');

    btnSave.click(function(e){
        e.preventDefault();
        var data = form.serialize()
        console.log(data)
        $.ajax({
            type: "POST",
            url: "",
            data: data+'&_token='+token,
            success: function (data) {
                if (data.success) {
                    table.draw();
                    form.trigger("reset");
                    modal.modal('hide');
                }
                else {
                    alert('Delete Fail');
                }
            }
         }); //end ajax
    })
}