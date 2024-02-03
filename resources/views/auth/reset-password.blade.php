@extends('layouts.auth')

@push('style-default')

@endpush

@section('content')


<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Ubah Password</h5>
                    <p class="text-muted">Silahkan ubah password anda</p>
                </div>

                <div class="alert alert-warning mb-2 mx-2 mt-2" role="alert">
                    {{ __('Pastikan password susah ditebak namun mudah diingat.') }}
                </div>

                @if (session('status'))
                <div class="alert alert-success mb-2 mx-2">
                    {!! session('status') !!}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger mb-2 mx-2">
                    <ul class="mb-0 p-0" style="list-style-type:none;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="p-2">
                    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate="">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-4">
                            <label class="form-label">{{ __('Alamat Email') }}</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" tabindex="1" value="{{ old('email', $request->email) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" tabindex="2" placeholder="Masukkan Password Baru" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Ulangi {{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" tabindex="3" name="password_confirmation" placeholder="Ulangi Password Baru " required>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success w-100" type="submit">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form><!-- end form -->
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0">Kembali ke Halaman <a href="{{ url('login') }}" class="fw-semibold text-primary text-decoration-underline"> Login </a> </p>
        </div>

    </div>
</div>

@endsection

@push('script-default')

@endpush