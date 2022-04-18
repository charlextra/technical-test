export function btnSave(url, token, table) {

    var btnSave = $('.btn-save'),
    modal = $('.modal'),
    form = $('.form');

    btnSave.click(function(e){
        e.preventDefault();
        var data = form.serialize()
            $.ajax({
                url: url,
                type:'POST',
                data: {data:data, _token:token},

                success: function(data) {
                    if($.isEmptyObject(data.error)){
                                if (data.success) {
                                    table.draw();
                                    form.trigger("reset");
                                    modal.modal('hide');
                                }
                                else {
                                    alert('Please add an element');
                                }
                    }else{
                        $('.invalid-feedback').text('');
                        printErrorMsg(data.error);
                    }
                }
            });
 

        function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
              $('.'+key+'_err').text(value).show();
            });
        }






    })
}