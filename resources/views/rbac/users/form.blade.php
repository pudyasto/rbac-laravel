<form name="form_default" id="form_default" autocomplete="off" method="POST" action="{{$url}}">
    @csrf
    <input type="hidden" name="uuid" id="uuid" value="{{ isset($data->uuid) ? $data->uuid : '' }}">

    <div class="row">

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ isset($data->name) ? $data->name : '' }}" required>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama pengguna" value="{{ isset($data->username) ? $data->username : '' }}" required>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="gender" id="gender">
                    @foreach(gender() as $key => $val)
                    <option value="{{$key}}" {{ (isset($data['gender']) && $data['gender']==$key) ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email pengguna" value="{{ isset($data->email) ? $data->email : '' }}" required>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input autocomplete="new-password" type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
            </div>
        </div>

        <div class="col-sm-12">
            <div class="mb-3">
                <label for="photo" class="form-label">Foto</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
        </div>

        <div class="col-sm-12">
            <div class="mb-3">
                <label for="role_id" class="form-label">Role Pengguna <small>Bisa pilih lebih dari satu</small></label>
                <select class="form-select" name="role_id[]" id="role_id" multiple>
                </select>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="mb-3">
                <label for="is_status" class="form-label">Status</label>
                <select class="form-select" name="status" id="is_status">
                    @foreach(statActive() as $key => $val)
                    <option value="{{$key}}" {{ (isset($data['status']) && $data['status']==$key) ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
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
    var uuid = "{{(isset($data['uuid'])) ? $data['uuid'] : ''}}";
</script>
<script src="{{ asset('/js/rbac/users/form.js?v=' . rand(1,100)) }}"></script>