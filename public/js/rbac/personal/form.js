$(function () {
    
    $(".btn-submit-profile").click(function () {
        updateProfile();
    });
    
    $(".btn-submit-password").click(function () {
        updatePassword();
    });
});

function updateProfile() {
    $("#form_personal").ajaxForm({
        type: "POST",
        url: $("#form_personal").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                Swal.fire({
                    title: "Berhasil",
                    html: obj.metadata.message,
                    icon: "success"
                }).then((result) => {
                    location.reload();
                });
            } else if (obj.metadata.code === 202) {
                Swal.fire({
                    title: "Informasi",
                    html: obj.metadata.message,
                    icon: "info"
                }).then((result) => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Kesalahan",
                    html: obj.metadata.message,
                    icon: "error"
                })
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}

function updatePassword() {
    $("#form_password").ajaxForm({
        type: "POST",
        url: $("#form_password").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                Swal.fire({
                    title: "Berhasil",
                    html: obj.metadata.message,
                    icon: "success"
                }).then((result) => {
                    location.reload();
                });
            } else if (obj.metadata.code === 202) {
                Swal.fire({
                    title: "Informasi",
                    html: obj.metadata.message,
                    icon: "info"
                }).then((result) => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Kesalahan",
                    html: obj.metadata.message,
                    icon: "error"
                })
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}