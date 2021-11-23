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
                location.reload();
                // if(success == 1) {
                //     if(parseData.trigger == 0){
                //         toasting('Gred Ditambah', 'success');
                //     }else{
                //         toasting('Gred Dikemaskini', 'warning');
                //     }
                // }else if(success == 2){
                //     toasting('Rekod Gred Wujud', 'error');
                // }else{
                //     toasting('Rekod Penyelia Tidak Aktif Dalam MYKJ', 'error');
                // }
                $.unblockUI();
            }
        }
    });
}
