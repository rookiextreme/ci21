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
                let append = '';
                $('.item-checkbox').empty();
                if(parseData.count > 0){
                    let items = parseData.items;
                    items.forEach(function(item){
                        let itemCheck = item.checked == 1 ? 'checked' : '';
                        append += '<tr data-item-id="'+ item.id +'">' +
                                    '<td>' +
                                        item.title +
                                    '</td>' +
                                    '<td>' +
                                        '<div class="form-check form-check-inline">' +
                                            '<input class="form-check-input job-group-set-item" type="checkbox" id="inlineCheckbox1" value="checked" '+ itemCheck +'/>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>';
                    });
                }else{
                    append += '<tr>' +
                                '<td colspan="2" style="text-align: center">' +
                                    'Tiada Item Yang Wujud'+
                                '</td>' +
                            '</tr>';
                }
                $('.item-checkbox').append(append);
            }else if(postfunc == 1){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        swalPostFire('success', 'Berjaya Disimpan', 'Anda Akan Dihala Balik Ke Senarai Job Group');
                        setTimeout(function() {
                            window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/' + $('.penilaian_id').val();
                        }, 1000);
                    }else{
                        swalPostFire('success', 'Kemaskini Berjaya', 'Anda Akan Dihala Balik Ke Senarai Job Group');
                        setTimeout(function() {
                            window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/' + $('.penilaian_id').val();
                        }, 1000);
                    }
                }else if(success == 2){
                    toasting('Rekod Job Group Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 2){
                if(success == 1){
                    $('.grade-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 3){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.grade-row',
                        rowId: parseData.id,
                        activeClass: '.active-grade',
                        rowDataClass: 'data-grade-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
