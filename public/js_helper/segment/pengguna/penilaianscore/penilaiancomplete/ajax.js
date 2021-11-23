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
                    let trigger = data.trigger;

                    if(trigger == 1){
                        location.reload();
                    }else if(trigger == 2){
                        swalPostFire(
                            'success',
                            'Berjaya Dihantar Kepada Penyelia',
                            'Sila Tunggu Untuk Pengesahan'
                        )
                        setTimeout(function(){
                            window.location.href = getUrl() + '/dashboard/pengguna';
                        }, 1000);
                    }
                }
                $.unblockUI();
            }
        }
    });
}
