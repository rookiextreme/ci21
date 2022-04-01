$(document).on('click', '.view-detail', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('view-detail')){
        let penilaianId = $(this).closest('tr').attr('data-profile-id');
        let data = new FormData;
        data.append('penilaian_id', penilaianId);
        data.append('_token', getToken());


        $('#penyelaras-modal-info').modal('show');
    }
});
