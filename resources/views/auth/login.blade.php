@extends('layouts.auth')

@push('style-default')

@endpush

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Selamat Datang</h5>
                    <p class="text-muted">Silahkan Masukkan Username dan Password Anda</p>
                </div>
                <div class="p-2 mt-4">

                    @if (session('status'))
                    <div class="mb-3 alert alert-danger">
                        {!! session('status') !!}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 p-0" style="list-style-type:none;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="">
                        </div>

                        <div class="mb-3">

                            @if (Route::has('password.request'))
                                <div class="float-end">
                                    <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot your password?') }}</a>
                                </div>
                            @endif

                            <label class="form-label" for="password-input">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" value="">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

    </div>
</div>
@endsection

@push('script-default')

@endpush