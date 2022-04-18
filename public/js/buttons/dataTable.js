export function dataTable(data) {
var table = $('.datatable').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        aaSorting:[[0,"desc"]],
        columns: [data]
        });
}