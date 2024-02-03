<?php

use Jenssegers\Agent\Agent;

function formatTransaksi($param)
{
    $a = substr($param, 0, 7);
    $b = substr($param, 7, 4);
    $c = substr($param, 11, 16);
    return $a . '-' . $b . '-' . $c;
}


function formatNamaAkun($nama, $lvl)
{
    $spasi = "";
    for ($i = 0; $i < $lvl; $i++) {
        $spasi .= "&nbsp;";
    }
    return $spasi . preg_replace("/[^a-zA-Z0-9.\s]/", "", $nama);
}

function terbilang($angka)
{
    $angka = (float)$angka;
    $bilangan = array(
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan',
        'sepuluh',
        'sebelas'
    );

    if ($angka < 12) {
        return $bilangan[$angka];
    } else if ($angka < 20) {
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        return sprintf('seratus %s', terbilang($angka - 100));
    } else if ($angka < 1000) {
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        return trim(sprintf('seribu %s', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {

        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'                           
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else {
        return 'Format angka melebihi batas';
    }
}

function formatHp($nohp)
{
    $hp = '';
    // kadang ada penulisan no hp 0811 239 345
    $nohp = preg_replace("[^0-9]", "", $nohp);
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")", "", $nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".", "", $nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if (!preg_match('/[^+0-9]/', trim($nohp))) {
        // cek apakah no hp karakter 1-3 adalah +62
        if (substr(trim($nohp), 0, 3) == '+62') {
            $hp = "0" . substr(trim($nohp), 3, strlen($nohp)); //trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif (substr(trim($nohp), 0, 1) == '0') {
            $hp = $nohp; //'+62'.substr(trim($nohp), 1);
        }
    }
    return $hp;
}

function headerReport()
{
    $header = '<table width="100%" border="0">';
    $header .= '<tr>';
    $header .= '<td style="text-align: left;width: 100px;">';
    $header .= '<img src="/images/logo-header.png" style="width: 100px;">';
    $header .= '</td>';
    $header .= '<td style="text-align: left;vertical-align: top;">';
    $header .= config('app.company_name') . '<br><small>' . config('app.company_addr') . '</small>';
    $header .= '</td>';
    $header .= '<td style="vertical-align: top;width: 320px;">';
    $header .= '</td>';
    $header .= '</tr>';
    $header .= '</table>';
    $header .= '<hr>';
    return $header;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function prev_segments($uri)
{
    $segments = explode('/', str_replace('' . url('') . '', '', $uri));

    return array_values(array_filter($segments, function ($value) {
        return $value !== '';
    }));
}

function getFormatTakademik($value){
    $awal = substr($value, 0,4);
    $akhir = substr($value, 4,4);
    return $awal . '/' . $akhir;
}

function getAgent($value)
{
    $agent = tap(new Agent(), fn ($agent) => $agent->setUserAgent($value));
    return $agent->platform() . ' ( ' . $agent->browser() . ' - ' . $agent->version($agent->browser()) . ' )';
}

function statActive()
{
    $arr = [
        'Aktif' => 'Aktif',
        'Tidak' => 'Tidak',
    ];
    return $arr;
}

function gender()
{
    $arr = [
        'Laki'      => 'Laki',
        'Perempuan' => 'Perempuan',
    ];
    return $arr;
}

function getOperation()
{
    $data = [
        'Create',
        'Read',
        'Update',
        'Destroy',
        'Print',
    ];

    return $data;
}

function thousandsCurrencyFormat($num) {

    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 1) . $units[$i];
  }