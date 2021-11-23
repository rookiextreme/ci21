function penyelia_table({nokp, gred, jurusan}){
    $('.penyelia-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getUrl() + '/pengguna/penyelia/list',
            type: 'POST',
            data: {
                nokp: nokp,
                gred: gred,
                jurusan: jurusan,
                _token: getToken()
            }
        },
        lengthChange:true,
        columns: [
            { data: 'name' },
            { data: 'nokp' },
            { data: 'jurusan' },
            { data: 'gred' },
            { data: 'action' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('penyelia-row');
        },
        columnDefs: [
            {
                // Actions
                targets: -1,
                title: 'Aksi',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light penyelia-dipilih">'+ feather.icons['edit-3'].toSvg() +'</button>'
                    );
                }
            }
        ],
        dom:
            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [

        ],
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

function job_group_table({penilaian_id, jurusan_id}){
    $('.job-group-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getUrl() + '/pengguna/job-group/list',
            type: 'POST',
            data: {
                penilaian: penilaian_id,
                jurusan: jurusan_id,
                _token: getToken()
            }
        },
        lengthChange:true,
        columns: [
            { data: 'title' },
            { data: 'jurusan' },
            { data: 'action' },
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass('job-group-row');
        },
        columnDefs: [
            {
                // Actions
                targets: -1,
                title: 'Aksi',
                orderable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<button type="button" class="btn btn-icon btn-outline-warning mr-1 mb-1 waves-effect waves-light job-group-dipilih">'+ feather.icons['edit-3'].toSvg() +'</button>'
                    );
                }
            }
        ],
        dom:
            '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [

        ],
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

