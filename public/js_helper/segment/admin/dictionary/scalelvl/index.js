//Scale Level
$(document).on('click', '.add-scale-level, .update-scale-level, .delete-scale-level, .active-scale-level, .delete-scale-level', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-scale-level')){
        postEmptyFields([
            ['.scale-level-nama', 'text'],
        ]);
        $('.post-add-scale-level').attr('style', '');
        $('.post-update-scale-level').attr('style', 'display:none');
        $('.scale-level-title').html('Tambah Scale Level');
        $('.scale-level-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-level')){
        $('.scale-level-id').val(selectedClass.closest('tr').attr('data-scale-level-id'));
        postEmptyFields([
            ['.scale-level-nama', 'text'],
        ]);
        $('.post-add-scale-level').attr('style', 'display:none');
        $('.post-update-scale-level').attr('style', '');

        let data = new FormData;
        data.append('scale_level_id', $('.scale-level-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/scale-level/get-record', data, 1);
        $('.scale-level-title').html('Kemaskini Scale Level');
        $('.scale-level-modal').modal('show');
    }else if(selectedClass.hasClass('active-scale-level')){
        let scale_level_id = $(this).closest('tr').attr('data-scale-level-id');

        let data = new FormData;
        data.append('scale_level_id', scale_level_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/scale-level/activate', data, 2);
    }else if(selectedClass.hasClass('delete-scale-level')){
        let scale_level_id = selectedClass.closest('tr').attr('data-scale-level-id');

        let data = new FormData;
        data.append('scale_level_id', scale_level_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Scale Level Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/scale-level/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-scale-level, .post-update-scale-level', function(){
    let selectedClass = $(this);
    let scale_level_nama = $('.scale-level-nama').val();
    let scale_level_id = $('.scale-level-id').val();

    let check = checkEmptyFields([
        ['.scale-level-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-level')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_level_id', scale_level_id);
        data.append('trigger' , 1);
    }

    data.append('scale_level_nama', scale_level_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/scale-level/tambah-kemaskini', data, 0);
});
//End Scale Level

//Scale Level Sets
$(document).on('click', '.update-scale-level-sets, .update-scale-level-set, .reset-scale-level-set, .active-scale-level-set, .delete-scale-level-set', function(){
    let selectedClass = $(this);

    if(selectedClass.hasClass('update-scale-level-sets')){
        let scale_name = selectedClass.closest('tr').find('td:first').text();
        let scale_lvl_id = selectedClass.closest('tr').attr('data-scale-level-id');
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
        ]);
        scaleLvlSetTable({
            scale_lvl_id: scale_lvl_id
        });

        $('.post-add-scale-level-set').attr('style', 'width: 100%');
        $('.post-update-scale-level-set').attr('style', 'display:none');
        $('.reset-scale-level-set').attr('style', 'display:none');
        $('.scale-level-id').val(scale_lvl_id);
        $('.scale-level-set-title').html('Scale Level: ' + scale_name);
        $('.scale-level-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-level-set')){
        $('.scale-level-set-id').val(selectedClass.closest('tr').attr('data-scale-level-set-id'));
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
        ]);

        $('.post-add-scale-level-set').attr('style', 'display:none');
        $('.post-update-scale-level-set').attr('style', 'width: 100%');
        $('.reset-scale-level-set').attr('style', 'width: 100%');

        let data = new FormData;
        data.append('scale_level_set_id', $('.scale-level-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/scale-level/set/get-record', data, 4);
    }else if(selectedClass.hasClass('reset-scale-level-set')){
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
        ]);
        $('.post-add-scale-level-set').attr('style', 'width: 100%');
        $('.post-update-scale-level-set').attr('style', 'display:none');
        $(selectedClass).attr('style', 'display:none');
    }else if(selectedClass.hasClass('active-scale-level-set')){
        let scale_level_set_id = $(this).closest('tr').attr('data-scale-level-set-id');

        let data = new FormData;
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/scale-level/set/activate', data, 5);
    }else if(selectedClass.hasClass('delete-scale-level-set')){
        let scale_level_set_id = selectedClass.closest('tr').attr('data-scale-level-set-id');

        let data = new FormData;
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Scale Level Set Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/scale-level/set/delete',
                data: data,
                postfunc: 1
            }
        });
    }
});

$(document).on('click', '.post-add-scale-level-set, .post-update-scale-level-set', function(){
    let selectedClass = $(this);
    let scale_level_set_nama = $('.scale-level-set-nama').val();
    let scale_level_set_skill_set = $('.scale-level-set-skill-set').val();
    let scale_level_id = $('.scale-level-id').val();
    let scale_level_set_id = $('.scale-level-set-id').val();

    let check = checkEmptyFields([
        ['.scale-level-set-nama', 'mix', 'Nama'],
        ['.scale-level-set-skill-set', 'int', 'Skill Set'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-level-set')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('trigger' , 1);
    }

    data.append('scale_level_set_nama', scale_level_set_nama);
    data.append('scale_level_set_skill_set', scale_level_set_skill_set);
    data.append('scale_level_id', scale_level_id);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/scale-level/set/tambah-kemaskini', data, 3);
});
