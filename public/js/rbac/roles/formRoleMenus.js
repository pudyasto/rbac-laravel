$(function () {    
    tableDetail = $('#tableDetail').DataTable({
        processing: true,
        serverSide: true,
        pagingType: 'numbers',
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        columns: [
            { "data": "pilih", "orderable": false },
            { 
                "data": "parent.menu_name",
                render: function (data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                } 
            },
            { "data": "menu_name", },
            { "data": "link", },
            { "data": "description", }
        ],
        order: [
            [1, "asc"]
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
            url: base_url('roles/tableDetailRoleMenus'),
            method: 'POST',
            data: function (d) {
                d.role_id = $("#role_id").val()
            }
        },
        "drawCallback": function (settings) {
            $('.set-rule').on('click', function () {
                var id = $(this).attr('id');
                setRule(id);
            })
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
});

function setRule(id){
    var role_id = $('#role_id').val();
    $.ajax({
        type: "POST",
        url: base_url('roles/storeRoleMenus/' + role_id),
        data: {
            "role_id": role_id
            , "menu_uuid": id
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            tableDetail.ajax.reload();
            if (obj.metadata.code === 200) {
                toast(obj.metadata.message, 'Berhasil', 'success');
            } else {
                toast(obj.metadata.message, 'Kesalahan', 'error');
            }
        }
    });
}