$(document).on('click', '#simpan-skor', function(){
    let skorType = $('.skor-type').val();
    let competency_id = $('.competency-id').val();
    let quesArr = [];
    $('.question-ans').each(function(){
        let skorArr = [];
        let ques_id = $(this).attr('data-ques-id');
        let checked_skor = $('.form-check-input[name=q-list-'+ ques_id +']:checked').val();
        if(checked_skor !== '' && typeof checked_skor != 'undefined'){
            skorArr = [ques_id, checked_skor];
            quesArr.push(skorArr);
        }
    });

    let data = new FormData;
    data.append('competency_id', competency_id);
    data.append('quesArr', JSON.stringify(quesArr));
    data.append('_token', getToken());

    ajax('/pengguna/penilaian/score/update-score', data, 0);
})
