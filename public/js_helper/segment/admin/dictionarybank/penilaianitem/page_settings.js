$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent()
    });
});

$(document).on('click', '.penilaian-config', function(){
    window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/config/' + $(this).closest('tr').attr('data-bank-set-id');
})

$(document).on('click', '.show-config-page', function(){
    window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/config/' + $('.penilaian_id').val();
})

$(document).on('click', '.show-job-group-page', function(){
    window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/job-group/' + $('.penilaian_id').val();
})
