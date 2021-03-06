$('.penilaian-tkh-mula').flatpickr({
    enableTime: true,
});

$('.penilaian-tkh-tamat').flatpickr({
    enableTime: true,
});

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

$(document).on('click', '.config-item', function(){
    window.location.href = getUrl() + '/admin/dictionary/bank/penilaian/config/items/' + $(this).closest('tr').attr('data-bank-set-id');
})

