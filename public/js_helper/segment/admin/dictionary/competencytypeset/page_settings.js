$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent()
    });
});

$(document).on('click', '.show-competency-type-page', function (){
    window.location.href = getUrl() + '/admin/dictionary/collection/setting/competency-type';
})

$(document).on('click', '.show-scale-level-page', function (){
    window.location.href = getUrl() + '/admin/dictionary/collection/scale-level';
})

$(document).on('click', '#account-pill-general', function (){
   alert(1);
});
