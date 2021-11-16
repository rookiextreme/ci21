$('.bank-listing-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/items/datalist/item/'+ $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'measure' },
        { data: 'com_type' },
        { data: 'jurusan' },
        { data: 'grade_category' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('bank-col-row');
    },
    columnDefs: [
        {
            // Actions
            targets: -2,
            title: 'Aktif',
            orderable: false,
            render: function (data, type, full, meta) {
                let row_flag = full.flag;
                let outLine = row_flag == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                return (
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-bank-col">'+ feather.icons['power'].toSvg() +'</button>'
                );
            }
        },
        {
            // Actions
            targets: -1,
            title: 'Aksi',
            orderable: false,
            render: function (data, type, full, meta) {
                return (
                    '<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light update-bank-col-questions-list">'+ feather.icons['list'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-bank-col">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-bank-col">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Set Soalan',
            className: 'create-new btn btn-warning add-bank-item',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
    ],
    responsive: {
        details: {
            display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                    var data = row.data();
                    return 'Details of ' + data['full_name'];
                }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                    return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                        ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                        : '';
                }).join('');

                return data ? $('<table class="table"/>').append(data) : false;
            }
        }
    },
    language: {
        paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
        }
    }
});

function bank_col_ques_table({item_id}){
    $('.bank-listing-ques-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getUrl() + '',
            type: 'POST',
            data: {
                item_id: item_id,
                _token: getToken()
            }
        },
        lengthChange:true,
        columns: [
            { data: 'name' },
            { data: 'nameMal' },
            { data: 'active' },
            { data: 'action' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('bank-col-ques-row');
        },
        columnDefs: [
            {
                // Actions
                targets: -2,
                title: 'Aktif',
                orderable: false,
                render: function (data, type, full, meta) {
                    let row_flag = full.flag;
                    let outLine = row_flag == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                    return (
                        '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-bank-col-ques">'+ feather.icons['power'].toSvg() +'</button>'
                    );
                }
            },
            {
                // Actions
                targets: -1,
                title: 'Aksi',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-bank-col-ques">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-bank-col-ques">'+ feather.icons['trash-2'].toSvg() +'</button>'
                    );
                }
            }
        ],
        dom:
            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details of ' + data['full_name'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/>').append(data) : false;
                }
            }
        },
        language: {
            paginate: {
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
        destroy: true
    });
}
