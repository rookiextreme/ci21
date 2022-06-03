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
                        toasting('Penilaian Ditambah', 'success');
                    }else{
                        toasting('Penilaian Dikemaskini', 'warning');
                    }
                    $('.penilaian-modal').modal('hide');
                    $('.penilaian-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Penilaian Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.penilaian-nama').val(parseData.name);
                    $('.penilaian-tahun').val(parseData.tahun).trigger('change');
                    $('.penilaian-tkh-mula').val(parseData.tkh_mula);
                    $('.penilaian-tkh-tamat').val(parseData.tkh_tamat);
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.penilaian-row',
                        rowId: parseData.id,
                        activeClass: '.active-penilaian',
                        rowDataClass: 'data-bank-set-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 3){
                if(success == 1) {

                    toasting('Penilaian Disalin', 'success');

                    $('.penilaian-modal').modal('hide');
                    $('.penilaian-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Penilaian Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }
        }
    });
}
