export function btnDelete(token) {
    $(document).on('click','.btn-delete',function(){
        if(!confirm("Are you sure?")) return;

        var rowid = $(this).data('rowid')
        var el = $(this)
        if(!rowid) return;

        
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "/" + rowid,
            data: {_method: 'delete',_token:token},
            success: function (data) {
                if (data.success) {
                    table.row(el.parents('tr'))
                        .remove()
                        .draw();
                }
            }
         }); //end ajax
    })
}