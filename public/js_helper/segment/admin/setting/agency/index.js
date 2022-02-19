//Grade
$(document).on('click', '.add-agency, .update-agency', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('add-agency')){

        $('#btn-agency').removeClass('post-update-agency');
        $('#btn-agency').addClass('post-add-agency');
        $('#btn-agency').text('Tambah');
        $('.agency-modal').modal('show');
    }else if(selectedClass.hasClass('update-agency')){
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/get', data, 2);

        $('#btn-agency').removeClass('post-add-agency');
        $('#btn-agency').addClass('post-update-agency');
        $('#btn-agency').text('Kemaskini');
        $('.agency-id').val(agency_id);
        $('.agency-modal').modal('show');
    }
});

$(document).on('click', '.post-add-agency, .active-agency, .delete-agency, .post-update-agency', function(){
    let selectedClass = $(this);
    if(selectedClass.hasClass('post-add-agency')){
        let agency_token = $('.agensi-carian').val();
        let parent_id = $('.parent-agency').val();

        let data = new FormData;
        data.append('agency',agency_token);
        data.append('parent',parent_id);
        data.append('trigger',0);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/save', data, 0);
    } else if(selectedClass.hasClass('active-agency')) {
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/active', data, 1);
    } else if(selectedClass.hasClass('delete-agency')) {
        let agency_id = $(this).closest('tr').attr('data-agency-id');

        let data = new FormData;
        data.append('agency_id',agency_id);
        data.append('_token', getToken());

        swalAjax({
            titleText : 'Adakah Anda Pasti?',
            mainText : 'Agensi Akan Dipadam',
            icon: 'error',
            confirmButtonText: 'Padam',
            postData: {
                url : '/admin/setting/agency/delete',
                data: data,
                postfunc: 0
            }
        });

    } else if(selectedClass.hasClass('post-update-agency')) {
        let agency_token = $('.agensi-carian').val();
        let parent_id = $('.parent-agency').val();

        let data = new FormData;
        data.append('agency_id',$('.agency-id').val());
        data.append('agency',agency_token);
        data.append('parent',parent_id);
        data.append('trigger',1);
        data.append('_token', getToken());

        ajax('/admin/setting/agency/save', data, 0);
    }
});


