<form name="form_default" id="form_default" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data->id) ? $data->id : '' }}">

    <div class="mb-3">
        <label for="menu_name" class="form-label">Nama Menu</label>
        <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Masukkan judul menu" value="{{ isset($data->menu_name) ? $data->menu_name : '' }}" required>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="chk_main_menu" name="chk_main_menu" value="Y" {{ (isset($data->chk_main_menu) && $data->chk_main_menu=='N') ? '' : 'checked' }}>
            <label class="form-check-label" for="chk_main_menu">
                Menu Utama ( Centang jika ini adalah menu utama )
            </label>
        </div>
    </div>

    <div class="mb-3 form-icon">
        <label class="form-label">Nama Menu Header</label>
        <input class="form-control " type="text" name="menu_header" id="menu_header" value="{{ isset($data['menu_header']) ? $data['menu_header'] : '' }}">
    </div>

    <div class="mb-3 form-mainmenu">
        <label class="form-label">Parent Menu</label>
        <select class="form-select " name="main_uuid" id="main_uuid"></select>
    </div>

    <div class="mb-3">
        <label class="form-label">Urutan Menu</label>
        <input class="form-control " type="text" name="menu_order" id="menu_order" value="{{ isset($data['menu_order']) ? $data['menu_order'] : '' }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Class Menu</label>
        <input class="form-control " type="text" name="link" id="link" value="{{ isset($data['link']) ? $data['link'] : '' }}" required>
    </div>

    <div class="mb-3 form-icon">
        <label class="form-label">Icon Menu <a href="https://themesbrand.com/velzon/html/default/icons-remix.html" target="_blank"><small>Contoh Icon</small></a></label>
        <input class="form-control " type="text" name="icon" id="icon" value="{{ isset($data['icon']) ? $data['icon'] : '-' }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea rows="4" class="form-control no-resize" name="description" id="description" placeholder="Deskripsi">{{ isset($data['description']) ? $data['description'] : '' }}</textarea>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="Aktif" {{ (isset($data->is_active) && $data->is_active=='Aktif') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Status Aktif
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_eksternal" name="is_eksternal" value="Ya" {{ (isset($data->is_eksternal) && $data->is_eksternal=='Ya') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_eksternal">
                        Link Ekstenal
                    </label>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_newtab" name="is_newtab" value="Ya" {{ (isset($data->is_newtab) && $data->is_newtab=='Ya') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_newtab">
                        Buka Tab Baru
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-sm btn-primary btn-submit">Simpan</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script>
    var main_uuid = "{{(isset($data['main_uuid'])) ? $data['main_uuid'] : ''}}";
    var link = "{{(isset($data['link'])) ? $data['link'] : ''}}";
</script>
<script src="{{ asset('/js/rbac/menus/form.js?v=' . rand(1,100)) }}"></script>