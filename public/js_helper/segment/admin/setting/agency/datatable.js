$('.agency-table').DataTable({
    // processing: true,
	// serverSide: true,
    ajax: getUrl() + '/admin/setting/agency/list',
    lengthChange:true,
    columns: [
        {
            title: '',
            target: 0,
            className: 'treegrid-control',
            data: function (item) {
                if (item.children) {
                    return '<span style="color:black;">'+feather.icons['plus'].toSvg()+'</span>';
                }
                return '';
            }
        },
        {
            title: 'Name',
            target: 1,
            data: function (item) {
                return item.name;
            }
         },
        {
            title: 'Action',
            target: 2,
            data: function (item) {
                let row_flag = item.flag;
                let outLine = row_flag == 1 ? 'btn-outline-success' : 'btn-outline-danger';
                return (
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-agency">'+ feather.icons['power'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light add-penyelaras">'+ feather.icons['user-plus'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-agency">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-agency">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
         },
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    buttons: [,
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Agensi',
            className: 'create-new btn btn-primary add-agency',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        }
    ],
    createdRow: function( row, data ) {
        $(row).addClass('agency-row');
        $(row).attr('data-agency-id',data['id']);
    },
    'treeGrid': {
        'left': 10,
        'expandIcon': '<span style="color:black;">'+feather.icons['plus'].toSvg()+'</span>',
        'collapseIcon': '<span style="color:black;">'+feather.icons['minus'].toSvg()+'</span>'
    },
    searching: false,
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

function load_penyelaras_table(id) {
    $('.penyelaras-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: getUrl() + '/admin/setting/agency/load_penyelaras/'+id,
        lengthChange:true,
        columns: [
            { data: 'nama' },
            { data: 'email' },
            { data: 'penempatan' },
            // { data: 'active' },
            { data: 'action' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('penyelaras-row');
        },
        columnDefs: [
            // {
            //     // Actions
            //     targets: -2,
            //     title: 'Aktif',
            //     orderable: false,
            //     render: function (data, type, full, meta) {
            //         let row_flag = full.flag;
            //         let outLine = row_flag == 1 ? 'btn-outline-success' : 'btn-outline-danger';
            //         return (
            //             '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light pengguna-aktif">'+ feather.icons['power'].toSvg() +'</button>'
            //         );
            //     }
            // },
            {
                // Actions
                targets: -1,
                title: 'Aksi',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light penyelaras-delete">'+ feather.icons['trash-2'].toSvg() +'</button>'
                    );
                }
            }
        ],
        dom:
            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [,
            {
                text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Pengguna',
                className: 'create-new btn btn-primary post-add-pengguna',
                attr: {
                    'data-toggle': 'modal',
                    'data-target': '#modals-slide-in'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
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

    $('.post-add-pengguna').attr('disabled','disabled');
}
