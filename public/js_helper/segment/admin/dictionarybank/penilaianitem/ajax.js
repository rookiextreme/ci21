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
                if(success == 1){
                    $('.bank-col-nama-eng').val(parseData.title_eng);
                    $('.bank-col-nama-melayu').val(parseData.title_mal);
                    $('.bank-col-measuring-level').val(parseData.measuring_lvl).trigger('change');
                    $('.bank-col-com-type').val(parseData.competency_type).trigger('change');
                    $('.bank-col-jurusan').val(parseData.jurusan).trigger('change');
                    $('.bank-col-grade-category').val(parseData.grade_category).trigger('change');
                }
            }else if(postfunc == 3){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Soalan Ditambah', 'success');
                    }else{
                        toasting('Soalan Dikemaskini', 'warning');
                    }
                    $('.bank-listing-ques-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Soalan Telah Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
            }else if(postfunc == 4) {
                if(success == 1){
                    $('.bank-col-ques-nama-eng').val(parseData.title_eng);
                    $('.bank-col-ques-nama-melayu').val(parseData.title_mal);
                }
            }else if(postfunc == 5) {
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.bank-col-ques-row',
                        rowId: parseData.id,
                        activeClass: '.active-bank-col-ques',
                        rowDataClass: 'data-bank-col-ques-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
