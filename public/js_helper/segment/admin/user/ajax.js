function ajax(url, data, postfunc){
    // $.blockUI();
    $.ajax({
        type:'POST',
        url: getUrl() + url,
        data:data,
        dataType: "json",
        processData: false,
        contentType: false,
        context: this,
        success: function(data) {
            let success = data.success;
            let parseData = data.data;

            if(postfunc == 0){
                if(success == 1){
                    if(Object.keys(parseData).length > 1){

                        $('.pengguna-nama').val(parseData.name);
                        $('.pengguna-email').val(parseData.email);
                        $('.pengguna-sektor').val(parseData.waran_name.sektor);
                        $('.pengguna-cawangan').val(parseData.waran_name.cawangan);
                        $('.pengguna-bahagian').val(parseData.waran_name.bahagian);
                        $('.pengguna-unit').val(parseData.waran_name.unit);
                        $('.pengguna-penempatan').val(parseData.waran_name.waran_penuh);
                    }else{
                        toasting('Pengguna Tidak Aktif Lagi Di MYKJ', 'error');
                    }
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.pengguna-modal').modal('hide');
                    $('.pengguna-table').DataTable().ajax.reload(null, false);
                    toasting('Pengguna Ditambah', 'success');
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1){
                    let profile_id = parseData.profile_id;

                    if(parseData.flag == 0){
                        $('.pengguna-row[data-profile-id='+ profile_id +']').find('.pengguna-aktif').removeClass('btn-outline-success').addClass('btn-outline-danger');
                    }else{
                        $('.pengguna-row[data-profile-id='+ profile_id +']').find('.pengguna-aktif').removeClass('btn-outline-danger').addClass('btn-outline-success');
                    }
                    $.unblockUI();
                }
            }else if(postfunc == 3){
                if(success == 1){

                }
            }
        }
    });
}
