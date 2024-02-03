<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <p class="mb-0 text-muted">
                    {{ config('app.name') }}
                    <span> © Dept ICT <?= (date('Y') > 2023) ? '2023 - ' . date('Y') : '2023'; ?></span>
                    <br>
                    <small>
                        Tampilan Terbaik Gunakan
                        <a class="text-muted fw-bold" style="text-decoration: underline;" href="https://www.google.com/chrome/browser/desktop/" target="blank">Google Chrome</a>
                        Terbaru <br> {{'Fw Version :' . app()->version() . ' | Server : ' . phpversion()}}
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>