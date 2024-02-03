$(function () {
    $(".btn-submit-action").click(function () {
        submitAction();
    });
    
    tableDetail = $('#tableDetail').DataTable({
        processing: true,
        serverSide: true,
        pagingType: 'numbers',
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        columns: [
            { "data": "name", },
            { "data": "description", },
            { 
                "data": "is_active",
                render: function (data, type, row) {
                    return data;
                },
                "className": 'text-center'
            },
            { "data": "btn", "orderable": false }
        ],
        order: [
            [0, "asc"]
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableDetail.hasOwnProperty('settings')) {
                    tableDetail.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('modules/tableDetail'),
            method: 'POST',
            data: function (d) {
                d.modules_uuid = $("#modules_uuid").val()
            }
        },
        sDom: "<'row'<'col-sm-5 mb-0' l ><'col-sm-7 mb-0 text-right'> r> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-right' p>> ",
        oLanguage: {
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Tidak ada data",
            "sProcessing": "Silahkan Tunggu",
            "sInfo": "_START_ - _END_ / _TOTAL_",
            "sInfoFiltered": "",
            "sInfoEmpty": "0 - 0 / 0",
            "infoFiltered": "(_MAX_)",
        }
    });

    $('#tableDetail tfoot th').each(function () {
        var title = $('#tableDetail tfoot th').eq($(this).index()).text();
        if (title.toLowerCase() !== "id") {
            $(this).html('<input type="text" class="form-control" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });

    tableDetail.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            that
                .search(this.value)
                .draw();
        });
    });

    $('#tableDetail tbody').on('click', 'button.btn-edit-detail', function () {
        var data = tableDetail.row($(this).parents('tr')).data();
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        $('#is_active').val(data.is_active);
    });

    $('#tableDetail tbody').on('click', 'button.btn-delete-detail', function () {
        var data = tableDetail.row($(this).parents('tr')).data();
        deleteAction(data.id);
    });
});

function resetDetail() {
    $('#id').val('');
    $('#name').val('');
    $('#description').val('');
    $('#is_active').val('Aktif');
}

function submitAction() {
    $("#form_action").ajaxForm({
        type: "POST",
        url: $("#form_action").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            
            if (obj.metadata.code === 200) {
                resetDetail();
                tableDetail.ajax.reload();
                toast(obj.metadata.message, 'Berhasil', 'success');
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

function deleteAction(id) {
    Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#c9302c",
        confirmButtonText: "Ya, Lanjutkan",
        cancelButtonText: "Tidak, Batalkan"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: base_url('modules/deleteAction/' + id),
                data: {
                    "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    if (obj.metadata.code === 200) {
                        resetDetail();
                        tableDetail.ajax.reload();
                        toast(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        toast(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    pharseError(event, errorThrown);
                }
            });
        }
    });
}