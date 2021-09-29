$(document).on('click', '.add-measuring-lvl, .update-measuring-lvl, .delete-measuring-lvl, .active-measuring-lvl', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-measuring-lvl')){
        postEmptyFields([
            ['.measuring-lvl-nama', 'text'],
        ]);
        $('.post-add-measuring-lvl').attr('style', '');
        $('.post-update-measuring-lvl').attr('style', 'display:none');
        $('.measuring-level-title').html('Tambah Measuring Level');
        $('.measuring-lvl-modal').modal('show');
    }else if(selectedClass.hasClass('update-measuring-lvl')){
        $('.measuring-lvl-id').val(selectedClass.closest('tr').attr('data-measuring-lvl-id'));
        postEmptyFields([
            ['.measuring-lvl-nama', 'text'],
        ]);
        $('.post-add-measuring-lvl').attr('style', 'display:none');
        $('.post-update-measuring-lvl').attr('style', '');

        let data = new FormData;
        data.append('measuring_lvl_id', $('.measuring-lvl-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/measuring-level/get-record', data, 1);
        $('.measuring-level-title').html('Kemaskini Measuring Level');
        $('.measuring-lvl-modal').modal('show');
    }else if(selectedClass.hasClass('active-measuring-lvl')){
        let measuring_lvl_id = $(this).closest('tr').attr('data-measuring-lvl-id');

        let data = new FormData;
        data.append('measuring_lvl_id', measuring_lvl_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/measuring-level/activate', data, 2);
    }
});

$(document).on('click', '.post-add-measuring-lvl, .post-update-measuring-lvl', function(){
    let selectedClass = $(this);
    let measuring_lvl_nama = $('.measuring-lvl-nama').val();
    let measuring_lvl_id = $('.measuring-lvl-id').val();

    let check = checkEmptyFields([
        ['.measuring-lvl-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-measuring-lvl')){
        data.append('trigger' , 0);
    }else{
        data.append('measuring_lvl_id', measuring_lvl_id);
        data.append('trigger' , 1);
    }

    data.append('measuring_lvl_nama', measuring_lvl_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/measuring-level/tambah-kemaskini', data, 0);
});

$(document).on('click', '.pengguna-delete, .pengguna-aktif', function(){
    let selectedClass = $(this);
    let profile_id = selectedClass.closest('tr').attr('data-profile-id');
    let trigger;
    let url;

    let data = new FormData;
    data.append('profile_id', profile_id);
    data.append('_token', getToken());

    if(selectedClass.hasClass('pengguna-delete')){
        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Data Pengguna Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/user/delete',
                data: data,
                postfunc: 0
            }
        });
    }else if(selectedClass.hasClass('pengguna-aktif')){
        trigger = 2;
        url = '/admin/user/aktif';
        ajax(url, data, trigger);
    }
});
