$('.agensi-carian').wrap('<div class="position-relative"></div>').select2({
    dropdownAutoWidth: true,
    dropdownParent: $('.agensi-carian').parent(),
    width: '100%',
    language: {
        inputTooShort: function(){
            return 'Sekurang-kurangnya mengisi 1 huruf...';
        },
        searching: function(){
            return 'Sedang Mencari Agensi...';
        }
    },
    ajax: {
        url: getUrl() + '/common/agency/search',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            let parseData = data.data;
            return {
                results: parseData,
                pagination: {
                    more: params.page * 30 < parseData.length
                }
            };
        },
        cache: true
    },
    placeholder: 'Sila Isi Nama Agensi',
    minimumInputLength: 1,
});

function reload_lookup() {
    $.ajax({
        type:'GET',
        url: getUrl() + '/admin/setting/agency/reload_lookup',
        dataType: "json",
        processData: false,
        contentType: false,
        context: this,
        success: function(data) {
            let success = data.success;
            let parseData = data.data;

            if(success == 1) {
                $('.parent-agency').empty();
                $('.parent-agency').append('<option value="">Sila Pilih Induk</option>');
                parseData.forEach(function (item, index) {
                    $('.parent-agency').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
            }
        }
    })
}
