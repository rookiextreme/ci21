//Grade
$(document).on('click', '.set-que-bank', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('set-que-bank')) {
        $('.que-bank-modal').modal('show');
    }
    
});

$(document).on('change', '.select-measuring-lvl, .select-com-type, .select-grade-category, .select-jurusan', function(){
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

    ajax('/admin/dictionary/bank/update_bank',data,0);
});
//End Grade
