function ajax(url, data, postfunc, dom){
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
                if(success == 1){
                    dom.attr('disabled', 'disabled');
                    toasting('Set Soalan berjaya ditambah!', 'success');
                    $('.item-bank-table').DataTable().ajax.reload(null, false);
                }
            } else if(postfunc == 0){
               
            }
        }
    });
}
