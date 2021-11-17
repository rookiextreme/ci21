$(document).on('click', '.add-job-group, .update-job-group, .delete-grade, .active-job-group, .delete-job-group', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-job-group')){
        window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/insert-update/' + $('.penilaian_id').val();
    }else if(selectedClass.hasClass('update-job-group')){
        window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/insert-update/' + $('.penilaian_id').val() + '/' +$(this).closest('tr').attr('data-job-group-id');
    }else if(selectedClass.hasClass('active-job-group')){
        let job_group_id = $(this).closest('tr').attr('data-job-group-id');

        let data = new FormData;
        data.append('job_group_id', job_group_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/job-group/activate', data, 2);
    }else if(selectedClass.hasClass('delete-job-group')){
        let job_group_id = selectedClass.closest('tr').attr('data-job-group-id');

        let data = new FormData;
        data.append('job_group_id', job_group_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Job Group Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/job-group/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});
