//Main Dictionary
$(document).on('click', '.add-dict-col, .update-dict-col, .delete-dict-col, .active-dict-col, .delete-dict-col', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-dict-col')){
        postEmptyFields([
            ['.dict-col-nama-eng', 'text'],
            ['.dict-col-nama-melayu', 'text'],
            ['.dict-col-measuring-level', 'dropdown'],
            ['.dict-col-com-type', 'dropdown'],
            ['.dict-col-jurusan', 'dropdown'],
            ['.dict-col-grade-category', 'dropdown'],
        ]);
        $('.post-add-dict-col').attr('style', '');
        $('.post-update-dict-col').attr('style', 'display:none');
        $('.dict-col-title').html('Tambah Dictionary Item');
        $('.dict-col-modal').modal('show');
    }else if(selectedClass.hasClass('update-dict-col')){
        $('.dict-col-id').val(selectedClass.closest('tr').attr('data-dict-col-id'));
        postEmptyFields([
            ['.dict-col-nama-eng', 'text'],
            ['.dict-col-nama-melayu', 'text'],
            ['.dict-col-measuring-level', 'dropdown'],
            ['.dict-col-com-type', 'dropdown'],
            ['.dict-col-jurusan', 'dropdown'],
            ['.dict-col-grade-category', 'dropdown'],
        ]);

        $('.post-add-dict-col').attr('style', 'display:none');
        $('.post-update-dict-col').attr('style', '');

        let data = new FormData;
        data.append('dict_col_id', $('.dict-col-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/listing/get-record', data, 1);
        $('.dict-col-title').html('Kemaskini Dictionary Item');
        $('.dict-col-modal').modal('show');
    }else if(selectedClass.hasClass('active-dict-col')){
        let dict_col_id = $(this).closest('tr').attr('data-dict-col-id');

        let data = new FormData;
        data.append('dict_col_id', dict_col_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/listing/activate', data, 2);
    }else if(selectedClass.hasClass('delete-dict-col')){
        let dict_col_id = selectedClass.closest('tr').attr('data-dict-col-id');

        let data = new FormData;
        data.append('dict_col_id', dict_col_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Gred Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/listing/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-dict-col, .post-update-dict-col', function(){
    let selectedClass = $(this);

    let dict_col_nama_eng = $('.dict-col-nama-eng').val();
    let dict_col_nama_melayu = $('.dict-col-nama-melayu').val();
    let dict_col_measuring_level = $('.dict-col-measuring-level').val();
    let dict_col_com_type = $('.dict-col-com-type').val();
    let dict_col_jurusan = $('.dict-col-jurusan').val();
    let dict_col_grade_category = $('.dict-col-grade-category').val();

    let dict_col_id = $('.dict-col-id').val();

    let check = checkEmptyFields([
        ['.dict-col-nama-eng', 'mix', 'Nama Bahasa Inggeris'],
        ['.dict-col-measuring-level', 'mix', 'Measuring Level'],
        ['.dict-col-com-type', 'mix', 'Competency Type'],
        ['.dict-col-grade-category', 'mix', 'Grade Category'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-dict-col')){
        data.append('trigger' , 0);
    }else{
        data.append('dict_col_id', dict_col_id);
        data.append('trigger' , 1);
    }

    data.append('dict_col_nama_eng', dict_col_nama_eng);
    data.append('dict_col_nama_melayu', dict_col_nama_melayu);
    data.append('dict_col_measuring_level', dict_col_measuring_level);
    data.append('dict_col_com_type', dict_col_com_type);
    data.append('dict_col_jurusan', dict_col_jurusan);
    data.append('dict_col_grade_category', dict_col_grade_category);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/listing/tambah-kemaskini', data, 0);
});

//End Dictionary

//Dictionary Questions
$(document).on('click', '.update-dict-col-questions-list, .update-dict-col-ques, .post-reset-dict-col-ques, .delete-dict-col-ques, .active-dict-col-ques, .delete-dict-col-ques', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('update-dict-col-questions-list')){
        let item_id = selectedClass.closest('tr').attr('data-dict-col-id');
        postEmptyFields([
            ['.dict-col-ques-nama-eng', 'text'],
            ['.dict-col-ques-nama-melayu', 'text'],
        ]);

        dict_col_ques_table({item_id: item_id});
        $('.dict-col-id').val(item_id);

        $('.post-add-dict-col-ques').attr('style', 'width:100%');
        $('.post-update-dict-col-ques').attr('style', 'display:none');
        $('.post-reset-dict-col-ques').attr('style', 'display:none');
        $('.dict-col-ques-title').html('Set Soalan untuk: ' + $(selectedClass).closest('tr').find('td:first').text());
        $('.dict-col-ques-modal').modal('show');
    }else if(selectedClass.hasClass('update-dict-col-ques')){
        $('.dict-col-ques-id').val(selectedClass.closest('tr').attr('data-dict-col-ques-id'));
        postEmptyFields([
            ['.dict-col-ques-nama-eng', 'text'],
            ['.dict-col-ques-nama-melayu', 'text'],
        ]);

        $('.post-add-dict-col-ques').attr('style', 'display:none');
        $('.post-update-dict-col-ques').attr('style', 'width:100%');
        $('.post-reset-dict-col-ques').attr('style', 'width:100%');

        let data = new FormData;
        data.append('dict_col_ques_id', $('.dict-col-ques-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/listing/ques/get-record', data, 4);
    }else if(selectedClass.hasClass('active-dict-col-ques')){
        let dict_col_ques_id = $(this).closest('tr').attr('data-dict-col-ques-id');

        let data = new FormData;
        data.append('dict_col_ques_id', dict_col_ques_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/listing/ques/activate', data, 5);
    }else if(selectedClass.hasClass('delete-dict-col-ques')){
        let dict_col_ques_id = selectedClass.closest('tr').attr('data-dict-col-ques-id');

        let data = new FormData;
        data.append('dict_col_ques_id', dict_col_ques_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Soalan Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/listing/ques/delete',
                data: data,
                postfunc: 1
            }
        });
    }else if(selectedClass.hasClass('post-reset-dict-col-ques')){
        postEmptyFields([
            ['.dict-col-ques-nama-eng', 'text'],
            ['.dict-col-ques-nama-melayu', 'text'],
        ]);
        $('.post-add-dict-col-ques').attr('style', 'width:100%');
        $('.post-update-dict-col-ques').attr('style', 'display:none');
        $('.post-reset-dict-col-ques').attr('style', 'display:none');
    }
});

$(document).on('click', '.post-add-dict-col-ques, .post-update-dict-col-ques', function(){
    let selectedClass = $(this);

    let dict_col_ques_nama_eng = $('.dict-col-ques-nama-eng').val();
    let dict_col_ques_nama_melayu = $('.dict-col-ques-nama-melayu').val();

    let dict_col_id = $('.dict-col-id').val();
    let dict_col_ques_id = $('.dict-col-ques-id').val();

    let check = checkEmptyFields([
        ['.dict-col-ques-nama-eng', 'mix', 'Nama Bahasa Inggeris'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-dict-col-ques')){
        data.append('trigger' , 0);
    }else{
        data.append('dict_col_ques_id', dict_col_ques_id);
        data.append('trigger' , 1);
    }

    data.append('dict_col_id', dict_col_id);
    data.append('dict_col_ques_nama_eng', dict_col_ques_nama_eng);
    data.append('dict_col_ques_nama_melayu', dict_col_ques_nama_melayu);
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/listing/ques/tambah-kemaskini', data, 3);
});
