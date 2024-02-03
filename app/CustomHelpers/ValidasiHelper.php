<?php

use Illuminate\Support\Facades\Auth;

function errorValidasi($array)
{
    $arr = json_decode($array, true);
    $pesan = '';
    foreach ($arr as $key => $val) {
        foreach ($val as $sub_key => $sub_val) {
            $pesan .= $key . ' ' . $sub_val . '<br>';
        }
    }
    return $pesan;
}

function errorMessage($msg){
    $param = (str_replace("\n", "", str_replace('"', "|", $msg)));
    if(strpos($param,'Cannot add or update a child row: a foreign key constraint fails')){
        return "Data tidak dapat diproses karena id relasi tidak sesuai!";
    }else if (strpos($param, 'foreign key constraint fails')) {
        return "Data tidak dapat dihapus karena terelasi dengan data lain!";
    } else if (strpos(strtolower($param), 'value violates unique constraint')) {
        return "Data tidak boleh sama";
    } else if (strpos(strtolower($param), 'plicate entry')) {
        return "Data tidak boleh sama";
    } else if (strpos(strtolower($param), 'unauthorized')) {
        return "Tidak memiliki hak akses";
    } else if (strpos(strtolower($param), 'of relation')) {
        return "Data tidak dapat diproses karena id relasi yang terhubung!<br>" . $param;
    } else {
        return $param;
    }
}

function getPhoto()
{
    $photo = Auth::user()->photo;
    if($photo){
        return 'data:image/png;base64,'.$photo;
    }else{
        return Auth::user()->profile_photo_url;
    }
}
