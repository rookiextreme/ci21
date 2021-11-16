$('.grade-category-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/grade-category/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'jumlah_gred' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('grade-category-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-grade-category">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-grade-category">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-grade-category">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [5],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Kategori',
            className: 'create-new btn btn-info add-grade-category',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Collection',
            className: 'create-new btn btn-info duplicate-grade-category',
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
    }
});

$('.measuring-lvl-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/measuring-level/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('measuring-lvl-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-measuring-lvl">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-measuring-lvl">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-measuring-lvl">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [5],
    buttons: [,
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Measuring Level',
            className: 'create-new btn btn-primary add-measuring-lvl',
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
    }
});

$('.competency-type-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/setting/competency-type/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('competency-type-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-competency-type">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-competency-type">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-competency-type">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [5],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Competency Type',
            className: 'create-new btn btn-warning add-competency-type',
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

$('.scale-skill-set-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/setting/scale-skill-set/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('scale-skill-set-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-scale-skill-set">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-scale-skill-set">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-scale-skill-set">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Skill Set',
            className: 'create-new btn btn-warning add-scale-skill-set',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Scale Level',
            className: 'create-new btn btn-info show-scale-level-page',
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

//scale level
$('.scale-level-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/scale-level/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'name' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('scale-level-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-scale-level">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-info mr-1 mb-1 waves-effect waves-light update-scale-level-sets">'+ feather.icons['list'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-scale-level">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-scale-level">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Scale Level',
            className: 'create-new btn btn-warning add-scale-level',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Skill Set',
            className: 'create-new btn btn-info show-skill-set-page',
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

function scaleLvlSetTable({scale_lvl_id}){
    $('.scale-level-set-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getUrl() + '/admin/dictionary/bank/penilaian/config/scale-level/set/list',
            type: 'POST',
            data: {
                scale_lvl_id: scale_lvl_id,
                _token: getToken()
            }
        },
        lengthChange:true,
        columns: [
            { data: 'name' },
            { data: 'skillset' },
            { data: 'active' },
            { data: 'action' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('scale-level-set-row');
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
                        '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-scale-level-set">'+ feather.icons['power'].toSvg() +'</button>'
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
                        '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-scale-level-set">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-scale-level-set">'+ feather.icons['trash-2'].toSvg() +'</button>'
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

//End Scale Level

//Competency Type Set
$('.competency-type-set-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: getUrl() + '/admin/dictionary/bank/penilaian/config/competency-type-set/list/' + $('.penilaian_id').val(),
    lengthChange:true,
    columns: [
        { data: 'competency' },
        { data: 'scale_level' },
        { data: 'active' },
        { data: 'action' },
    ],
    createdRow: function( row, data, dataIndex ) {
        $(row).addClass('competency-type-set-row');
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
                    '<button type="button" class="btn btn-icon '+ outLine +' mr-1 mb-1 waves-effect waves-light active-competency-type-set">'+ feather.icons['power'].toSvg() +'</button>'
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
                    '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light update-competency-type-set">'+ feather.icons['edit-3'].toSvg() +'</button>' +
                    '<button type="button" class="btn btn-icon btn-outline-danger mr-1 mb-1 waves-effect waves-light delete-competency-type-set">'+ feather.icons['trash-2'].toSvg() +'</button>'
                );
            }
        }
    ],
    dom:
        '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [7, 10, 25, 50, 75, 100],
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Competency Type Set',
            className: 'create-new btn btn-warning add-competency-type-set',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Scale Level',
            className: 'create-new btn btn-primary show-scale-level-page',
            attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        },
        {
            text: feather.icons['plus'].toSvg({ class: 'mr-50 font-small-4' }) + 'Tambah Competency Type',
            className: 'create-new btn btn-info show-competency-type-page',
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



