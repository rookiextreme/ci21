$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent()
    });
});

$(document).on('click', '.show-skill-set-page', function (){
    window.location.href = getUrl() + '/admin/dictionary/collection/setting/scale-skill-set';
})
