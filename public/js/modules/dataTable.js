var table = $('.datatable').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        aaSorting:[[0,"desc"]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action'},
        ]
        });

export const getDatatable = () => table;
export const setDatatable = (val) => (table = val);
