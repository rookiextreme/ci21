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
            }else if(postfunc == 4){
                if(success == 1){
                    $('.user-id').val(parseData.user_info.user_id);
                    $('.pengguna-info-nokp').html(parseData.user_info.nric);
                    $('.pengguna-info-penempatan').html(parseData.user_info.penempatan);
                    $('.pengguna-info-telefon').html('(' + parseData.user_info.telefon.bimbit + ')' + ' / ' + '(' + parseData.user_info.telefon.pejabat + ')');

                    if(data['data']['roles'].length > 0){
                        for(var x = 0; x < data['data']['roles'].length; x++){
                            $('.pengguna-role[data-role-id='+ data['data']['roles'][x]['id'] +']').prop('checked', true);
                        }
                    }
                }
            }else if(postfunc == 5){
                if(success == 1){
                    $('#pengguna-modal-info').modal('hide');
                    toasting('Peranan Telah Dikemaskini', 'success');
                }else{
                    toasting('Masalah Telah Berlaku', 'error');
                }
            }
        }
    });
}
