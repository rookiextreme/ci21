$(document).on('click', '.submit-updated-score', function(){
    let pass = 0;

    let score_arr = Array();
    $('.item-penyelia-jawapan').each(function(i, e){
        let index = $(this).attr('data-count');
        let check = checkEmptyFields([
            ['.item-penyelia-jawapan[data-count='+ index +']', 'int', ''],
        ]);

        if(check == false){
            pass = 1;
        }else{
            score_arr.push([$(this).closest('tr').attr('data-item-id'), $(this).val()]);
        }
    });

    if(pass == 1){
        toasting('Sila Pastikan Score Dalam Bentuk Integer', 'error');
        return false;
    }

    let data = new FormData;

    data.append('score_arr', JSON.stringify(score_arr));
    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('_token', getToken());

    swalAjax({
        titleText : 'Adakah Anda Pasti?',
        mainText : 'Penilaian Akan Disahkan Dan Tidak Boleh Dikemaskini',
        icon: 'success',
        confirmButtonText: 'Simpan Dan Hantar',
        postData: {
            url : '/penyelia/pengesahan/new/with-penyelia-send',
            data: data,
            postfunc: 0
        }
    });
});
