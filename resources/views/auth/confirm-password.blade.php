@extends('layouts.auth')

@push('style-default')

@endpush

@section('content')


<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Perhatian!</h5>
                    <p class="text-muted">Anda diwajibkan melakukan konfirmasi akun.</p>
                </div>

                <div class="alert alert-warning mb-2 mx-2" role="alert">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                @if (session('status'))
                <div class="alert alert-success mb-2 mx-2">
                    {!! session('status') !!}
                </div>
                @endif
                <div class="p-2">
                    <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" tabindex="1" value="{{ old('password') }}" required autofocus>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success w-100" type="submit">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form><!-- end form -->
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0">Kembali ke <a href="{{ route('home') }}" class="fw-semibold text-primary text-decoration-underline"> Home </a> </p>
        </div>

    </div>
</div>
@endsection

@push('script-default')
@endpush