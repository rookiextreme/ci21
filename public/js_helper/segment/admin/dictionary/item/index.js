//Grade
$(document).on('click', '.set-que-list, .add-dict-bank, .add-col-item, .delete-bank-item', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('set-que-list')) {
        $('.bank-items-modal').modal('show');
        
    } else if(selectedClass.hasClass('add-dict-bank')) {
        window.location.href = getUrl() + '/admin/dictionary/bank/';
    } else if(selectedClass.hasClass('add-col-item')) {
        let dict_col_item = selectedClass.closest('tr').attr('data-dict-col-id');
        let data = new FormData;
        data.append('_token', getToken());
        data.append('dict_col_item',dict_col_item);
        data.append('dict_bank_sets_id',bank_id);

        ajax('/admin/dictionary/bank/item/add/item',data,0,selectedClass);
    } else if(selectedClass.hasClass('delete-bank-item')) {
        let dict_bank_item = selectedClass.closest('tr').attr('data-bank-item-id');
        let data = new FormData;
        data.append('_token', getToken());
        data.append('dict_bank_item',dict_bank_item);

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Set Soalan Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/item/delete/item',
                data: data,
                postfunc: 0
            }
        });
    }
    
});

/*$(document).on('change', '.select-measuring-lvl, .select-com-type, .select-grade-category, .select-jurusan', function(){
    let selectedClass = $(this);
    let measure = $('.select-measuring-lvl').val();
    let comptency = $('.select-com-type').val();
    let grade = $('.select-grade-category').val();
    let jurus = $('.select-jurusan').val();
    let data = new FormData;
    data.append('_token', getToken());
    data.append('measuring_level', measure);
    data.append('competency_level', comptency);
    data.append('grade',grade);
    data.append('jurusan',jurus);
    data.append('dict_bank_sets_id',bank_id);

    
});*/
//End Grade
