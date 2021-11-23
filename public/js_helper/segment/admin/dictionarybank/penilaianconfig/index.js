//Grade
$(document).on('click', '.add-grade-category, .update-grade-category, .delete-grade-category, .active-grade-category', function(){
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

        ajax('/admin/dictionary/bank/penilaian/config/grade-category/get-record', data, 1);
        $('.grade-category-title').html('Kemaskini Gred');
        $('.grade-category-modal').modal('show');
    }else if(selectedClass.hasClass('active-grade-category')){
        let grade_category_id = $(this).closest('tr').attr('data-grade-category-id');

        let data = new FormData;
        data.append('grade_category_id', grade_category_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/grade-category/activate', data, 2);
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
                url : '/admin/dictionary/bank/penilaian/config/grade-category/delete',
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

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('grade_category_nama', grade_category_nama);
    data.append('grade_category_grade_listing', JSON.stringify(grade_category_grade_listing));
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/grade-category/tambah-kemaskini', data, 0);
});
//End Grade

//Measuring lvl
$(document).on('click', '.add-measuring-lvl, .update-measuring-lvl, .delete-measuring-lvl, .active-measuring-lvl, .delete-measuring-lvl', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-measuring-lvl')){
        postEmptyFields([
            ['.measuring-lvl-nama', 'text'],
        ]);
        $('.post-add-measuring-lvl').attr('style', '');
        $('.post-update-measuring-lvl').attr('style', 'display:none');
        $('.measuring-level-title').html('Tambah Measuring Level');
        $('.measuring-lvl-modal').modal('show');
    }else if(selectedClass.hasClass('update-measuring-lvl')){
        $('.measuring-lvl-id').val(selectedClass.closest('tr').attr('data-measuring-lvl-id'));
        postEmptyFields([
            ['.measuring-lvl-nama', 'text'],
        ]);
        $('.post-add-measuring-lvl').attr('style', 'display:none');
        $('.post-update-measuring-lvl').attr('style', '');

        let data = new FormData;
        data.append('measuring_lvl_id', $('.measuring-lvl-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/measuring-level/get-record', data, 4);
        $('.measuring-level-title').html('Kemaskini Measuring Level');
        $('.measuring-lvl-modal').modal('show');
    }else if(selectedClass.hasClass('active-measuring-lvl')){
        let measuring_lvl_id = $(this).closest('tr').attr('data-measuring-lvl-id');

        let data = new FormData;
        data.append('measuring_lvl_id', measuring_lvl_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/measuring-level/activate', data, 5);
    }else if(selectedClass.hasClass('delete-measuring-lvl')){
        let measuring_lvl_id = selectedClass.closest('tr').attr('data-measuring-lvl-id');

        let data = new FormData;
        data.append('measuring_lvl_id', measuring_lvl_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Measuring Level Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/measuring-level/delete',
                data: data,
                postfunc: 1
            }
        });
    }
});

$(document).on('click', '.post-add-measuring-lvl, .post-update-measuring-lvl', function(){
    let selectedClass = $(this);
    let measuring_lvl_nama = $('.measuring-lvl-nama').val();
    let measuring_lvl_id = $('.measuring-lvl-id').val();

    let check = checkEmptyFields([
        ['.measuring-lvl-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-measuring-lvl')){
        data.append('trigger' , 0);
    }else{
        data.append('measuring_lvl_id', measuring_lvl_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('measuring_lvl_nama', measuring_lvl_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/measuring-level/tambah-kemaskini', data, 3);
});
//End Measuring Lvl

//Setting Tab
//Competency Type
$(document).on('click', '.add-competency-type, .update-competency-type, .delete-competency-type, .active-competency-type, .delete-competency-type', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-competency-type')){
        postEmptyFields([
            ['.competency-type-nama', 'text'],
        ]);
        $('.post-add-competency-type').attr('style', '');
        $('.post-update-competency-type').attr('style', 'display:none');
        $('.competency-type-title').html('Tambah Competency Type');
        $('.competency-type-modal').modal('show');
    }else if(selectedClass.hasClass('update-competency-type')){
        $('.competency-type-id').val(selectedClass.closest('tr').attr('data-competency-type-id'));
        postEmptyFields([
            ['.competency-type-nama', 'text'],
        ]);
        $('.post-add-competency-type').attr('style', 'display:none');
        $('.post-update-competency-type').attr('style', '');

        let data = new FormData;
        data.append('competency_type_id', $('.competency-type-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/setting/competency-type/get-record', data, 7);
        $('.competency-type-title').html('Kemaskini Competency Type');
        $('.competency-type-modal').modal('show');
    }else if(selectedClass.hasClass('active-competency-type')){
        let competency_type_id = $(this).closest('tr').attr('data-competency-type-id');

        let data = new FormData;
        data.append('competency_type_id', competency_type_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/setting/competency-type/activate', data, 8);
    }else if(selectedClass.hasClass('delete-competency-type')){
        let competency_type_id = selectedClass.closest('tr').attr('data-competency-type-id');

        let data = new FormData;
        data.append('competency_type_id', competency_type_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Competency Type Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/setting/competency-type/delete',
                data: data,
                postfunc: 2
            }
        });
    }
});

$(document).on('click', '.post-add-competency-type, .post-update-competency-type', function(){
    let selectedClass = $(this);
    let competency_type_nama = $('.competency-type-nama').val();
    let competency_type_id = $('.competency-type-id').val();
    let tech_discipline_flag = 0;

    if($('.tech-chkbox').attr('checked') == 'checked') {
        tech_discipline_flag = 1;
    }

    let check = checkEmptyFields([
        ['.competency-type-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-competency-type')){
        data.append('trigger' , 0);
    }else{
        data.append('competency_type_id', competency_type_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('competency_type_nama', competency_type_nama);
    data.append('tech_discipline_flag',tech_discipline_flag);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/setting/competency-type/tambah-kemaskini', data, 6);
});
//End Competency Type

//Skill Sets
$(document).on('click', '.add-scale-skill-set, .update-scale-skill-set, .delete-scale-skill-set, .active-scale-skill-set, .delete-scale-skill-set', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-scale-skill-set')){
        postEmptyFields([
            ['.scale-skill-set-nama', 'text'],
        ]);
        $('.post-add-scale-skill-set').attr('style', '');
        $('.post-update-scale-skill-set').attr('style', 'display:none');
        $('.scale-skill-set-title').html('Tambah Scale Skill Set');
        $('.scale-skill-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-skill-set')){
        $('.scale-skill-set-id').val(selectedClass.closest('tr').attr('data-scale-skill-set-id'));
        postEmptyFields([
            ['.scale-skill-set-nama', 'text'],
        ]);
        $('.post-add-scale-skill-set').attr('style', 'display:none');
        $('.post-update-scale-skill-set').attr('style', '');

        let data = new FormData;
        data.append('scale_skill_set_id', $('.scale-skill-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/setting/scale-skill-set/get-record', data, 10);
        $('.scale-skill-set-title').html('Kemaskini Scale Skill Set');
        $('.scale-skill-set-modal').modal('show');
    }else if(selectedClass.hasClass('active-scale-skill-set')){
        let scale_skill_set_id = $(this).closest('tr').attr('data-scale-skill-set-id');

        let data = new FormData;
        data.append('scale_skill_set_id', scale_skill_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/setting/scale-skill-set/activate', data, 11);
    }else if(selectedClass.hasClass('delete-scale-skill-set')){
        let scale_skill_set = selectedClass.closest('tr').attr('data-scale-skill-set-id');

        let data = new FormData;
        data.append('scale_skill_set_id', scale_skill_set);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Skill Set Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/setting/scale-skill-set/delete',
                data: data,
                postfunc: 3
            }
        });
    }
});

$(document).on('click', '.post-add-scale-skill-set, .post-update-scale-skill-set', function(){
    let selectedClass = $(this);
    let scale_skill_set_nama = $('.scale-skill-set-nama').val();
    let scale_skill_set_id = $('.scale-skill-set-id').val();

    let check = checkEmptyFields([
        ['.scale-skill-set-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-skill-set')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_skill_set_id', scale_skill_set_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('scale_skill_set_nama', scale_skill_set_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/setting/scale-skill-set/tambah-kemaskini', data, 9);
});
//End Skill Sets
//end Setting Tab

//Scale Level Tab
//Scale Level
$(document).on('click', '.add-scale-level, .update-scale-level, .delete-scale-level, .active-scale-level, .delete-scale-level', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-scale-level')){
        postEmptyFields([
            ['.scale-level-nama', 'text'],
        ]);
        $('.post-add-scale-level').attr('style', '');
        $('.post-update-scale-level').attr('style', 'display:none');
        $('.scale-level-title').html('Tambah Scale Level');
        $('.scale-level-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-level')){
        $('.scale-level-id').val(selectedClass.closest('tr').attr('data-scale-level-id'));
        postEmptyFields([
            ['.scale-level-nama', 'text'],
        ]);
        $('.post-add-scale-level').attr('style', 'display:none');
        $('.post-update-scale-level').attr('style', '');

        let data = new FormData;
        data.append('scale_level_id', $('.scale-level-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/scale-level/get-record', data, 13);
        $('.scale-level-title').html('Kemaskini Scale Level');
        $('.scale-level-modal').modal('show');
    }else if(selectedClass.hasClass('active-scale-level')){
        let scale_level_id = $(this).closest('tr').attr('data-scale-level-id');

        let data = new FormData;
        data.append('scale_level_id', scale_level_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/scale-level/activate', data, 14);
    }else if(selectedClass.hasClass('delete-scale-level')){
        let scale_level_id = selectedClass.closest('tr').attr('data-scale-level-id');

        let data = new FormData;
        data.append('scale_level_id', scale_level_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Scale Level Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/scale-level/delete',
                data: data,
                postfunc: 4
            }
        });
    }
});

$(document).on('click', '.post-add-scale-level, .post-update-scale-level', function(){
    let selectedClass = $(this);
    let scale_level_nama = $('.scale-level-nama').val();
    let scale_level_id = $('.scale-level-id').val();

    let check = checkEmptyFields([
        ['.scale-level-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-level')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_level_id', scale_level_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('scale_level_nama', scale_level_nama);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/scale-level/tambah-kemaskini', data, 12);
});
//End Scale Level

//Scale Level Sets
$(document).on('click', '.update-scale-level-sets, .update-scale-level-set, .reset-scale-level-set, .active-scale-level-set, .delete-scale-level-set', function(){
    let selectedClass = $(this);

    if(selectedClass.hasClass('update-scale-level-sets')){
        let scale_name = selectedClass.closest('tr').find('td:first').text();
        let scale_lvl_id = selectedClass.closest('tr').attr('data-scale-level-id');
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
            ['.scale-level-set-score', 'text']
            
        ]);
        scaleLvlSetTable({
            scale_lvl_id: scale_lvl_id
        });

        $('.post-add-scale-level-set').attr('style', 'width: 100%');
        $('.post-update-scale-level-set').attr('style', 'display:none');
        $('.reset-scale-level-set').attr('style', 'display:none');
        $('.scale-level-id').val(scale_lvl_id);
        $('.scale-level-set-title').html('Scale Level: ' + scale_name);
        $('.scale-level-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-scale-level-set')){
        $('.scale-level-set-id').val(selectedClass.closest('tr').attr('data-scale-level-set-id'));
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
            ['.scale-level-set-score', 'text']
        ]);

        $('.post-add-scale-level-set').attr('style', 'display:none');
        $('.post-update-scale-level-set').attr('style', 'width: 100%');
        $('.reset-scale-level-set').attr('style', 'width: 100%');

        let data = new FormData;
        data.append('scale_level_set_id', $('.scale-level-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/scale-level/set/get-record', data, 16);
    }else if(selectedClass.hasClass('reset-scale-level-set')){
        postEmptyFields([
            ['.scale-level-set-nama', 'text'],
            ['.scale-level-set-skill-set', 'dropdown'],
            ['.scale-level-set-score', 'text']
        ]);
        $('.post-add-scale-level-set').attr('style', 'width: 100%');
        $('.post-update-scale-level-set').attr('style', 'display:none');
        $(selectedClass).attr('style', 'display:none');
    }else if(selectedClass.hasClass('active-scale-level-set')){
        let scale_level_set_id = $(this).closest('tr').attr('data-scale-level-set-id');

        let data = new FormData;
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/scale-level/set/activate', data, 17);
    }else if(selectedClass.hasClass('delete-scale-level-set')){
        let scale_level_set_id = selectedClass.closest('tr').attr('data-scale-level-set-id');

        let data = new FormData;
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Scale Level Set Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/scale-level/set/delete',
                data: data,
                postfunc: 5
            }
        });
    }
});

$(document).on('click', '.post-add-scale-level-set, .post-update-scale-level-set', function(){
    let selectedClass = $(this);
    let scale_level_set_nama = $('.scale-level-set-nama').val();
    let scale_level_set_skill_set = $('.scale-level-set-skill-set').val();
    let scale_level_id = $('.scale-level-id').val();
    let scale_level_set_id = $('.scale-level-set-id').val();
    let scale_level_set_score = $('.scale-level-set-score').val();


    let check = checkEmptyFields([
        ['.scale-level-set-nama', 'mix', 'Nama'],
        ['.scale-level-set-skill-set', 'int', 'Skill Set'],
        ['.scale-level-set-score', 'int', 'Skor'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-scale-level-set')){
        data.append('trigger' , 0);
    }else{
        data.append('scale_level_set_id', scale_level_set_id);
        data.append('trigger' , 1);
    }

    data.append('scale_level_set_nama', scale_level_set_nama);
    data.append('scale_level_set_skill_set', scale_level_set_skill_set);
    data.append('scale_level_id', scale_level_id);
    data.append('scale_level_set_score', scale_level_set_score);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/scale-level/set/tambah-kemaskini', data, 15);
});
//End Scale Level Tab

//Competency Type Set
$(document).on('click', '.add-competency-type-set, .update-competency-type-set, .delete-competency-type-set, .active-competency-type-set, .delete-competency-type-set', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-competency-type-set')){
        postEmptyFields([
            ['.competency-type-set-com-type', 'dropdown'],
            ['.competency-type-set-scale-level', 'dropdown'],
        ]);
        $('.post-add-competency-type-set').attr('style', '');
        $('.post-update-competency-type-set').attr('style', 'display:none');
        $('.competency-type-set-title').html('Tambah Competency Type Set');
        $('.competency-type-set-modal').modal('show');
    }else if(selectedClass.hasClass('update-competency-type-set')){
        $('.competency-type-set-id').val(selectedClass.closest('tr').attr('data-competency-type-set-id'));
        postEmptyFields([
            ['.competency-type-set-com-type', 'dropdown'],
            ['.competency-type-set-scale-level', 'dropdown'],
        ]);
        $('.post-add-competency-type-set').attr('style', 'display:none');
        $('.post-update-competency-type-set').attr('style', '');

        let data = new FormData;
        data.append('competency_type_set_id', $('.competency-type-set-id').val());
        data.append('_token', getToken());

        ajax('/admin/dictionary/bank/penilaian/config/competency-type-set/get-record', data, 19);
        $('.competency-type-set-title').html('Kemaskini Competency Type Set');
        $('.competency-type-set-modal').modal('show');
    }else if(selectedClass.hasClass('active-competency-type-set')){
        let competency_type_set_id = $(this).closest('tr').attr('data-competency-type-set-id');

        let data = new FormData;
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('_token', getToken());
        ajax('/admin/dictionary/bank/penilaian/config/competency-type-set/activate', data, 20);
    }else if(selectedClass.hasClass('delete-competency-type-set')){
        let competency_type_set_id = selectedClass.closest('tr').attr('data-competency-type-set-id');

        let data = new FormData;
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Competency Type Set Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/dictionary/bank/penilaian/config/competency-type-set/delete',
                data: data,
                postfunc: 6
            }
        });
    }
});

$(document).on('click', '.post-add-competency-type-set, .post-update-competency-type-set', function(){
    let selectedClass = $(this);
    let competency_type_set_com_type = $('.competency-type-set-com-type').val();
    let competency_type_set_scale_level = $('.competency-type-set-scale-level').val();
    let competency_type_set_id = $('.competency-type-set-id').val();

    let check = checkEmptyFields([
        ['.competency-type-set-com-type', 'int', 'Competency Type'],
        ['.competency-type-set-scale-level', 'int', 'Scale Level'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-competency-type-set')){
        data.append('trigger' , 0);
    }else{
        data.append('competency_type_set_id', competency_type_set_id);
        data.append('trigger' , 1);
    }

    data.append('penilaian_id', $('.penilaian_id').val());
    data.append('competency_type_set_com_type', competency_type_set_com_type);
    data.append('competency_type_set_scale_level', competency_type_set_scale_level);
    data.append('_token', getToken());

    ajax('/admin/dictionary/bank/penilaian/config/competency-type-set/tambah-kemaskini', data, 18);
});
//End Competency Type Set

