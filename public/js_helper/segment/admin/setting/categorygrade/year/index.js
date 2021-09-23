$(document).on('click', '.catgrade-kategori', function(){
    let year_id = $(this).closest('tr').attr('data-year-id');
    if(year_id != '' || typeof  year_id != 'undefined'){
        window.location.href = getUrl() + '/admin/catgrade/' + year_id
    }
});


