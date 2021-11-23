$(document).on('click', '.penyelia-dipilih', function(){
    let selectedClass = $(this);
    let nokp = selectedClass.closest('tr').attr('data-nokp');
    let penilaian_id = $('.penilaian-id').val();

    let data = new FormData;
    data.append('nokp', nokp);
    data.append('penilaian_id', penilaian_id);
    data.append('_token', getToken());

    ajax('/pengguna/penyelia/tambah-kemaskini', data, 0);
});

$(document).on('click', '.job-group-dipilih', function(){
    let selectedClass = $(this);
    let jobgroup_id = selectedClass.closest('tr').attr('data-job-group-id');
    let penilaian_id = $('.penilaian-id').val();

    let data = new FormData;
    data.append('jobgroup_id', jobgroup_id);
    data.append('penilaian_id', penilaian_id);
    data.append('_token', getToken());

    ajax('/pengguna/job-group/tambah-kemaskini', data, 0);
});

//End Grade
