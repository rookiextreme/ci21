$(document).on('click', '.add-bank-item, .active-bank-col', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-bank-item')){
        postEmptyFields([
            ['.bank-col-nama-eng', 'text'],
            ['.bank-col-nama-melayu', 'text'],
            ['.bank-col-measuring-level', 'dropdown'],
            ['.bank-col-com-type', 'dropdown'],
            ['.bank-col-jurusan', 'dropdown'],
            ['.bank-col-grade-category', 'dropdown'],
        ]);
        $('.post-update-bank-col').hide();
        $('.bank-col-modal').modal('show');
    } else if(selectedClass.hasClass('update-bank-col')){
        $('.bank-col-id').val(selectedClass.closest('tr').attr('data-bank-col-id'));
        postEmptyFields([
            ['.bank-col-nama-eng', 'text'],
            ['.bank-col-nama-melayu', 'text'],
            ['.bank-col-measuring-level', 'dropdown'],
            ['.bank-col-com-type', 'dropdown'],
            ['.bank-col-jurusan', 'dropdown'],
            ['.bank-col-grade-category', 'dropdown'],
        ]);
        $('.post-add-grade').attr('style', 'display:none');
        $('.post-update-grade').attr('style', '');

        let data = new FormData;
        data.append('bank_col_id', $('.bank-col-id').val());
        data.append('_token', getToken());

        ajax('/admin/setting/grade/get-record', data, 1);
        $('.grade-title').html('Kemaskini Gred');
        $('.grade-modal').modal('show');
    } else if(selectedClass.hasClass('active-bank-col')){
        let dict_col_id = $(this).closest('tr').attr('data-bank-col-id');

        let data = new FormData;
        data.append('dict_col_id', dict_col_id);
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/items/active/item',data,1);
    }  else if(selectedClass.hasClass('delete-bank-col')){
        let dict_col_id = $(this).closest('tr').attr('data-bank-col-id');

        let data = new FormData;
        data.append('dict_col_id', dict_col_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Set Soalan Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/items/delete/item',
                data: data,
                postfunc: 0
            }
        });
    }
});
//end
$(document).on('click', '.post-add-bank-col, .post-update-bank-col', function(){
    let selectedClass = $(this);

    let bank_col_nama_eng = $('.bank-col-nama-eng').val();
    let bank_col_nama_melayu = $('.bank-col-nama-melayu').val();
    let bank_col_measuring_level = $('.bank-col-measuring-level').val();
    let bank_col_com_type = $('.bank-col-com-type').val();
    let bank_col_jurusan = $('.bank-col-jurusan').val();
    let bank_col_grade_category = $('.bank-col-grade-category').val();

    let bank_set_id = $('.penilaian_id').val();
    let bank_col_id = $('.bank-col-id').val();

    let check = checkEmptyFields([
        ['.bank-col-nama-eng', 'mix', 'Nama Bahasa Inggeris'],
        ['.bank-col-measuring-level', 'mix', 'Measuring Level'],
        ['.bank-col-com-type', 'mix', 'Competency Type'],
        ['.bank-col-grade-category', 'mix', 'Grade Category'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    data.append('bank_col_nama_eng', bank_col_nama_eng);
    data.append('bank_col_nama_melayu', bank_col_nama_melayu);
    data.append('bank_col_measuring_level', bank_col_measuring_level);
    data.append('bank_col_com_type', bank_col_com_type);
    data.append('bank_col_jurusan', bank_col_jurusan);
    data.append('bank_col_grade_category', bank_col_grade_category);
    data.append('_token', getToken());

    if(selectedClass.hasClass('post-add-bank-col')){
        data.append('bank_set_id', bank_set_id);
        data.append('trigger' , 0);
    }else{
        data.append('bank_set_id', bank_set_id);
        data.append('bank_col_id', bank_col_id);
        data.append('trigger' , 1);
    }

    ajax('/admin/dictionary/bank/penilaian/config/items/save/item', data, 0);
});
