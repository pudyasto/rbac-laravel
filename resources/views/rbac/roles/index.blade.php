@extends('layouts.main')

@push('style-default')
<!--datatable css-->

<link rel="stylesheet" href="{{ asset('/plugin/DataTables/datatables.min.css') }}" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <label class="card-title mb-0">Daftar Role Pengguna</label>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <button type="button" class="btn btn-sm btn-primary " data-bs-toggle="modal" data-title="Tambah Data" data-post-id="" data-action-url="roles/create" data-bs-target="#form-modal">Tambah</button>
                    <button type="button" class="btn btn-sm btn-light btn-refresh">
                        Refresh
                    </button>
                </div>

                <div class="table-responsive">
                <table id="tableMain" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th style="width: 40px;">Status</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th>ID</th>
                                <th>ID</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@push('script-default')
<script src="{{ asset('/plugin/DataTables/datatables.min.js') }}"></script>
<script defer src="{{ asset('/js/rbac/roles/index.js?v=' . rand(1,100)) }}"></script>
@endpush