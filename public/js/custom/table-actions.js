function selectDatatableRows(table) {
    table.on( 'click', 'tr', function () {

        setTimeout(function () {
            table.rows().nodes().each(function (row) {
                if ($(row).hasClass('selected')) {
                    $(row).find('input[type="checkbox"]').first().prop('checked', true);
                } else {
                    $(row).find('input[type="checkbox"]').first().prop('checked', false);
                }
            })
        }, 200);
    });
}


function selectDatatableInAssignModal(tableId, url, targetColumn) {
    targetColumn = targetColumn || 1
    let assignDataTable;

    if (!$.fn.DataTable.isDataTable(tableId)) {
        assignDataTable = $(tableId).DataTable({
            'processing': true,
            'responsive': true,
            'serverSide': true,
            'ajax': url,
            'columnDefs': [
                {
                    'targets': targetColumn,
                    'orderable': false,
                    'checkboxes': {
                        'selectRow': true,
                    }
                },
            ],
            'select': {
                'style': 'os',
            },
        });
    } else {
        assignDataTable = $(tableId).DataTable();
        assignDataTable.ajax.url(url).load();
    }

    setTimeout(function () {

        assignDataTable.rows().nodes().each(function (row) {
            let checkbox = $(row).find('input[type="checkbox"]').first();

            if (checkbox.is(':checked')) {
                $(row).addClass('selected');
            }
        });
    }, 1000);

    assignDataTable.off('click', 'tr');
    assignDataTable.on( 'click', 'tr', function () {
            setTimeout(function () {
                assignDataTable.rows().nodes().each(function (row) {
                    let checkbox = $(row).find('input[type="checkbox"]').first();
                    if ($(row).hasClass('selected') || checkbox.prop('checked')) {
                        // checkbox.attr('checked', true)
                        checkbox.prop('checked', true)
                        $(row).addClass('selected')
                    } else {
                        // checkbox.removeAttr('checked')
                        checkbox.prop('checked', false)
                        $(row).removeClass('selected')
                    }
                })
            }, 200);
    });

    return assignDataTable;
}
