$(function () {
    if(main_uuid){
        $("#chk_main_menu").attr("checked", false);
    }
    getMainMenu();
    showMainMenu();

    $("#chk_main_menu").click(function () {
        getMainMenu();
        showMainMenu();
    });

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

function getMainMenu() {
    $.ajax({
        type: "POST",
        url: base_url('menus/getMainMenu'),
        data: {
            "request": true
            , "main_uuid": main_uuid
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('#main_uuid').html("");
        },
        success: function (resp) {
            // console.log(resp);
            $.each(resp, function (key, value) {
                $('#main_uuid')
                    .append($("<option></option>")
                        .attr("value", value.uuid)
                        .text(value.menu_name));
                if (main_uuid) {
                    $('#main_uuid').val(main_uuid);
                }
            });
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function showMainMenu() {
    if ($("#chk_main_menu").prop("checked") === true) {
        $("#main_uuid").attr('required', false)
            .attr('disabled', true);
        $(".form-mainmenu").hide();
        $(".form-icon").show();
        $(".menus-main").show();
        if (!link) {
            link = "#";
        }
        $("#link").attr('required', false)
            .val(link);
    } else {
        $("#main_uuid").attr('required', true)
            .attr('disabled', false);
        $("#main_uuid").val(main_uuid);
        $(".form-mainmenu").show();
        $(".form-icon").hide();
        $(".menus-main").hide();
        $('#link').attr('required', true)
            .val(link);
    }
}