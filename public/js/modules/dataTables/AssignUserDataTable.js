var table = $('#assignUser').DataTable({
        ajax: '',
        serverSide: true,
        processing: true,
        aaSorting:[[0,"desc"]],
        columns: [

            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'},
        ]
        });

export const getUserDatatable = () => table;
export const setDatatable = (val) => (val = table);
