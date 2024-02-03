@extends('layouts.error')

@push('style-default')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="text-center pt-4">
            <div class="">
                <img src="{{ asset('assets/images/error.svg') }}" alt="" class="error-basic-img move-animation">
            </div>
            <div class="mt-n4">
                <h1 class="display-1 fw-medium">419</h1>
                <h3 class="text-uppercase">To Many Request</h3>
                <p class="text-muted mb-4">Maaf, permintaan anda melebihi kapasitas.</p>
                <a href="{{ url('') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Kembali ke halaman depan</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-default')

@endpush