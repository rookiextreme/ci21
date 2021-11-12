function swalAjax({titleText, mainText, icon, confirmButtonText, postData}){
    Swal.fire({
        title: titleText,
        text: mainText,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        customClass: {
            confirmButton: 'btn btn-warning',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            swalAjaxFire(postData);
        }
    });
}


function swalAjaxFire(postData){
    let url = postData.url;
    let data = postData.data;
    let postfunc = postData.postfunc;

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
                    $('.item-bank-table').DataTable().ajax.reload(null, false);
                    swalPostFire('error', 'Berjaya Dipadam', 'Set Soalan Sudah Dipadam');
                }
                $.unblockUI();
            }
        }
    });
}

function swalPostFire(icon, title, mainText){
    Swal.fire({
        icon: icon,
        title: title,
        text: mainText,
        customClass: {
            confirmButton: 'btn btn-success'
        }
    });
}
