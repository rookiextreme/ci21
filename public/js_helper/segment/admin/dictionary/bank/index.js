//Grade
$(document).on('click', '.add-dict-bank, .btn-submit-bank, .delete-dict-bank', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-dict-bank')){
        $('.dict-bank-modal').modal('show');
    } else if(selectedClass.hasClass('btn-submit-bank')){
        let data = new FormData;
        data.append('_token', getToken());
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
