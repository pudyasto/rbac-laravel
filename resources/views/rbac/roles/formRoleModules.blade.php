<form name="form_default" id="form_default" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="role_id" id="role_id" value="{{ isset($data->id) ? $data->id : '' }}">

    <div class="checkbox-detail"></div>

    <div class="form-group text-end">
        <button type="submit" class="btn btn-sm btn-primary btn-submit">
            Simpan
        </button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script defer src="{{ asset('/js/rbac/roles/formRoleModules.js?v=' . rand(1,100)) }}"></script>