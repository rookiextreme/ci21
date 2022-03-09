function ajax(url, data, postfunc){
    // $.blockUI();
    $.ajax({
        type:'POST',
        url: getUrl() + url,
        data:data,
        dataType: "json",
        processData: false,
        contentType: false,
        context: this,
        success: function(data) {
            let success = data.success;
            let parseData = data.data;

            if(postfunc == 0){
                if(data.type == 1){
                    $('.search-penilaian').empty();
                    let append = '<option value="">Sila Pilih</option>';
                    if(parseData.length > 0){
                        parseData.forEach(function(item){
                            append += '<option value="'+ item.id +'">'+ item.title +'</option>';
                        });
                        $('.search-penilaian').append(append);
                    }
                }

                if(data.type == 2){
                    $('.search-kumpulan').empty();
                    $('.search-gred').empty();
                    $('.search-job-group').empty();
                    $('.search-kompetensi').empty();

                    let append_kumpulan = '';
                    let append_gred = '';
                    let append_jg = '';
                    let append_kompetensi = '';

                    append_kumpulan += '<option value="">Sila Pilih</option>';
                    append_gred += '<option value="">Sila Pilih</option>';
                    append_jg += '<option value="">Sila Pilih</option>';
                    append_kompetensi += '<option value="">Sila Pilih</option>';

                    if(Object.keys(parseData).length){
                        if(Object.keys(parseData.kumpulan_with_grade).length > 0){
                            parseData.kumpulan_with_grade.forEach(function(item){
                                append_kumpulan += '<option value="'+ item.id +'">'+ item.name +'</option>';
                                if(Object.keys(item.greds).length > 0){
                                    item.greds.forEach(function(item){
                                        append_gred += '<option value="'+ item.id +'">'+ item.gred_name +'</option>';
                                    })
                                }
                            })
                        }

                        if(Object.keys(parseData.job_group).length > 0){
                            parseData.job_group.forEach(function(item){
                                append_jg += '<option value="'+ item.id +'">'+ item.title +'</option>';
                            })
                        }

                        if(Object.keys(parseData.kompetensi).length > 0){
                            parseData.kompetensi.forEach(function(item){
                                append_kompetensi += '<option value="'+ item.id +'">'+ item.title +'</option>';
                            })
                        }

                        $('.search-kumpulan').append(append_kumpulan);
                        $('.search-gred').append(append_gred);
                        $('.search-job-group').append(append_jg);
                        $('.search-kompetensi').append(append_kompetensi);
                    }
                }
            }else if(postfunc == 1){

            }
        }
    });
}
