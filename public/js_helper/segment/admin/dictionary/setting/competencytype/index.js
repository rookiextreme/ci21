//Grade
$(document).on('click', '.add-competency-type, .update-competency-type, .delete-competency-type, .active-competency-type, .delete-competency-type', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-competency-type')){
        postEmptyFields([
            ['.competency-type-nama', 'text'],
        ]);
        $('.post-add-competency-type').attr('style', '');
        $('.post-update-competency-type').attr('style', 'display:none');
        $('.competency-type-title').html('Tambah Competency Type');
        $('.competency-type-modal').modal('show');
    }else if(selectedClass.hasClass('update-competency-type')){
        $('.competency-type-id').val(selectedClass.closest('tr').attr('data-competency-type-id'));
        postEmptyFields([
            ['.competency-type-nama', 'text'],
        ]);
        $('.post-add-competency-type').attr('style', 'display:none');
        $('.post-update-competency-type').attr('style', '');

        let data = new FormData;
        data.append('competency_type_id', $('.competency-type-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/setting/competency-type/get-record', data, 1);
        $('.competency-type-title').html('Kemaskini Competency Type');
        $('.competency-type-modal').modal('show');
    }else if(selectedClass.hasClass('active-competency-type')){
        let competency_type_id = $(this).closest('tr').attr('data-competency-type-id');

        let data = new FormData;
        data.append('competency_type_id', competency_type_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/setting/competency-type/activate', data, 2);
    }else if(selectedClass.hasClass('delete-competency-type')){
        let competency_type_id = selectedClass.closest('tr').attr('data-competency-type-id');

        let data = new FormData;
        data.append('competency_type_id', competency_type_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Competency Type Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/setting/competency-type/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-competency-type, .post-update-competency-type', function(){
    let selectedClass = $(this);
    let competency_type_nama = $('.competency-type-nama').val();
    let competency_type_id = $('.competency-type-id').val();
    let tech_discipline_flag = 0;

    if($('.tech-chkbox').attr('checked') == 'checked') {
        tech_discipline_flag = 1;
    }

    let check = checkEmptyFields([
        ['.competency-type-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-competency-type')){
        data.append('trigger' , 0);
    }else{
        data.append('competency_type_id', competency_type_id);
        data.append('trigger' , 1);
    }

    data.append('competency_type_nama', competency_type_nama);
    data.append('tech_discipline_flag',tech_discipline_flag);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/setting/competency-type/tambah-kemaskini', data, 0);
});

//End Grade
