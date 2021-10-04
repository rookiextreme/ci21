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
                        toasting('Scale Level Ditambah', 'success');
                    }else{
                        toasting('Scale Level Dikemaskini', 'warning');
                    }
                    $('.scale-level-modal').modal('hide');
                    $('.scale-level-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Scale Level Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.scale-level-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-level-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-level',
                        rowDataClass: 'data-scale-level-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 3){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Scale Level Set Ditambah', 'success');
                    }else{
                        toasting('Scale Level Set Dikemaskini', 'warning');
                    }
                    $('.scale-level-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Scale Level Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 4){
                if(success == 1){
                    $('.scale-level-set-nama').val(parseData.name);
                    $('.scale-level-set-skill-set').val(parseData.skillset).trigger('change');
                    $.unblockUI();
                }
            }else if(postfunc == 5){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-level-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-level-set',
                        rowDataClass: 'data-scale-level-set-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
