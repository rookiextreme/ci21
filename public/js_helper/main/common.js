var token = $('._token').val();

function dropdown_populate(selectorClass, inputClass, listType, model, queryString = [], postfunc = 0){
    let data = new FormData();
    data.append('model', model);
    data.append('queryString', JSON.stringify(queryString));
    data.append('_token', token);

    ajax_common('POST', '/common/get-listing', data, postfunc, selectorClass, inputClass, listType);
}

function ajax_common(methods,url, data, postfunc, selectorClass, inputClass, listType){
    $.ajax({
        type:methods,
        url:getUrl() + url,
        data:data,
        dataType: "json",
        processData: false,
        contentType: false,
        context: this,
        success: function(data) {
            let append = '';
            let getData = data.data;
            let getDataLength = getData.length;
            if(postfunc === 0) {
                if (data.success === 1) {
                    $(selectorClass).empty();
                    if (getDataLength > 0) {
                        for (let x = 0; x < data.data.length; x++) {
                            if (listType === 'dropdown') {
                                if (x === 0) {
                                    append += '<option value="">Please Select</option>';
                                }
                                append += '<option value="' + data.data[x].value + '">' + data.data[x].label + '</option>';
                            }else if(listType === 'checkbox'){
                                append += '<div class="col-xl-3 col-md-4 col-12">' +
                                    '<div class="form-group">' +
                                        '<div class="custom-control custom-control-primary custom-checkbox">' +
                                            '<input type="checkbox" class="custom-control-input '+ inputClass +'" id="'+ data['data'][x]['value'] +'" data-role-id="'+ data['data'][x]['value'] +'"/>' +
                                            '<label class="custom-control-label" for="'+ data['data'][x]['value'] +'">'+ data['data'][x]['label'] +'</label>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                            }
                        }
                    }
                    $(selectorClass).append(append);
                }
            }else if(postfunc === 1) {
                if (data.success === 1) {
                    $(selectorClass).find('.profile-relation-relation').empty();
                    if (getDataLength > 0) {
                        for (let x = 0; x < data.data.length; x++) {
                            if (listType === 'dropdown') {
                                if (x === 0) {
                                    append += '<option value="">Please Select</option>';
                                }
                                append += '<option value="' + data.data[x].value + '">' + data.data[x].label + '</option>';
                            }
                        }
                    }
                    $(selectorClass).find('.profile-relation-relation').append(append).select2();
                }
            }
        }
    });
}

function getToken(){
    return $('._token').val();
}

function getUrl(){
    return window.location.origin;
}

function previewPhoto({className, previewClass}){
    let file = $(className).get(0).files[0];


    if(file){
        let reader = new FileReader();

        reader.onload = function(){
            $(previewClass).attr("src", reader.result);
        };

        reader.readAsDataURL(file);
    }
}

function reloadDataTableAjax({className, closeModal, modalClass, alert, alertMessage, alertType}){
    $(className).DataTable().ajax.reload(null, false);
    if(closeModal){
        $(modalClass).modal('hide');
    }
    if(alert){
        toasting(alertMessage, alertType);
    }
}

function checkEmptyClause({className}){
    return className.val() == '' || typeof className.val() == 'undefined';
}

function toggle_activate({rowClass, rowDataClass, rowId, activeClass, flag}){
    let removeClass;
    let addClass;

    console.log(flag);
    if(flag == 0){
        removeClass = 'btn-outline-success';
        addClass = 'btn-outline-danger';
        toasting('Telah Dinyahaktifkan', 'error');
    }else{
        removeClass = 'btn-outline-danger';
        addClass = 'btn-outline-success';
        toasting('Telah Diaktifkan', 'success');
    }
    $(''+ rowClass +'['+ rowDataClass +'='+ rowId +']').find(activeClass).removeClass(removeClass).addClass(addClass);
}
