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
        }
    });
}
