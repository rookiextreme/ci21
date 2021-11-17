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
                        toasting('Gred Ditambah', 'success');
                    }else{
                        toasting('Gred Dikemaskini', 'warning');
                    }
                    $('.grade-modal').modal('hide');
                    $('.grade-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Gred Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.grade-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.job-group-row',
                        rowId: parseData.id,
                        activeClass: '.active-job-group',
                        rowDataClass: 'data-job-group-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
