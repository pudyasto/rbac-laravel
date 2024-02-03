<form name="form_default" id="form_default" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data->id) ? $data->id : '' }}">

    <div class="mb-3">
        <label for="name" class="form-label">Nama Modul</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama modul" value="{{ isset($data->name) ? $data->name : '' }}" required>
    </div>

    <div class="mb-3">
        <label for="link" class="form-label">Modul Path</label>
        <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan path modul" value="{{ isset($data->link) ? $data->link : '' }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea style="min-height: 100px;" class="form-control no-resize" name="description" id="description" placeholder="Deskripsi">{{ isset($data->description) ? $data->description : '' }}</textarea>
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
        <button type="submit" class="btn btn-sm btn-primary btn-submit">Simpan</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script defer src="{{ asset('/js/rbac/modules/form.js?v=' . rand(1,100)) }}"></script>