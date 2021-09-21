$(document).on('click', '.add-pengguna, .view-pengguna, .delete-pengguna', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-pengguna')){
        postEmptyFields([
            ['.pengguna-nama', 'text'],
            ['.pengguna-email', 'text'],
            ['.pengguna-sektor', 'text'],
            ['.pengguna-cawangan', 'text'],
            ['.pengguna-bahagian', 'text'],
            ['.pengguna-unit', 'text'],
            ['.pengguna-penempatan', 'text'],
        ]);
        $('.pengguna-modal').modal('show');
    }else if(selectedClass.hasClass('view-pengguna')){

    }else if(selectedClass.hasClass('delete-pengguna')){

    }
});

$(document).on('change', '.pengguna-carian', function(){
    let no_ic = $(this).val();
    let data = new FormData;
    data.append('no_ic', no_ic);
    data.append('_token', getToken());
    ajax('/common/pengguna/maklumat', data, 0);
});

$(document).on('click', '.post-add-pengguna', function(){
    let pengguna_nama = $('.pengguna-nama').val();
    let pengguna_email = $('.pengguna-email').val();
    let pengguna_sektor = $('.pengguna-sektor').val();
    let pengguna_cawangan = $('.pengguna-cawangan').val();
    let pengguna_bahagian = $('.pengguna-bahagian').val();
    let pengguna_unit = $('.pengguna-unit').val();
    let pengguna_penempatan = $('.pengguna-penempatan').val();

    let check = checkEmptyFields([
        ['.pengguna-nama', pengguna_nama, 'mix', 'Nama'],
        ['.pengguna-email', pengguna_email, 'mix', 'Emel'],
        ['.pengguna-sektor', pengguna_sektor, 'mix', 'Sektor'],
        ['.pengguna-cawangan', pengguna_cawangan, 'mix', 'Cawangan'],
        ['.pengguna-bahagian', pengguna_bahagian, 'mix', 'Bahagian'],
        ['.pengguna-unit', pengguna_unit, 'mix', 'Unit'],
        ['.pengguna-penempatan', pengguna_penempatan, 'mix', 'Penempatan'],
    ]);

    if(check == false){
        return false;
    }

    let data = new FormData;
    data.append('no_ic', $('.pengguna-carian').val());
    data.append('_token', getToken());

    ajax('/admin/pentadbir/pengguna/tambah', data, 1);
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
                url : '/admin/pentadbir/pengguna/delete',
                data: data,
                postfunc: 0
            }
        });
    }else if(selectedClass.hasClass('pengguna-aktif')){
        trigger = 2;
        url = '/admin/pentadbir/pengguna/aktif';
        ajax(url, data, trigger);
    }
});
