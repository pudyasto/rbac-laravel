@extends('layouts.main')

@push('style-default')

@endpush

@section('content')
<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="{{ asset('assets/images/auth-one-bg.jpg') }}" class="profile-wid-img" alt="">
    </div>
</div>

<div class="row">
    <div class="col-xxl-4">
        <div class="card mt-n5">
            <div class="card-body p-4">

                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <img src="{{ getPhoto() }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                    </div>
                    <h5 class="fs-16 mb-1">{{Auth::user()->name}}</h5>
                    <p class="text-muted mb-0">{{Auth::user()->department}}</p>
                </div>

                <div class="table-responsive pt-5">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="ps-0" scope="row">Last Login</td>
                                <td class="text-muted text-end">{{ (Auth::user()->last_login_at) ? datetime_id(Auth::user()->last_login_at) : datetime_id(Auth::user()->created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0" colspan="2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="btn btn-sm btn-danger w-100" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="mdi mdi-logout fs-16 align-middle me-1"></i> 
                                            <span class="align-middle" data-key="t-logout">Logout</span>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-8">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i> Data Personal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i> Ubah Password
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <form novalidate="" name="form_personal" id="form_personal" autocomplete="off" method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" disabled>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" value="{{ Auth::user()->department }}" disabled>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="photo" class="form-label">Foto</label>
                                        <input type="file" class="form-control" name="photo" id="photo" />
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-primary btn-submit-profile">Ubah</button>
                                        <a href="{{ route('personal') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <form novalidate="" name="form_password" id="form_password" autocomplete="off" method="POST" action="{{ route('updatePassword') }}">
                            @csrf
                            <div class="row g-2">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="old_password" class="form-label">Password Saat Ini</label>
                                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Masukkan Password Saat Ini">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div>
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Baru">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div>
                                        <label for="password_confirmation" class="form-label">Ulangi Password Baru</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Ulangi Password Baru">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-primary btn-submit-password">Ubah Password</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@push('script-default')
<script defer src="{{ asset('js/rbac/personal/form.js?v=' . rand(1,100)) }}"></script>
@endpush