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
                        toasting('Skill Set Ditambah', 'success');
                    }else{
                        toasting('Skill Set Dikemaskini', 'warning');
                    }
                    $('.scale-skill-set-modal').modal('hide');
                    $('.scale-skill-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Skill Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.scale-skill-set-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-skill-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-skill-set',
                        rowDataClass: 'data-scale-skill-set-id',
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
