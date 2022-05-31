$(document).on('click', '.search-papar', function(event){
    let search_tahun = $('.search-tahun').val();
    let search_penilaian = $('.search-penilaian').val();
    let search_gred = $('.search-gred').val();
    let search_jurusan = $('.search-jurusan').val();
    let search_job_group = $('.search-job-group').val();
    let search_kompetensi = $('.search-kompetensi').val();
    let search_kumpulan = $('.search-kumpulan').val();

    let pass = 0;
    if(search_tahun == '' || typeof search_tahun == 'undefined'){
        toasting('Sila Pilih Tahun', 'error');
        pass = 1;
    }

    if(search_penilaian == '' || typeof search_penilaian == 'undefined'){
        toasting('Sila Pilih Penilaian', 'error');
        pass = 1;
    }

    if(search_kompetensi == '' || typeof search_kompetensi == 'undefined'){
        toasting('Sila Pilih Kompetensi', 'error');
        pass = 1;
    }

    if(search_kumpulan == '' || typeof search_kumpulan == 'undefined'){
        toasting('Sila Pilih Kumpulan', 'error');
        pass = 1;
    }

    if(pass == 1){
        event.preventDefault();
    }

    // let data = new FormData;
    // data.append('search_tahun', search_tahun);
    // data.append('search_penilaian', search_penilaian);
    // data.append('search_gred', search_gred);
    // data.append('search_jurusan', search_jurusan);
    // data.append('search_kumpulan', search_kumpulan);
    // data.append('search_job_group', search_job_group);
    // data.append('search_kompetensi', search_kompetensi);
    // data.append('_token', getToken());

    // ajax('/pelaporan/analisis-jurang-standard-calculate', data, 1);
});

//End Grade
