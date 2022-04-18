var table = $('.datatable').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        aaSorting:[[0,"desc"]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action'},
        ]
        });

export const getDatatable = () => table;
export const setDatatable = (val) => (val = table);
