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
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Gred Kategori Ditambah', 'success');
                    }else{
                        toasting('Gred Kategori Dikemaskini', 'warning');
                    }
                    $('.grade-category-modal').modal('hide');
                    $('.grade-category-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Gred Kategori Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.grade-category-nama').val(parseData.name);
                    $('.grade-category-gred-listing').val(parseData.grade_list).trigger('change');
                    // for(let x = 0; x< parseData.grade_list.length; x++){
                    //     $('.grade-category-gred-listing').select2('val', parseData.grade_list[x]);
                    // }
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.grade-category-row',
                        rowId: parseData.id,
                        activeClass: '.active-grade-category',
                        rowDataClass: 'data-grade-category-id',
                        flag: parseData.flag
                    });
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
