$(document).ready(function(){
    let search_tahun_id = $('.search_tahun_id').val();
    let search_penilaian_id = $('.search_penilaian_id').val();
    let search_kumpulan_id = $('.search_kumpulan_id').val();

    let search_gred_id = $('.search_gred_id').val();
    let search_jurusan_id = $('.search_jurusan_id').val();
    let search_group_id = $('.search_group_id').val();
    let search_kompetensi_id = $('.search_kompetensi_id').val();

    if(search_tahun_id != '' || typeof search_tahun_id != 'undefined'){
        $('.search-tahun').val(search_tahun_id).trigger('change');
    }

    if(search_jurusan_id != '' || typeof search_jurusan_id != 'undefined'){
        $('.search-jurusan').val(search_jurusan_id).trigger('change');
    }

    setTimeout(function(){
        if($('.search-penilaian').children('option').length > 1){
            $('.search-penilaian').val(search_penilaian_id).trigger('change');

            if(search_penilaian_id != '' || typeof search_penilaian_id != 'undefined'){
                setTimeout(function(){
                    if($('.search-kumpulan').children('option').length > 1){
                        $('.search-kumpulan').val(search_kumpulan_id).trigger('change');

                        if(search_kumpulan_id != '' || typeof search_kumpulan_id != 'undefined'){
                            setTimeout(function(){
                                if($('.search-kumpulan').children('option').length > 1){
                                    $('.search-kumpulan').val(search_kumpulan_id).trigger('change');

                                    if(search_gred_id != '' || typeof search_gred_id != 'undefined'){
                                        setTimeout(function(){
                                            if($('.search-gred').children('option').length > 1){
                                                $('.search-gred').val(search_gred_id).trigger('change');

                                                if(search_group_id != '' || typeof search_group_id != 'undefined'){
                                                    setTimeout(function(){
                                                        if($('.search-job-group').children('option').length > 1){
                                                            $('.search-job-group').val(search_group_id).trigger('change');
                                                            if(search_kompetensi_id != '' || typeof search_kompetensi_id != 'undefined'){
                                                                setTimeout(function(){
                                                                    if($('.search-kompetensi').children('option').length > 1){
                                                                        $('.search-kompetensi').val(search_kompetensi_id).trigger('change');
                                                                    }
                                                                }, 100);
                                                            }
                                                            clearTimeout();
                                                        }
                                                    }, 100);
                                                }
                                                clearTimeout();
                                            }
                                        }, 100);
                                    }
                                    clearTimeout();
                                }
                            }, 100);
                        }
                        clearTimeout();
                    }
                }, 100);
            }
            clearTimeout();
        }
    }, 100);

})

$('.select2').each(function () {
    var $this = $(this);
    $this.wrap('<div class="position-relative"></div>');
    $this.select2({
        dropdownAutoWidth: true,
        width: '100%',
        dropdownParent: $this.parent()
    });
});

$(document).on('change', '.search-tahun', function(){
    let data = new FormData;

    data.append('year', $(this).val());
    data.append('type', 1);
    data.append('_token', getToken());

    ajax('/pelaporan/analisis-jurang-standard-search', data, 0);
})

$(document).on('change', '.search-penilaian', function(){
    let data = new FormData;

    data.append('penilaian_id', $(this).val());
    data.append('type', 2);
    data.append('_token', getToken());

    ajax('/pelaporan/analisis-jurang-standard-search', data, 0);
})
