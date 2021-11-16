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
                        toasting('Set Soalan Ditambah', 'success');
                    }else{
                        toasting('Set Soalan Dikemaskini', 'warning');
                    }
                    $('.bank-col-modal').modal('hide');
                    $('.bank-listing-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Telah Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            } else if(postfunc == 1) {
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.bank-col-row',
                        rowId: parseData.id,
                        activeClass: '.active-bank-col',
                        rowDataClass: 'data-bank-col-id',
                        flag: parseData.flag
                    });
                }
            } else if(postfunc == 2) {
                
            }
        }
    });
}
