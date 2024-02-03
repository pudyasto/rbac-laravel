@component('mail::message')
 
<p>
    Hi <strong>{{ $data->name }}</strong>, 
    <br>
    apakah anda ingin melakukan reset password ?
    <br>
    Jika benar, Silakan klik tombol di bawah ini,
</p>
    @component('mail::button', ['url' => url('reset-password/' . $account->token)])
        Reset Password
    @endcomponent
<p>
    atau klik link di bawah ini.
    <br>
    <a href="{{ url('reset-password/' . $account->token) }}" target="blank">{{ url('reset-password/' . $account->token) }}</a>
    <br>
    <br>
    Link ini hanya berlaku selama 60 menit.
</p>


<small><i>Abaikan email ini jika anda tidak melakukan permohonan reset password.</i></small>
 
Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent