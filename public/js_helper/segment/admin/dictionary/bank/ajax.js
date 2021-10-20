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
                   $('.dictionary-bank-table').DataTable().ajax.reload(null, false);
                } else if(success == 2){
                    toasting('Penilaian gagal disimpan!', 'error');
                } else {
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 2){
                if(success == 1) {
                    toasting('Penilaian berjaya dihapuskan!', 'success');
                    $('.dictionary-bank-table').DataTable().ajax.reload(null, false);
                }
            }else if(postfunc == 3){
                if(success == 1){

                }
            }
        }
    });
}
