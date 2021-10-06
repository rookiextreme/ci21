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
                        toasting('Dictionary Ditambah', 'success');
                    }else{
                        toasting('Dictionary Dikemaskini', 'warning');
                    }
                    $('.dict-col-modal').modal('hide');
                    $('.dict-listing-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Dictionary Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.dict-col-nama-eng').val(parseData.name_eng);
                    $('.dict-col-nama-melayu').val(parseData.name_mal);
                    $('.dict-col-measuring-level').val(parseData.measuring_level).trigger('change');
                    $('.dict-col-com-type').val(parseData.competency_type).trigger('change');
                    $('.dict-col-jurusan').val(parseData.jurusan).trigger('change');
                    $('.dict-col-grade-category').val(parseData.grade_category).trigger('change');

                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.dict-col-row',
                        rowId: parseData.id,
                        activeClass: '.active-dict-col',
                        rowDataClass: 'data-dict-col-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 3){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Soalan Ditambah', 'success');
                    }else{
                        toasting('Soalan Dikemaskini', 'warning');
                    }

                    $('.dict-listing-ques-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Soalan Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 4){
                if(success == 1){
                    $('.dict-col-ques-nama-eng').val(parseData.name_eng);
                    $('.dict-col-ques-nama-melayu').val(parseData.name_mal);

                    $.unblockUI();
                }
            }else if(postfunc == 5){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.dict-col-ques-row',
                        rowId: parseData.id,
                        activeClass: '.active-dict-col-ques',
                        rowDataClass: 'data-dict-col-ques-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
