//Grade
$(document).on('click', '.add-agency, .update-agency, .add-penyelaras', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-agency')){

        $('#btn-agency').removeClass('post-update-agency');
        $('#btn-agency').addClass('post-add-agency');
        $('#btn-agency').text('Tambah');
        $('.agency-modal').modal('show');
    }else if(selectedClass.hasClass('update-agency')){
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/get', data, 2);

        $('#btn-agency').removeClass('post-add-agency');
        $('#btn-agency').addClass('post-update-agency');
        $('#btn-agency').text('Kemaskini');
        $('.agency-id').val(agency_id);
        $('.agency-modal').modal('show');
    } else if(selectedClass.hasClass('add-penyelaras')) {
        let agency_id = $(this).closest('tr').attr('data-agency-id');
        $('.agency-id').val(agency_id);
        postEmptyFields([
            ['.pengguna-nama', 'text'],
            ['.pengguna-email', 'text'],
            ['.pengguna-sektor', 'text'],
            ['.pengguna-cawangan', 'text'],
            ['.pengguna-bahagian', 'text'],
            ['.pengguna-unit', 'text'],
            ['.pengguna-penempatan', 'text'],
        ]);
        load_penyelaras_table(agency_id);
        $('.pengguna-modal').modal('show');
    }
});

$(document).on('click', '.post-add-agency, .active-agency, .delete-agency, .post-update-agency', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('post-add-agency')){
        let agency_token = $('.agensi-carian').val();
        let parent_id = $('.parent-agency').val();

        let data = new FormData;
        data.append('agency',agency_token);
        data.append('parent',parent_id);
        data.append('trigger',0);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/save', data, 0);
    } else if(selectedClass.hasClass('active-agency')) {
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/active', data, 1);
    } else if(selectedClass.hasClass('delete-agency')) {
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Agensi Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/setting/agency/delete',
                data: data,
                postfunc: 0
            }
        });

    } else if(selectedClass.hasClass('post-update-agency')) {
        let agency_token = $('.agensi-carian').val();
        let parent_id = $('.parent-agency').val();

        let data = new FormData;
        data.append('agency_id',$('.agency-id').val());
        data.append('agency',agency_token);
        data.append('parent',parent_id);
        data.append('trigger',1);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/save', data, 0);
    }
});

$(document).on('change', '.pengguna-carian', function(){
    let no_ic = $(this).val();
    let data = new FormData;
    data.append('no_ic', no_ic);
    data.append('_token', getToken());
    ajax('/common/user/maklumat', data, 3);
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
        ['.pengguna-nama', 'mix', 'Nama'],
        ['.pengguna-email', 'mix', 'Emel'],
        ['.pengguna-sektor', 'mix', 'Sektor'],
        ['.pengguna-cawangan', 'mix', 'Cawangan'],
        ['.pengguna-bahagian', 'mix', 'Bahagian'],
        ['.pengguna-unit', 'mix', 'Unit'],
        ['.pengguna-penempatan', 'mix', 'Penempatan'],
    ]);

    if(check == false){
        return false;
    }

    let data = new FormData;
    data.append('no_ic', $('.pengguna-carian').val());
    data.append('agency_id',$('.agency-id').val());
    data.append('_token', getToken());

    ajax('pengguna/penyelaras/add', data, 1);
});

$(document).on('click', '.penyelaras-delete', function(){
    let agency_id = $('.agency-id').val();
    let user_id = $(this).closest('tr').attr('data-user-id');

    let data = new FormData;
    data.append('_token', getToken());
    data.append('user_id', user_id);
    data.append('agency_id', agency_id);

    swalAjax({
        titleText : 'Adakah Anda Pasti?',
        mainText : 'Penyelaras Akan Dipadam',
        icon: 'error',
        confirmButtonText: 'Padam',
        postData: {
            url : 'pengguna/penyelaras/delete',
            data: data,
            postfunc: 1
        }
    });
});


