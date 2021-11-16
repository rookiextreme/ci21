//Grade
$(document).on('click', '.add-scale-skill-set, .update-scale-skill-set, .delete-scale-skill-set, .active-scale-skill-set, .delete-scale-skill-set', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-scale-skill-set')){
        postEmptyFields([
            ['.scale-skill-set-nama', 'text'],
        ]);
        $('.post-add-scale-skill-set').attr('style', '');
        $('.post-update-scale-skill-set').attr('style', 'display:none');
        $('.scale-skill-set-title').html('Tambah Scale Skill Set');
        $('.scale-skill-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-skill-set')){
        $('.scale-skill-set-id').val(selectedClass.closest('tr').attr('data-scale-skill-set-id'));
        postEmptyFields([
            ['.scale-skill-set-nama', 'text'],
        ]);
        $('.post-add-scale-skill-set').attr('style', 'display:none');
        $('.post-update-scale-skill-set').attr('style', '');

        let data = new FormData;
        data.append('scale_skill_set_id', $('.scale-skill-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/setting/scale-skill-set/get-record', data, 1);
        $('.scale-skill-set-title').html('Kemaskini Scale Skill Set');
        $('.scale-skill-set-modal').modal('show');
    }else if(selectedClass.hasClass('active-scale-skill-set')){
        let scale_skill_set_id = $(this).closest('tr').attr('data-scale-skill-set-id');

        let data = new FormData;
        data.append('scale_skill_set_id', scale_skill_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/setting/scale-skill-set/activate', data, 2);
    }else if(selectedClass.hasClass('delete-scale-skill-set')){
        let scale_skill_set = selectedClass.closest('tr').attr('data-scale-skill-set-id');

        let data = new FormData;
        data.append('scale_skill_set_id', scale_skill_set);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Gred Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/setting/scale-skill-set/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-scale-skill-set, .post-update-scale-skill-set', function(){
    let selectedClass = $(this);
    let scale_skill_set_nama = $('.scale-skill-set-nama').val();
    let scale_skill_set_id = $('.scale-skill-set-id').val();

    let check = checkEmptyFields([
        ['.scale-skill-set-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-skill-set')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_skill_set_id', scale_skill_set_id);
        data.append('trigger' , 1);
    }

    data.append('scale_skill_set_nama', scale_skill_set_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/setting/scale-skill-set/tambah-kemaskini', data, 0);
});

//End Grade
