@extends('layouts.auth')

@push('style-default')

@endpush

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Reset Password</h5>
                    <p class="text-muted">Tidak bisa login karena lupa password ?</p>

                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl"></lord-icon>

                </div>

                <div class="alert alert-warning mb-2 mx-2" role="alert">
                    {{ __('Silahkan masukkan email anda, kami akan mengirimkan link untuk mereset password.') }}
                </div>

                @if (session('status'))
                <div class="alert alert-success mb-2 mx-2">
                    {!! session('status') !!}
                </div>
                @endif
                <div class="p-2">
                    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">{{ __('Alamat Email') }}</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" autofocus required>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success w-100" type="submit">
                                {{ __('Kirim Link Reset Password') }}
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">Kembali ke Halaman <a href="{{ url('login') }}" class="fw-semibold text-primary text-decoration-underline"> Login </a> </p>
                        </div>
                    </form><!-- end form -->
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