//Grade
$(document).on('click', '.add-grade, .update-grade, .delete-grade, .active-grade, .delete-grade', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-grade')){
        postEmptyFields([
            ['.grade-nama', 'text'],
        ]);
        $('.post-add-grade').attr('style', '');
        $('.post-update-grade').attr('style', 'display:none');
        $('.grade-title').html('Tambah Gred');
        $('.grade-modal').modal('show');
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

$(document).on('click', '.post-add-grade, .post-update-grade', function(){
    let selectedClass = $(this);
    let grade_nama = $('.grade-nama').val();
    let grade_id = $('.grade-id').val();

    let check = checkEmptyFields([
        ['.grade-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-grade')){
        data.append('trigger' , 0);
    }else{
        data.append('grade_id', grade_id);
        data.append('trigger' , 1);
    }

    data.append('grade_nama', grade_nama);
    data.append('_token', getToken());

    ajax('/admin/setting/grade/tambah-kemaskini', data, 0);
});

//End Grade
