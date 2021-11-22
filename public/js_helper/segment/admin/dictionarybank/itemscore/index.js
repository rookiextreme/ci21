$(document).on('click', '.post-submit-item-scores', function(){
    let selectedClass = $(this);

    let scoreArr = [];
    let pass = 0;

    $('.item-score').each(function (){
        let score = $(this).val();
        let itemId = $(this).closest('tr').attr('data-item-id');
        let scoreId = $(this).closest('td[data-grade-id]').attr('data-grade-id');

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
        swalPostFire('error', 'Tidak Berjaya', 'Sila Pastikan Skor dalam Format Yang Betul');
        return false;
    }

    let data = new FormData;
    data.append('scoreArr', JSON.stringify(scoreArr));
    data.append('_token', getToken());
    ajax('/admin/dictionary/bank/penilaian/config/items/scores/save/items', data, 0);
});

//End Grade
