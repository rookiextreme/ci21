$(document).on('click', '.update-score', function(){
    let job_group_id = $(this).closest('tr').attr('data-job-group-id');
    window.location.href = '/admin/dictionary/bank/penilaian/job-group/score/' + job_group_id;
})
