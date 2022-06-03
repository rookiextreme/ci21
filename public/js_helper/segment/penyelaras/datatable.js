$('.penyelaras-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/pengguna/penyelaras/list',
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'year' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('penyelaras-row');
    },
    columnDefs: [
        /*{
            // Actions
            targets: -2,
            title: 'Aktif',
            orderable: false,
            render: function (data, type, full, meta) {
                let row_flag = full.flag_publish;
                let outLine = row_flag == 1 ? 'badge-success' : 'badge-warning';
                let text = row_flag == 1 ? 'Sudah Terbit' : 'Tidak Terbit';
                return (
                    '<span class="badge badge-glow '+outLine+'">'+text+'</span>'
                );
            }
        },*/
        {
            // Actions
            targets: -1,
            title: 'Aksi',
            orderable: false,
            render: function (data, type, full, meta) {
                return (
                    // '<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light copy-dict-bank">'+ feather.icons['copy'].toSvg() +'</button>' +
                    //'<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light set-que-bank">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light view-detail">'+ feather.icons['eye'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        /*
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Penilaian',
            className: 'create-new btn btn-info add-dict-bank',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Set Soalan',
            className: 'create-new btn btn-warning set-que-list',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        */
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

function load_caw(data) {
    $('.caw-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getUrl() + '/pengguna/penyelaras/detail',
            data: {
                "bank_sets_id": data.get('bank_sets_id'),
                "year" : data.get('year'),
                "_token" : data.get('_token')
            },
            type: "POST"

        },
        lengthChange:true,
        columns: [
            { data: 'code' },
            { data: 'name' },
            { data: 'total' },
            { data: 'complete' },
            { data: 'finish' },
            { data: 'draf' },
            { data: 'no_action' },
            { data: 'action'}
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('caw-row');
        },
        columnDefs: [
            /*{
                // Actions
                targets: -2,
                title: 'Aktif',
                orderable: false,
                render: function (data, type, full, meta) {
                    let row_flag = full.flag_publish;
                    let outLine = row_flag == 1 ? 'badge-success' : 'badge-warning';
                    let text = row_flag == 1 ? 'Sudah Terbit' : 'Tidak Terbit';
                    return (
                        '<span class="badge badge-glow '+outLine+'">'+text+'</span>'
                    );
                }
            },*/
            {
                // Actions
                targets: -1,
                title: 'Aksi',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        // '<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light copy-dict-bank">'+ feather.icons['copy'].toSvg() +'</button>' +
                        //'<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light set-que-bank">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light view-caw-detail">'+ feather.icons['eye'].toSvg() +'</button>'
                    );
                }
            }
        ],
        dom:
            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
            /*
            {
                text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Penilaian',
                className: 'create-new btn btn-info add-dict-bank',
                attr: {
                    'data-toggle': 'modal',
                    'data-target': '#modals-slide-in'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            },
            {
                text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Set Soalan',
                className: 'create-new btn btn-warning set-que-list',
                attr: {
                    'data-toggle': 'modal',
                    'data-target': '#modals-slide-in'
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            },
            */
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
        drawCallback: function( settings ) {
            $('#penyelaras-modal-info').modal('show');
        },
        destroy: true
    });

}

$('.staff-table').DataTable({
    lengthChange:true,
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        /*
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Penilaian',
            className: 'create-new btn btn-info add-dict-bank',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Set Soalan',
            className: 'create-new btn btn-warning set-que-list',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        */
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


function reload_table(bank_sets_id,kod_waran,year) {
    $('.staff-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: getUrl() + '/pengguna/penyelaras/info?bank_sets_id='+bank_sets_id+'&waran_code='+kod_waran+'&year='+year,
        lengthChange:true,
        columns: [
            { data: 'status' },
            { data: 'name' },
            { data: 'icno' },
            { data: 'course' },
            { data: 'section' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('penyelaras-row');
        },
        columnDefs: [
            {
                // status
                targets: 0,
                title: 'Status',
                orderable: false,
                render: function (data, type, full, meta) {
                    let row_flag = full.status;
                    if(row_flag == 0) {
                        return "Tiada Tindakan";
                    } else if(row_flag == 1) {
                        return "Belum Dihantar";
                    } else if(row_flag == 2) {
                        return "Menunggu Penilaian Penyelia";
                    } else if(row_flag == 3) {
                        return "Selesai";
                    }
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
