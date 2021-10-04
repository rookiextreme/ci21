//Grade
$(document).on('click', '.add-competency-type-set, .update-competency-type-set, .delete-competency-type-set, .active-competency-type-set, .delete-competency-type-set', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-competency-type-set')){
        postEmptyFields([
            ['.competency-type-set-com-type', 'dropdown'],
            ['.competency-type-set-scale-level', 'dropdown'],
        ]);
        $('.post-add-competency-type-set').attr('style', '');
        $('.post-update-competency-type-set').attr('style', 'display:none');
        $('.competency-type-set-title').html('Tambah Competency Type Set');
        $('.competency-type-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-competency-type-set')){
        $('.competency-type-set-id').val(selectedClass.closest('tr').attr('data-competency-type-set-id'));
        postEmptyFields([
            ['.competency-type-set-com-type', 'dropdown'],
            ['.competency-type-set-scale-level', 'dropdown'],
        ]);
        $('.post-add-competency-type-set').attr('style', 'display:none');
        $('.post-update-competency-type-set').attr('style', '');

        let data = new FormData;
        data.append('competency_type_set_id', $('.competency-type-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/competency-type-set/get-record', data, 1);
        $('.competency-type-set-title').html('Kemaskini Competency Type Set');
        $('.competency-type-set-modal').modal('show');
    }else if(selectedClass.hasClass('active-competency-type-set')){
        let competency_type_set_id = $(this).closest('tr').attr('data-competency-type-set-id');

        let data = new FormData;
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/competency-type-set/activate', data, 2);
    }else if(selectedClass.hasClass('delete-competency-type-set')){
        let competency_type_set_id = selectedClass.closest('tr').attr('data-competency-type-set-id');

        let data = new FormData;
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Competency Type Set Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/competency-type-set/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-competency-type-set, .post-update-competency-type-set', function(){
    let selectedClass = $(this);
    let competency_type_set_com_type = $('.competency-type-set-com-type').val();
    let competency_type_set_scale_level = $('.competency-type-set-scale-level').val();
    let competency_type_set_id = $('.competency-type-set-id').val();

    let check = checkEmptyFields([
        ['.competency-type-set-com-type', 'int', 'Competency Type'],
        ['.competency-type-set-scale-level', 'int', 'Scale Level'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-competency-type-set')){
        data.append('trigger' , 0);
    }else{
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('trigger' , 1);
    }

    data.append('competency_type_set_com_type', competency_type_set_com_type);
    data.append('competency_type_set_scale_level', competency_type_set_scale_level);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/competency-type-set/tambah-kemaskini', data, 0);
});

//End Grade
