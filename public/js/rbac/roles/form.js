$(function () {
    $(".btn-submit").click(function () {
        submit();
    });
});

function submit() {
    $("#form_default").ajaxForm({
        type: "POST",
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
                $('#form-modal').modal("hide");
                toast(obj.metadata.message, 'Berhasil', 'success');
                $(".btn-refresh").click();
            } else {
                toast(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}