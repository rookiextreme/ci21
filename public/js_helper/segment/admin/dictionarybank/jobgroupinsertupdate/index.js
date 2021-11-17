//Grade
$(document).on('click', '.add-job-group, .update-grade, .delete-grade, .active-grade, .delete-grade', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-job-group')){
        window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/insert-update/' + $('.penilaian_id').val();
    }else if(selectedClass.hasClass('update-grade')){
        $('.grade-id').val(selectedClass.closest('tr').attr('data-grade-id'));
        postEmptyFields([
            ['.grade-nama', 'text'],
        ]);
        $('.post-add-grade').attr('style', 'display:none');
        $('.post-update-grade').attr('style', '');

        let data = new FormData;
        console.log($('.grade-id').val());
        data.append('grade_id', $('.grade-id').val());
        data.append('_token', getToken());

        ajax('/admin/setting/grade/get-record', data, 1);
        $('.grade-title').html('Kemaskini Gred');
        $('.grade-modal').modal('show');
    }else if(selectedClass.hasClass('active-grade')){
        let grade_id = $(this).closest('tr').attr('data-grade-id');

        let data = new FormData;
        data.append('grade_id', grade_id);
        data.append('_token', getToken());
        ajax('/admin/setting/grade/activate', data, 2);
    }else if(selectedClass.hasClass('delete-grade')){
        let grade_id = selectedClass.closest('tr').attr('data-grade-id');

        let data = new FormData;
        data.append('grade_id', grade_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Gred Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/setting/grade/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-job-group, .post-update-job-group', function(){
    let selectedClass = $(this);
    let job_group_set_name_eng = $('.job-group-set-name-eng').val();
    let job_group_set_name_mal = $('.job-group-set-name-mal').val();
    let job_group_set_desc_eng = $('.job-group-set-desc-eng').val();
    let job_group_set_desc_mal = $('.job-group-set-desc-mal').val();
    let job_group_set_grade_category = $('.job-group-set-grade-category').val();
    let job_group_sets_id = $('.job_group_sets_id').val();
    let job_group_set_jurusan = $('.job-group-set-jurusan').val();

    let pass = 0;

    let check = checkEmptyFields([
        ['.job-group-set-name-eng', 'mix', 'Name (English)'],
        ['.job-group-set-grade-category', 'int', 'Service Category'],
        ['.job-group-set-jurusan', 'string', 'Jurusan'],
    ]);

    if(check == false){
        pass = 1;
    }

    let itemArr = [];
    if($('.job-group-set-item').length > 0){
        let checkedBoxes = 0;
        $('.job-group-set-item').each(function(){
            if($(this).prop('checked') == true){
                checkedBoxes++;
                itemArr.push($(this).closest('tr').attr('data-item-id'));
            }
        });

        if(checkedBoxes == 0){
            toasting('Please Select Items', 'error');
            pass = 1;
        }
    }else{
        toasting('Please Select Items', 'error');
        pass = 1;
    }

    if(pass == 1){
        return false;
    }

    let data = new FormData;

    if(selectedClass.hasClass('post-add-job-group')){
        data.append('trigger' , 0);
    }else{
        data.append('job_group_id', job_group_sets_id);
        data.append('trigger' , 1);
    }

    data.append('job_group_set_name_eng', job_group_set_name_eng);
    data.append('job_group_set_name_mal', job_group_set_name_mal);
    data.append('job_group_set_desc_eng', job_group_set_desc_eng);
    data.append('job_group_set_desc_mal', job_group_set_desc_mal);
    data.append('job_group_set_grade_category', job_group_set_grade_category);
    data.append('job_group_set_items', JSON.stringify(itemArr));
    data.append('job_group_set_jurusan', job_group_set_jurusan);
    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('_token', getToken());

    console.log(itemArr);
    ajax('/admin/dictionary/bank/penilaian/job-group/insert-update/tambah-kemaskini', data, 1);
});

//End Grade
