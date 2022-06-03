$(document).on('click', '.view-detail, .view-caw-detail', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('view-detail')){
        let penilaianId = $(this).closest('tr').attr('data-bank-set-id');
        let year = $(this).closest('tr').attr('data-bank-set-year');
        let data = new FormData;
        data.append('bank_sets_id', penilaianId);
        data.append('year',year);
        data.append('_token', getToken());
        load_caw(data);
    } else if(selectedClass.hasClass('view-caw-detail')){
        let kod_waran = $(this).closest('tr').attr('data-caw-waran-code')
        let bank_sets_id = $(this).closest('tr').attr('data-bank-sets-id')
        let year = $(this).closest('tr').attr('data-year')

        reload_table(bank_sets_id,kod_waran,year);
    }
});
