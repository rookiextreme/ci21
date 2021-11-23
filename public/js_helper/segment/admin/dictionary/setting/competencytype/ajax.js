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
                        toasting('Competency Type Ditambah', 'success');
                    }else{
                        toasting('Competency Type Dikemaskini', 'warning');
                    }
                    $('.competency-type-modal').modal('hide');
                    $('.competency-type-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Competency Type Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.competency-type-nama').val(parseData.name);
                    if(parseData.tech == 1) {
                        $('.tech-chkbox').attr('checked','checked');
                    } else {
                        $('.tech-chkbox').removeAttr('checked');
                    }
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.competency-type-row',
                        rowId: parseData.id,
                        activeClass: '.active-competency-type',
                        rowDataClass: 'data-competency-type-id',
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
