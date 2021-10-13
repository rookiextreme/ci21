//Grade
$(document).on('click', '.add-dict-bank', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-dict-bank')){
        $('.dict-bank-modal').modal('show');
    }
});

$(document).on('click', '.post-add-grade, .post-update-grade', function(){
    let selectedClass = $(this);
    let grade_nama = $('.grade-nama').val();
    let grade_id = $('.grade-id').val();

    let check = checkEmptyFields([
        ['.grade-nama', 'mix', 'Nama'],
    ]);

    if(check == false){
        return false;
    }
    let data = new FormData;

    if(selectedClass.hasClass('post-add-grade')){
        data.append('trigger' , 0);
    }else{
        data.append('grade_id', grade_id);
        data.append('trigger' , 1);
    }

    data.append('grade_nama', grade_nama);
    data.append('_token', getToken());

    ajax('/admin/setting/grade/tambah-kemaskini', data, 0);
});

//End Grade
