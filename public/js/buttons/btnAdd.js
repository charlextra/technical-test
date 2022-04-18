export function btnAdd(title) {

    var btnAdd = $('.add'),
        btnSave = $('.btn-save'),
        btnUpdate = $('.btn-update'),
        modal = $('.modal'),
        form = $('.form');

        btnAdd.click(function(){
            modal.modal()
            form.trigger('reset')
            modal.find('.modal-title').text(title)
            btnSave.show();
            btnUpdate.hide()
        })

}