//Grade
$(document).on('click', '.add-dict-bank, .btn-submit-bank, .delete-dict-bank, .update-dict-bank, .btn-save-bank, .open-bank-items', function(){

    let selectedClass = $(this);
    if(selectedClass.hasClass('add-dict-bank')){
        postEmptyFields([
            ['.title-bank-text', 'text'],
            ['.year-bank-select', 'dropdown'],
            ['.start-date-bank', 'text'],
            ['.end-date-bank', 'text'],
            ['.select-compentency-type', 'dropdown'],
            ['.select-measuring-lvl', 'dropdown'],
            ['.select-grade-category', 'dropdown'],
            ['.select-grades', 'dropdown'],
        ]);

        $('.hidden-id-bank').val('');
        $('.btn-save-bank').hide();
        $('.btn-submit-bank').show();
        $('.dict-bank-title').html('Tambah Penilaian');
        $('.dict-bank-modal').modal('show');
    } else if(selectedClass.hasClass('btn-submit-bank')){
        let data = new FormData;
        let bank_id = $('.hidden-id-bank').val();
        data.append('_token', getToken());
        data.append('dict_bank_id',bank_id);
        data.append('title', $('.title-bank-text').val());
        data.append('year', $('.year-bank-select').val());
        data.append('start_date', $('.start-date-bank').val());
        data.append('end_date', $('.end-date-bank').val());
        data.append('compentency_type', $('.select-compentency-type').val());
        data.append('measuring_level', $('.select-measuring-lvl').val());
        data.append('grade_category', $('.select-grade-category').val());
        data.append('grades', JSON.stringify($('.select-grades').val()));

        ajax('/admin/dictionary/bank/save_bank',data,1);
    } else if(selectedClass.hasClass('delete-dict-bank')){
        let dict_bank_sets_id = selectedClass.closest('tr').attr('data-dict-bank-id');
        let data = new FormData;
        data.append('_token', getToken());
        data.append('dict_bank_sets_id',dict_bank_sets_id);

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Penilaian Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/delete_bank',
                data: data,
                postfunc: 0
            }
        });
    } else if(selectedClass.hasClass('update-dict-bank')) {
        let dict_bank_sets_id = selectedClass.closest('tr').attr('data-dict-bank-id');
        let data = new FormData;
        data.append('_token', getToken());
        data.append('dict_bank_sets_id',dict_bank_sets_id);

        postEmptyFields([
            ['.title-bank-text', 'text'],
            ['.year-bank-select', 'dropdown'],
            ['.start-date-bank', 'text'],
            ['.end-date-bank', 'text'],
            ['.select-compentency-type', 'dropdown'],
            ['.select-measuring-lvl', 'dropdown'],
            ['.select-grade-category', 'dropdown'],
            ['.select-grades', 'dropdown'],
        ]);

        ajax('/admin/dictionary/bank/load_bank',data,2);

        $('.dict-bank-title').html('Kemaskini Penilaian');
        $('.btn-save-bank').show();
        $('.btn-submit-bank').hide();
        $('.dict-bank-modal').modal('show');
    } else if(selectedClass.hasClass('btn-save-bank')){
        let data = new FormData;
        data.append('_token', getToken());
        let bank_id = $('.hidden-id-bank').val();
        data.append('_token', getToken());
        data.append('dict_bank_id',bank_id);
        data.append('title', $('.title-bank-text').val());
        data.append('year', $('.year-bank-select').val());
        data.append('start_date', $('.start-date-bank').val());
        data.append('end_date', $('.end-date-bank').val());
        data.append('compentency_type', $('.select-compentency-type').val());
        data.append('measuring_level', $('.select-measuring-lvl').val());
        data.append('grade_category', $('.select-grade-category').val());
        data.append('grades', JSON.stringify($('.select-grades').val()));
        data.append('competency_type_id',$('.hidden-id-competency').val());
        data.append('measuring_lvl_id',$('.hidden-id-measuring').val());
        data.append('grade_category_id',$('.hidden-id-grade-catgory').val());

        ajax('/admin/dictionary/bank/update_bank',data,3);
    } else if(selectedClass.hasClass('open-bank-items')){
        let dict_bank_sets_id = selectedClass.closest('tr').attr('data-dict-bank-id');
        window.location.href = getUrl() + '/admin/dictionary/bank/item/'+dict_bank_sets_id;
    }
});

$(document).on('change', '.select-grade-category', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('select-grade-category')) {
        let data = new FormData;
        data.append('grade_category_id', $('.select-grade-category').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/load_grades',data,0);
    }
});
//End Grade
