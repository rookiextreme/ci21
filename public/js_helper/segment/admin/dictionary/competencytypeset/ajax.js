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
                        toasting('Competency Type Set Ditambah', 'success');
                    }else{
                        toasting('Competency Type Set Dikemaskini', 'warning');
                    }
                    $('.competency-type-set-modal').modal('hide');
                    $('.competency-type-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Competency Type Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.competency-type-set-com-type').val(parseData.com_type).trigger('change');
                    $('.competency-type-set-scale-level').val(parseData.scale_level).trigger('change');
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.competency-type-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-competency-type-set',
                        rowDataClass: 'data-competency-type-set-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 3){
                if(success == 1){

                }
            }
        }
    });
}
