$(document).on('click', '.add-penilaian, .update-penilaian, .delete-penilaian, .active-penilaian, .publish-penilaian, .copy-penilaian', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-penilaian')){
        postEmptyFields([
            ['.penilaian-nama', 'text'],
            ['.penilaian-tahun', 'dropdown'],
            ['.penilaian-tkh-mula', 'text'],
            ['.penilaian-tkh-tamat', 'text'],
        ]);
        $('.post-add-penilaian').attr('style', '');
        $('.post-update-penilaian').attr('style', 'display:none');
        $('.post-copy-penilaian').attr('style', 'display:none');

        $('.penilaian-title').html('Tambah Penilaian');
        $('.penilaian-modal').modal('show');
    }else if(selectedClass.hasClass('update-penilaian')){
        $('.penilaian-id').val(selectedClass.closest('tr').attr('data-bank-set-id'));
        postEmptyFields([
            ['.penilaian-nama', 'text'],
            ['.penilaian-tahun', 'dropdown'],
            ['.penilaian-tkh-mula', 'text'],
            ['.penilaian-tkh-tamat', 'text'],
        ]);
        $('.post-add-penilaian').attr('style', 'display:none');
        $('.post-update-penilaian').attr('style', '');
        $('.post-copy-penilaian').attr('style', 'display:none');

        let data = new FormData;
        data.append('penilaian_id', $('.penilaian-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/get-record', data, 1);
        $('.penilaian-title').html('Kemaskini Penilaian');
        $('.penilaian-modal').modal('show');
    }else if(selectedClass.hasClass('active-penilaian')){
        let penilaian_id = $(this).closest('tr').attr('data-bank-set-id');

        let data = new FormData;
        data.append('penilaian_id', penilaian_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/activate', data, 2);
    }else if(selectedClass.hasClass('delete-penilaian')){
        let penilaian_id = selectedClass.closest('tr').attr('data-bank-set-id');

        let data = new FormData;
        data.append('penilaian_id', penilaian_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Penilaian Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/delete',
                data: data,
                postfunc: 0
            }
        });
    }else if(selectedClass.hasClass('publish-penilaian')){
        let penilaian_id = selectedClass.closest('tr').attr('data-bank-set-id');

        let data = new FormData;
        data.append('penilaian_id', penilaian_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Apabila Penilaian diterbitkan, bahagian tetapan akan tertutup.',
            icon: 'info',
            confirmButtonText: 'Terbit',
            postData: {
                url : '/admin/dictionary/bank/penilaian/publish',
                data: data,
                postfunc: 1
            }
        });
    } else if(selectedClass.hasClass('copy-penilaian')) {
        $('.penilaian-id').val(selectedClass.closest('tr').attr('data-bank-set-id'));
        postEmptyFields([
            ['.penilaian-nama', 'text'],
            ['.penilaian-tahun', 'dropdown'],
            ['.penilaian-tkh-mula', 'text'],
            ['.penilaian-tkh-tamat', 'text'],
        ]);
        $('.post-add-penilaian').attr('style', 'display:none');
        $('.post-update-penilaian').attr('style', 'display:none');
        $('.post-copy-penilaian').attr('style', '');

        let data = new FormData;
        data.append('penilaian_id', $('.penilaian-id').val());
        data.append('_token', getToken());

        $('.penilaian-title').html('Salin Penilaian');
        $('.penilaian-modal').modal('show');
    }
});

$(document).on('click', '.post-add-penilaian, .post-update-penilaian, .post-copy-penilaian', function(){
    let selectedClass = $(this);
    let penilaian_nama = $('.penilaian-nama').val();
    let penilaian_tahun = $('.penilaian-tahun').val();
    let penilaian_tkh_mula = $('.penilaian-tkh-mula').val();
    let penilaian_tkh_tamat = $('.penilaian-tkh-tamat').val();
    let penilaian_id = $('.penilaian-id').val();

    let check = checkEmptyFields([
        ['.penilaian-nama', 'mix', 'Nama'],
        ['.penilaian-tahun', 'int', 'Tahun'],
        ['.penilaian-tkh-mula', 'mix', 'Tarikh Mula'],
        ['.penilaian-tkh-tamat', 'mix', 'Tarikh Tamat'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-penilaian')){
        data.append('trigger' , 0);
    } else if(selectedClass.hasClass('post-copy-penilaian')) {
        data.append('trigger' , 0);
        data.append('penilaian_id', penilaian_id);
    } else{
        data.append('penilaian_id', penilaian_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_nama', penilaian_nama);
    data.append('penilaian_tahun', penilaian_tahun);
    data.append('penilaian_tkh_mula', penilaian_tkh_mula);
    data.append('penilaian_tkh_tamat', penilaian_tkh_tamat);
    data.append('_token', getToken());

    if(selectedClass.hasClass('post-copy-penilaian')) {
        ajax('/admin/dictionary/bank/penilaian/copy', data, 3);
    } else {
        ajax('/admin/dictionary/bank/penilaian/tambah-kemaskini', data, 0);
    }

});
//End Grade
