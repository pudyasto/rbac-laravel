<?php


function datetime_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS

    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];
    $dd = substr($dt[2], 0, 2);
    $time = substr($dt[2], 3, strlen($dt[2]));;

    $bulan = array(
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return $dd . " " . $bulan[(int) $mm] . " " . $yyyy . " " . $time;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function datetime_short_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];
    $dd = $dt[2];
    $time = (isset($dt[3])) ? $dt[3] : '';

    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return $dd . " " . $bulan[(int) $mm] . " " . $yyyy . " " . $time;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];

    $bulan = array(
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return  $bulan[(int) $mm] . " " . $yyyy;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_short_id($datetime)
{
    // formate date : YYYY-MM-DD HH:II:SS
    $dt = explode("-", $datetime);
    $yyyy = $dt[0];
    $mm = $dt[1];

    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($mm == 0 || is_numeric($mm) == false) {
        return 'Bulan Tidak Valid ';
    } elseif ($mm <= 12) {
        return  $bulan[(int) $mm] . " " . $yyyy;
    } else {
        return "Format Tanggal Tidak Valid";
    }
}

function month_name_id($int)
{
    $bulan = array(
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    );

    if ($int == 0 || is_numeric($int) == false) {
        return '-';
    } elseif ($int <= 12) {
        return  $bulan[(int) $int];
    } else {
        return "Bulan Tidak Valid";
    }
}

function dateconvert($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[2] . '-' . $date_id[1] . '-' . $date_id[0];
    } else {
        return false;
    }
}

function dateToMonth($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[2] . '-' . $date_id[1];
    } else {
        return false;
    }
}

function monthconvert($date)
{
    if (!empty($date)) {
        $date_id = explode('-', $date);
        return $date_id[1] . '-' . $date_id[0];
    } else {
        return false;
    }
}

function monthAdd($yyyymmdd, $variable)
{
    return date('Y-m-d', strtotime($variable, strtotime($yyyymmdd)));
}

function selisihmenit($datetimestart, $datetimeend)
{
    if (!empty($datetimestart) || !empty($datetimestart)) {
        $awal  = strtotime($datetimestart); //waktu awal

        $akhir = strtotime($datetimeend); //waktu akhir

        $diff  = $akhir - $awal;

        $jam   = floor($diff / (60 * 60));

        $menit = $diff - $jam * (60 * 60);

        return ($jam * 60) + floor($menit / 60);
    } else {
        return 0;
    }
}

function selisihwaktu($datetimestart, $datetimeend)
{
    if (!empty($datetimestart) || !empty($datetimestart)) {
        $awal  = strtotime($datetimestart); //waktu awal

        $akhir = strtotime($datetimeend); //waktu akhir

        $diff  = $akhir - $awal;
        $jam   = floor($diff / (60 * 60));

        $menit = $diff - $jam * (60 * 60);

        return $jam .  ' Jam, ' . floor($menit / 60) . ' Menit';
    } else {
        return 0;
    }
}

function selisihhari($datestart, $dateend)
{
    if (!empty($datestart) || !empty($dateend)) {
        $tgl1 = new DateTime($datestart);
        $tgl2 = new DateTime($dateend);
        $d = $tgl2->diff($tgl1)->days + 1;
        return $d;
    } else {
        return 0;
    }
}

function dateadd($currdate, $days = 1)
{
    if (!empty($currdate)) {
        //to a given date.
        $date = new DateTime($currdate);

        $interval = new DateInterval("P{$days}D");

        //Add the DateInterval object to our DateTime object.
        $date->add($interval);

        //Print out the result.
        return $date->format("Y-m-d");
    } else {
        return 0;
    }
}

function yearadd($currdate, $year = 1)
{
    if (!empty($currdate)) {
        $res = date('Y-m-d', strtotime($year . ' years', strtotime($currdate)));
        return $res;
    } else {
        return 0;
    }
}

function calcPeriode($start_periode, $amount = 12, $period_type = 'M')
{
    $start_periode = monthconvert($start_periode) . '-01';

    $close_periode = new DateTime($start_periode);
    $interval = new DateInterval("P" . ($amount - 1) . $period_type);
    //Add the DateInterval object to our DateTime object.
    $close_periode->add($interval);
    $active_periode = $start_periode;

    return [
        'start_periode' => $start_periode,
        'close_periode' => $close_periode->format("Y-m-t"),
        'active_periode' => $active_periode,
        'start_periode_id' => datetime_id($start_periode),
        'close_periode_id' => datetime_id($close_periode->format("Y-m-t")),
        'active_periode_id' => datetime_id($active_periode),
    ];
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

// Function to get all the dates in given range 
function getDatesFromRange($start, $end, $format = 'Y-m-d')
{
    // Declare an empty array 
    $array = array();
    $data = array();

    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    // Use loop to store date into array 
    foreach ($period as $date) {
        $array[] = $date->format($format);
    }

    // Return the array elements 
    $res = array_unique($array);
    foreach ($res as $val) {
        $data[] = $val;
    }
    return $data;
}

function hitung_umur($param, $param2 = null, $format = 'Ymd')
{
    $date1 = new DateTime(date('Y-m-d', strtotime($param)));
    if (empty($param2)) {
        $date2 = new DateTime(date('Y-m-d'));
    } else {
        $date2 = new DateTime(date($param2));
    }

    $y = '';
    $m = '';
    $d = '';
    $interval = $date1->diff($date2);
    if ($interval->y > '0') {
        $y = $interval->y . " Th ";
    }
    if ($interval->m > '0') {
        $m = $interval->m . " Bln ";
    }
    if ($interval->d > '0') {
        $d = $interval->d . " Hr ";
    }
    if ($format == 'num') {
        return $interval->y . "," . $interval->m . "," . $interval->d;
    } elseif ($format == 'Ymd') {
        return $y . $m . $d;
    } elseif ($format == 'Ym') {
        return $y . $m;
    } elseif ($format == 'Y') {
        return $y;
    } else {
        return $y . $m . $d;
    }
}

function tglKasbon($tahun)
{
    if (!$tahun) {
        $tahun = date('Y');
    }

    $arr = [];

    for ($bln = 1; $bln <= 12; $bln++) {
        $time1 = strtotime($tahun . '-' . $bln . '-' . 15);
        $tgl1 = date('Y-m-d', $time1);

        array_push($arr, $tgl1);

        if ($bln == 2) {
            $time2 = strtotime($tahun . '-' . $bln . '-' . 01);
            $tgl2 = date('Y-m-t', $time2);
        } else {
            $time2 = strtotime($tahun . '-' . $bln . '-' . 30);
            $tgl2 = date('Y-m-d', $time2);
        }

        array_push($arr, $tgl2);

        if ($tgl2 > date('Y-m-d')) {
            break;
        }
    }

    return $arr;
}

function getWeekBasedMonth($period)
{
    $dt = explode('-', $period);
    $numDays = cal_days_in_month(CAL_GREGORIAN, $dt[1], $dt[0]);
    $week = [];
    for ($day = 1; $day <= $numDays; $day++) {
        $wname = weekOfMonth(strtotime($dt[0] . '-' . str_pad($dt[1], 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT)));

        if (!isset($week[$wname])) {
            $week[$wname]['name'] = $wname;
            $week[$wname]['startdate'] = ($dt[0] . '-' . str_pad($dt[1], 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT));
        }

        $week[$wname]['enddate'] = ($dt[0] . '-' . str_pad($dt[1], 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT));
    }

    return $week;
}

function weekOfMonth($date)
{
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}

function weekOfYear($date)
{
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    } else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    } else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}

function hari_ini($hari){
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
 
}

/* 
 * Created by Pudyasto Adi Wibowo
 * Email : pawdev.id@gmail.com
 * pudyasto.wibowo@gmail.com
 */
