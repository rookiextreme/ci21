//Grade
$(document).on('click', '.add-grade-category, .update-grade-category, .delete-grade-category, .active-grade-category, .delete-grade-category', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-grade-category')){
        postEmptyFields([
            ['.grade-category-nama', 'text'],
            ['.grade-category-grade-listing', 'dropdown'],
        ]);
        $('.post-add-grade-category').attr('style', '');
        $('.post-update-grade-category').attr('style', 'display:none');
        $('.grade-category-title').html('Tambah Gred');
        $('.grade-category-modal').modal('show');
    }else if(selectedClass.hasClass('update-grade-category')){
        $('.grade-category-id').val(selectedClass.closest('tr').attr('data-grade-category-id'));
        postEmptyFields([
            ['.grade-category-nama', 'text'],
            ['.grade-category-grade-listing', 'dropdown'],
        ]);
        $('.post-add-grade-category').attr('style', 'display:none');
        $('.post-update-grade-category').attr('style', '');

        let data = new FormData;
        data.append('grade_category_id', $('.grade-category-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/collection/grade-category/get-record', data, 1);
        $('.grade-category-title').html('Kemaskini Gred');
        $('.grade-category-modal').modal('show');
    }else if(selectedClass.hasClass('active-grade-category')){
        let grade_category_id = $(this).closest('tr').attr('data-grade-category-id');

        let data = new FormData;
        data.append('grade_category_id', grade_category_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/collection/grade-category/activate', data, 2);
    }else if(selectedClass.hasClass('delete-grade-category')){
        let grade_category_id = selectedClass.closest('tr').attr('data-grade-category-id');

        let data = new FormData;
        data.append('grade_category_id', grade_category_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Gred Kategori Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/collection/grade-category/delete',
                data: data,
                postfunc: 0
            }
        });
    }
});

$(document).on('click', '.post-add-grade-category, .post-update-grade-category', function(){
    let selectedClass = $(this);
    let grade_category_nama = $('.grade-category-nama').val();
    let grade_category_grade_listing = $('.grade-category-gred-listing').val();
    let grade_category_id = $('.grade-category-id').val();

    let check = checkEmptyFields([
        ['.grade-category-nama', 'mix', 'Nama'],
    ]);

    let pass = 0;
    if(check == false){
        pass += 1;
    }

    if(grade_category_grade_listing.length === 0){
        toasting('Sila Pilih Senarai Gred', 'error');
        pass += 1;
    }

    if(pass == 1){
        return false;
    }

    let data = new FormData;

    if(selectedClass.hasClass('post-add-grade-category')){
        data.append('trigger' , 0);
    }else{
        data.append('grade_category_id', grade_category_id);
        data.append('trigger' , 1);
    }

    data.append('grade_category_nama', grade_category_nama);
    data.append('grade_category_grade_listing', JSON.stringify(grade_category_grade_listing));
    data.append('_token', getToken());

    ajax('/admin/dictionary/collection/grade-category/tambah-kemaskini', data, 0);
});

//End Grade
