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

$(document).on('click', '.show-scale-level-page, .show-competency-type-page, .show-skill-set-page', function(){
    $('#account-pill-setting').click();
})

$(document).on('click', '.show-scale-level-page', function(){
    $('#account-pill-scale-level').click();
})


