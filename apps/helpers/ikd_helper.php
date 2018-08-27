<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('dateindo'))
{
    function dateindo($date) 
    {
        $arrbulan = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");
        $tahun    = substr($date, 0, 4);
        $bulan    = substr($date, 5, 2);
        $tgl      = substr($date, 8, 2);
        $result   = $tgl . " " . $arrbulan[(int)$bulan-1] . " ". $tahun;
        return($result);
    }
}

if(!function_exists('avgrate'))
{
    function avgrate($appid)
    {
        $ci =& get_instance();
        $regalkes = $ci->db->query("SELECT ROUND(AVG(score),1) AS RATA FROM t_voted WHERE apps = '1' GROUP BY apps")->row();
        $esuka = $ci->db->query("SELECT ROUND(AVG(score),1) AS RATA FROM t_voted WHERE apps = '2' GROUP BY apps")->row();
        if($appid == 1) $data = $regalkes->RATA;
        if($appid == 2) $data = $esuka->RATA;
        return $data;
    }
}

if(!function_exists('timeago'))
{
    function timeago($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'tahun',
            2592000 => 'bulan',
            604800 => 'minggu',
            86400 => 'hari',
            3600 => 'jam',
            60 => 'menit',
            1 => 'detik'
        );
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' yang lalu':'');
        }
    }
}