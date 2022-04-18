export function btnEdit(title, url, model, token, table) {

    var modal = $('.modal'),
        form = $('.form'),
        btnAdd = $('.add'),
        btnSave = $('.btn-save'),
        btnUpdate = $('.btn-update');


    $(document).on('click','.btn-edit', function(){
        btnSave.hide();
        btnUpdate.show();
        modal.find('.modal-title').text(title)


        var id =  $(this).attr('edit-line')

        var request = $.ajax({
            type: "POST",
            url: url,
            data: {id: id, _token: token, model: model},             
        })

        request.done( function (msg) {
                $.each(msg, function (i, element) {
                    const inputField = $('.form [name=' + i + ']');
                    if (inputField.prop('tagName') === 'SELECT') {
                        inputField.val(element).change();
                    } else if (inputField.prop('tagName') === 'INPUT') {
                        inputField.val(element)
                    } else if (inputField.prop('tagName') === 'TEXTAREA') {
                        inputField.val(element)
                    }
                })


        })


    })       
}