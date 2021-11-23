$(document).on('click', '.kemaskini-score, .hantar-score', function(){
    let penilaian_id = $('.penilaian-id').val();
    let competency_id = $('.competency-id').val();

    let url;

    if($(this).hasClass('kemaskini-score')){
        url = '/pengguna/penilaian/score/kemaskini-score';
    }else{
        url = '/pengguna/penilaian/score/hantar-score';
    }

    let data = new FormData;
    data.append('penilaian_id', penilaian_id);
    data.append('_token', getToken());

    ajax(url , data, 0);
})
