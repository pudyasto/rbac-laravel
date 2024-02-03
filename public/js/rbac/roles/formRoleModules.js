$(function () {
    getListModule();

    $(".btn-submit").click(function () {
        submit();
    });
});

function getListModule(){
    $.ajax({
        type: "POST",
        url: base_url('roles/getListModule'),
        data: {
            "role_id": $('#role_id').val()
            , '_token': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
            $('.checkbox-detail').html('');
        },
        success: function (obj) {
            $('.checkbox-detail').html(obj);
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function submit() {
    $("#form_default").ajaxForm({
        type: $("#form_default").attr('method'),
        url: $("#form_default").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                Swal.fire({ title: 'Berhasil', text: obj.metadata.message, icon: 'success'});
                $(".btn-refresh").click();
                $('#form-modal').modal("hide");
            } else {
                Swal.fire({ title: 'Kesalahan', text: obj.metadata.message, icon: 'error'});
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}