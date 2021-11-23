$(document).on('click', '.penyelia-choose', function(){
    let penilaian_id = $(this).closest('.main-penilaian-id').attr('data-id');
    $('.penilaian-id').val(penilaian_id);
    $('.penyelia-title').html('Pilihan Penyelia');
    penyelia_table({
        nokp: $('#penyelia-nama').val(),
        gred: $('#penyelia-gred').val(),
        jurusan: $('#penyelia-jurusan').val()
    });
    $('.penyelia-modal').modal('show');
})

$(document).on('change', '#penyelia-gred, #penyelia-jurusan', function(){
    penyelia_table({
        nokp: $('#penyelia-nama').val(),
        gred: $('#penyelia-gred').val(),
        jurusan: $('#penyelia-jurusan').val()
    });
})

$(document).on('input', '#penyelia-nama', function(){
    penyelia_table({
        nokp: $('#penyelia-nama').val(),
        gred: $('#penyelia-gred').val(),
        jurusan: $('#penyelia-jurusan').val()
    });
})

$(document).on('click', '.job-group-choose', function(){
    let penilaian_id = $(this).closest('.main-penilaian-id').attr('data-id');
    $('.penilaian-id').val(penilaian_id);
    $('.job-group-title').html('Pilihan Job Group');
    job_group_table({
        penilaian_id: penilaian_id,
        jurusan_id: $('#job-group-jurusan').val()
    });
    $('.job-group-modal').modal('show');
})

$(document).on('input', '#job-group-jurusan', function(){
    job_group_table({
        penilaian_id: $('.penilaian-id').val(),
        jurusan_id: $('#job-group-jurusan').val()
    });
})

$(document).on('click', '.penilaian-choose, .penilaian-hantar', function(){
    $.blockUI();
    window.location.href = getUrl() + '/pengguna/penilaian/score/' + $(this).closest('.main-penilaian-id').attr('data-id');
})
