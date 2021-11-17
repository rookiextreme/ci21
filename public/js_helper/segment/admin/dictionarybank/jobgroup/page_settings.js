$(document).on('click', '.update-score', function(){
    let job_group_id = $(this).closest('tr').attr('data-job-group-id');
    window.location.href = '/admin/dictionary/bank/penilaian/job-group/score/' + job_group_id;
})

$(document).on('click', '.show-config-page', function(){
    window.location.href = '/admin/dictionary/bank/penilaian/config/' + $('.penilaian_id').val();
})

$(document).on('click', '.show-soalan-page', function(){
    window.location.href = '/admin/dictionary/bank/penilaian/config/items/' + $('.penilaian_id').val();
})
