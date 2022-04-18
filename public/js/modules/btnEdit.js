

export function btnEdit(title) {

    var table = $('.datatable').datatable();
    $(document).ready(function() {

        var modal = $('.modal'),
            form = $('.form'),
            btnAdd = $('.add'),
            btnSave = $('.btn-save'),
            btnUpdate = $('.btn-update');

        $(document).on('click','.btn-edit',function(){
            btnSave.hide();
            btnUpdate.show();
            
            modal.find('.modal-title').text(title)
            modal.find('.modal-footer button[type="submit"]').text('Update')

            var rowData =  table.row($(this).parents('tr')).data()
            
            form.find('input[name="id"]').val(rowData.id)
            form.find('input[name="title"]').val(rowData.name)
            form.find('input[name="description"]').val(rowData.phone)
            modal.modal()
        })

    })
}
