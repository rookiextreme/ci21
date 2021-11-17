$(document).on('click', '.post-add-job-group-score, .post-update-job-group', function(){
    let selectedClass = $(this);

    let scoreArr = [];
    let pass = 0;

    $('.job-group-score').each(function (){
        let score = $(this).val();
        let itemId = $(this).closest('tr').attr('data-item-id');
        let scoreId = $(this).closest('td[data-score-id]').attr('data-score-id');

        if(score != '' || typeof score != 'undefined'){
            if(!/^\d+$/.test(score)){
                pass = 1;
            }else{
                let scoreKeep = [itemId, scoreId, score];
                scoreArr.push(scoreKeep);
            }
        }
    });

    if(pass == 1){
        swalPostFire('error', 'Tidak Berjaya', 'Sila Pastikan Score dalam Format Yang Betul');
        return false;
    }

    let data = new FormData;
    data.append('scoreArr', JSON.stringify(scoreArr));
    data.append('_token', getToken());
    ajax('/admin/dictionary/bank/penilaian/job-group/score/tambah-kemaskini', data, 0);
});

//End Grade
