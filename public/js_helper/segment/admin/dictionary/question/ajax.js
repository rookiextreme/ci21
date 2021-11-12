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
                    $('.select-grades').val(parseData.grade_list).trigger('change');
                    $.unblockUI();
                }
            }else if(postfunc == 1){
                if(success == 1){
                   toasting('Penilaian berjaya disimpan!', 'success');
                   $('.dict-bank-modal').modal('hide');
                   $('.dictionary-bank-table').DataTable().ajax.reload(null, false);
                } else if(success == 2){
                    toasting('Penilaian gagal disimpan!', 'error');
                } else {
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 2){
                if(success == 1) {
                    $('.hidden-id-bank').val(parseData.dict_bank_id);
                    $('.title-bank-text').val(parseData.title);
                    $('.year-bank-select').val(parseData.year).trigger('change');
                    $('.start-date-bank').val(parseData.start_date);
                    $('.end-date-bank').val(parseData.end_date);
                    $('.select-compentency-type').val(parseData.competency_type).trigger('change');
                    $('.hidden-id-competency').val(parseData.competency_type_id);
                    $('.select-measuring-lvl').val(parseData.measuring_level).trigger('change');
                    $('.hidden-id-measuring').val(parseData.measuring_level_id);
                    $('.select-grade-category').val(parseData.grade_category).trigger('change');
                    $('.hidden-id-grade-catgory').val(parseData.grade_category_id);
                    $('.select-grades').val(parseData.grades).trigger('change');

                    $.unblockUI();
                }
            }else if(postfunc == 3){
                if(success == 1){
                   toasting('Penilaian berjaya dikemaskini!', 'success');
                   $('.dict-bank-modal').modal('hide'); 
                }
                $.unblockUI();
            }
        }
    });
}
