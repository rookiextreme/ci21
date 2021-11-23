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
                    swalPostFire(
                        'success',
                        'Berjaya Disimpan',
                        'Sila Pastikan Setiap Kompetensi Perlu Dijawab Sebelum Menjawab Kompetensi Lain'
                    )
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
                $.unblockUI();
            }
        }
    });
}
