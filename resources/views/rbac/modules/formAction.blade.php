<form name="form_action" id="form_action" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="modules_uuid" id="modules_uuid" value="{{ isset($data->uuid) ? $data->uuid : '' }}">
    <input type="hidden" name="id" id="id" value="">

    <div class="row">
        <div class="col-sm-12">
            <div class="mb-3">
                <label for="name" class="form-label">Path Permission</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan path permission" value="" required>
            </div>
        </div>
    </div>


    <div class="mb-3">
        <label for="description" class="form-label">Keterangan</label>
        <textarea rows="3" class="form-control no-resize" name="description" id="description" placeholder="Deskripsi"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select class="form-control" name="is_active" id="is_active">
            @foreach(statActive() as $key => $val)
            <option value="{{$key}}" {{ (isset($data['is_active']) && $data['is_active']==$key) ? 'selected' : '' }}>{{$val}}</option>
            @endforeach
        </select>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-sm btn-primary btn-submit-action">Simpan</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>

<div class="table-responsive mt-3">
    <table id="tableDetail" class="table table-bordered dt-responsive table-striped align-middle">
        <thead>
            <tr>
                <th>Nama Permission</th>
                <th>Keterangan</th>
                <th style="max-width: 40px !important;">Status</th>
                <th style="max-width: 100px !important;">Aksi</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Nama Permission</th>
                <th>Keterangan</th>
                <th>ID</th>
                <th>ID</th>
            </tr>
        </tfoot>
        <tbody></tbody>
    </table>
</div>

<script defer src="{{ asset('/js/rbac/modules/formAction.js?v=' . rand(1,100)) }}"></script>