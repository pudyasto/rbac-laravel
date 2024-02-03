<input type="hidden" name="role_id" id="role_id" value="{{ isset($data->id) ? $data->id : '' }}">

<div class="table-responsive mt-3">
    <table id="tableDetail" class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" style="width: 80px;">Aktif</th>
                <th>Menu Induk</th>
                <th>Nama Menu</th>
                <th>Path</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Menu Induk</th>
                <th>Nama Menu</th>
                <th>Path</th>
                <th>Deskripsi</th>
            </tr>
        </tfoot>
        <tbody></tbody>
    </table>
</div>


<div class="form-group text-end">
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>

<script defer src="{{ asset('/js/rbac/roles/formRoleMenus.js?v=' . rand(1,100)) }}"></script>