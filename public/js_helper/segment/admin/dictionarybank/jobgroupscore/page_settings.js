$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent()
    });
});

if($('.job_group_sets_id').val() != '' || typeof $('.job_group_sets_id').val() == "undefined"){
    loadJurusanItem({
        jurusan: $('.job-group-set-jurusan').val(),
        penilaian_id: $('.penilaian_id').val(),
        job_group_id: $('.job_group_sets_id').val()
    })
}

$(document).on('change', '.job-group-set-jurusan', function(){
    let selectedVal = $(this).val();
    loadJurusanItem({
        jurusan: selectedVal,
        penilaian_id: $('.penilaian_id').val(),
        job_group_id: $('.job_group_sets_id').val()
    })
})

function loadJurusanItem({jurusan, penilaian_id, job_group_id}){
    let data = new FormData;
    data.append('jurusan', jurusan);
    data.append('penilaian_id', penilaian_id);
    data.append('job_group_id', job_group_id);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/job-group/insert-update/get-jurusan-item', data, 0);
}
