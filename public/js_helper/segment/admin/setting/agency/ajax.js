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
                        toasting('Agensi Berjaya Ditambah', 'success');
                    }else{
                        toasting('Agensi Berjaya Dikemaskini', 'warning');
                    }
                    $('.agency-modal').modal('hide');
                    $('.agency-table').DataTable().ajax.reload(null, false);

                }else if(success == 2) {
                    toasting('Rekod Agensi Wujud', 'error');
                }else {
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();

            } else if(postfunc == 1){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.agency-row',
                        rowId: parseData.id,
                        activeClass: '.active-agency',
                        rowDataClass: 'data-agency-id',
                        flag: parseData.flag
                    });
                }
            } else if(postfunc == 2){
                if(success == 1){
                    $('.agensi-carian').append('<option value="'+parseData.waran_code+'-'+parseData.name+'">'+parseData.name+' - '+parseData.waran_code+'</option>');
                    $('.parent-agency').val(parseData.parent_id).trigger('cahnge');
                    $.unblockUI();
                }

            } else if(postfunc == 3){

            }
            reload_lookup();
        }
    });
}
