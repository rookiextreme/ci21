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
                    if(parseData.trigger == 0){
                        toasting('Gred Kategori Ditambah', 'success');
                    }else{
                        toasting('Gred Kategori Dikemaskini', 'warning');
                    }
                    $('.grade-category-modal').modal('hide');
                    $('.grade-category-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Gred Kategori Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 1){
                if(success == 1){
                    $('.grade-category-nama').val(parseData.name);
                    $('.grade-category-gred-listing').val(parseData.grade_list).trigger('change');
                    // for(let x = 0; x< parseData.grade_list.length; x++){
                    //     $('.grade-category-gred-listing').select2('val', parseData.grade_list[x]);
                    // }
                    $.unblockUI();
                }
            }else if(postfunc == 2){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.grade-category-row',
                        rowId: parseData.id,
                        activeClass: '.active-grade-category',
                        rowDataClass: 'data-grade-category-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 3){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Measuring Level Ditambah', 'success');
                    }else{
                        toasting('Measuring Level Dikemaskini', 'warning');
                    }
                    $('.measuring-lvl-modal').modal('hide');
                    $('.measuring-lvl-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Measuring Level Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 4){
                if(success == 1){
                    $('.measuring-lvl-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 5){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.measuring-lvl-row',
                        rowId: parseData.id,
                        activeClass: '.active-measuring-lvl',
                        rowDataClass: 'data-measuring-lvl-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 6){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Competency Type Ditambah', 'success');
                    }else{
                        toasting('Competency Type Dikemaskini', 'warning');
                    }
                    $('.competency-type-modal').modal('hide');
                    $('.competency-type-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Competency Type Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 7){
                if(success == 1){
                    $('.competency-type-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 8){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.competency-type-row',
                        rowId: parseData.id,
                        activeClass: '.active-competency-type',
                        rowDataClass: 'data-competency-type-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 9){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Skill Set Ditambah', 'success');
                    }else{
                        toasting('Skill Set Dikemaskini', 'warning');
                    }
                    $('.scale-skill-set-modal').modal('hide');
                    $('.scale-skill-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Skill Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 10){
                if(success == 1){
                    $('.scale-skill-set-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 11){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-skill-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-skill-set',
                        rowDataClass: 'data-scale-skill-set-id',
                        flag: parseData.flag
                    });
                }
            }if(postfunc == 12){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Scale Level Ditambah', 'success');
                    }else{
                        toasting('Scale Level Dikemaskini', 'warning');
                    }
                    $('.scale-level-modal').modal('hide');
                    $('.scale-level-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Scale Level Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 13){
                if(success == 1){
                    $('.scale-level-nama').val(parseData.name);
                    $.unblockUI();
                }
            }else if(postfunc == 14){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-level-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-level',
                        rowDataClass: 'data-scale-level-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 15){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Scale Level Set Ditambah', 'success');
                    }else{
                        toasting('Scale Level Set Dikemaskini', 'warning');
                    }
                    $('.scale-level-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Scale Level Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 16){
                if(success == 1){
                    $('.scale-level-set-nama').val(parseData.name);
                    $('.scale-level-set-skill-set').val(parseData.skillset).trigger('change');
                    $.unblockUI();
                }
            }else if(postfunc == 17){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.scale-level-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-scale-level-set',
                        rowDataClass: 'data-scale-level-set-id',
                        flag: parseData.flag
                    });
                }
            }else if(postfunc == 18){
                if(success == 1) {
                    if(parseData.trigger == 0){
                        toasting('Competency Type Set Ditambah', 'success');
                    }else{
                        toasting('Competency Type Set Dikemaskini', 'warning');
                    }
                    $('.competency-type-set-modal').modal('hide');
                    $('.competency-type-set-table').DataTable().ajax.reload(null, false);

                }else if(success == 2){
                    toasting('Rekod Competency Type Set Wujud', 'error');
                }else{
                    toasting('Sesuatu Telah Berlaku', 'error');
                }
                $.unblockUI();
            }else if(postfunc == 19){
                if(success == 1){
                    $('.competency-type-set-com-type').val(parseData.com_type).trigger('change');
                    $('.competency-type-set-scale-level').val(parseData.scale_level).trigger('change');
                    $.unblockUI();
                }
            }else if(postfunc == 20){
                if(success == 1) {
                    toggle_activate({
                        rowClass: '.competency-type-set-row',
                        rowId: parseData.id,
                        activeClass: '.active-competency-type-set',
                        rowDataClass: 'data-competency-type-set-id',
                        flag: parseData.flag
                    });
                }
            }
        }
    });
}
