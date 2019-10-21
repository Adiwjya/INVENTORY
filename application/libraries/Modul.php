<?php
class Modul {
    
    public function getkoneksi() {
        return mysqli_connect("localhost", "root", "", "inventory");
    }
    
    public function pesan_halaman($pesan, $halaman){
        $string_pesan = "<script type='text/javascript'> alert('".$pesan."');";
        $string_pesan .= "window.location = '".base_url().$halaman."';</script>";
        echo $string_pesan;
    }
    
    public function pesan($pesan){
        $string_pesan = "<script type='text/javascript'> alert('".$pesan."');</script>";
        echo $string_pesan;
    }
    
    public function halaman($halaman){
        $string_pesan = "<script type='text/javascript'> ";
        $string_pesan .= "window.location = '".base_url().$halaman."';</script>";
        echo $string_pesan;
    }
    
    public function WaktuSekarang() {
        date_default_timezone_set("Asia/Jakarta");
        return date("H:i:s");
    }

    public function TanggalSekarang() {
        date_default_timezone_set("Asia/Jakarta");
        return date("Y-m-d");
    }
    
    public function tglKode() {
        date_default_timezone_set("Asia/Jakarta");
        return date("dmY");
    }

    public function TanggalWaktu() {
        date_default_timezone_set("Asia/Jakarta");
        return date("Y-m-d H:i:s");
    }
    
    public function getCurTime() {
        date_default_timezone_set("Asia/Jakarta");
        return date("YmdHis");
    }
    
    public function resetAI(){
        $stringreset = "ALTER TABLE dosen AUTO_INCREMENT = 1;";
        return $stringreset;
    }
    
    public function autokode1($depan, $kolom, $table, $awal, $akhir) {
        $hasil = "";
        $q_data = mysqli_query($this->getkoneksi(), "select ifnull(MAX(substr(".$kolom.",".$awal.",".$akhir.")),0) + 1 as jml from ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        $panjang = strlen($data_query['jml']);
        $pnjng_nol = ($akhir-$panjang) - $awal;
        $nol = "";
        for($i=1; $i<=$pnjng_nol; $i++){
            $nol .= "0";
        }
        $hasil = $depan.$nol.$data_query['jml'];
        return $hasil;
    }
    
    public function autokode2($depan, $kolom, $table, $awal, $akhir, $cabang) {
        $hasil = "";
        $q_data = mysqli_query($this->getkoneksi(), "select ifnull(MAX(substr(".$kolom.",".$awal.",".$akhir.")),0) + 1 as jml from ".$table." where idcabang = '".$cabang."';");
        $data_query = mysqli_fetch_array($q_data);
        $panjang = strlen($data_query['jml']);
        $pnjng_nol = ($akhir-$panjang) - $awal;
        $nol = "";
        for($i=1; $i<=$pnjng_nol; $i++){
            $nol .= "0";
        }
        $hasil = $depan.$nol.$data_query['jml'];
        return $hasil;
    }
    
    public function autokodemax($kolom, $table) {
        $q_data = mysqli_query($this->getkoneksi(),"SELECT ifnull(max(".$kolom."),0) + 1 as hasil FROM ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        $hasil = $data_query['hasil'];
        return $hasil;
    }
    
    public function TambahTanggal($tgl, $tambah) {
        return date('Y-m-d', strtotime('+'.$tambah.' days', strtotime($tgl)));
    }
    
    public function TambahMenit($waktu_awal,$menit) {
        date_default_timezone_set("Asia/Jakarta");
        $date = date_create($waktu_awal);
        date_add($date, date_interval_create_from_date_string($menit.' minutes'));
        return date_format($date, 'H:i:s');
    }
    
    public function KurangMenit($waktu_awal,$menit) {
        date_default_timezone_set("Asia/Jakarta");
        $date = date_create($waktu_awal);
        date_add($date, date_interval_create_from_date_string('-'.$menit.' minutes'));
        return date_format($date, 'H:i:s');
    }
    
    public function getUsia($tglLahir) {
	$biday = new DateTime($tglLahir);
	$today = new DateTime();
	$diff = $today->diff($biday);
        return $diff->y;
    }
    
    function getWeeks($date, $rollover){
        $cut        = substr($date, 0, 8);
        $daylen     = 86400;
        $timestamp  = strtotime($date);
        $first      = strtotime($cut . "01");   
        $elapsed    = (($timestamp - $first) / $daylen)+1;
        $i          = 1;
        $weeks      = 0;
        for($i==1; $i<=$elapsed; $i++){
            $dayfind        = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp   = strtotime($dayfind);
            $day            = strtolower(date("l", $daytimestamp));
            if($day == strtolower($rollover)){
                $weeks++;  
            }
        } 
        if($weeks==0){
            $weeks++; 
        }
        return $weeks;  
    }
    
    function weeks_in_month($year, $month, $start_day_of_week){ // Minggu pada bulan ini
        // Total number of days in the given month.
        $num_of_days = date("t", mktime(0,0,0,$month,1,$year));
 
        // Count the number of times it hits $start_day_of_week.
        $num_of_weeks = 0;
        for($i=1; $i<=$num_of_days; $i++){
            $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
            if($day_of_week==$start_day_of_week){
                $num_of_weeks++;
            }
        }
        return $num_of_weeks;
    }
    
    function HariIni() {
        date_default_timezone_set("Asia/Bangkok");
        $tanggal = date("Y-m-d");
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }
    
    function namaHariTglTertentu($tanggal) {
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }

    function weeks($month, $year){
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
        $no_of_weeks = 0; 
        $count_weeks = 0; 
        while($no_of_weeks < $lastday){ 
            $no_of_weeks += 7; 
            $count_weeks++; 
        } 
        return $count_weeks;
    }
    
    public function jmlharibulanini() {
        date_default_timezone_set("Asia/Jakarta");
        $calendar = CAL_GREGORIAN;
        $month = date('m');
        $year = date('Y');
        $hari = cal_days_in_month($calendar, $month, $year);
        return $hari;
    }
    
    public function jmlharibulan($bulan, $tahun) {
        date_default_timezone_set("Asia/Jakarta");
        $calendar = CAL_GREGORIAN;
        $hari = cal_days_in_month($calendar, $bulan, $tahun);
        return $hari;
    }
    
    public function TimeToLong($input){
        $long = strtotime($input);
	return $long;
    }
    
    public function LongToTime($input){
	return date('H:i:s',$input);
    }
    
    public function enkrip_pass($string_normal) {
        require_once 'Chiper.php';
        $cipher = new Chiper(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $kunci = "pramedia"; 
        $en = $cipher->encrypt($string_normal, $kunci);
        return $en;
    }
    
    public function dekrip_pass($string_terenkrip) {
        require_once 'Chiper.php';
        $cipher = new Chiper(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $kunci = "pramedia";
        $de = $cipher->decrypt($string_terenkrip, $kunci);
        return $de;
    }
    
    public function image_text($path) {
        $imgbinary = fread(fopen($path, "r"), filesize($path));
        $img_str = base64_encode($imgbinary);
        return $img_str;
    }
    
    public function img_resize($target, $newcopy, $w, $h, $ext, $scala) {
        list($w_orig, $h_orig) = getimagesize($target);
        
        // menggunakan scala
        if($scala == TRUE){
            $scale_ratio = $w_orig / $h_orig;
            if (($w / $h) > $scale_ratio) {
                $w = $h * $scale_ratio;
            } else {
                $h = $w / $scale_ratio;
            }
        }

        $img = "";
        $ext = strtolower($ext);

        if ($ext == "gif"){ 
            $img = imagecreatefromgif($target);
        } else if($ext =="png"){ 
            $img = imagecreatefrompng($target);
        } else { 
            $img = imagecreatefromjpeg($target);
        }

        $tci = imagecreatetruecolor($w, $h);
        // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)

        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);    
        imagejpeg($tci, $newcopy, 80);
    }
    
    public function terbilang($x){
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12){
            return " " . $abil[$x];
        }else if ($x < 20){
            return terbilang($x - 10) . "belas";
        }else if ($x < 100){
            return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        }elseif ($x < 200){
            return " seratus" . terbilang($x - 100);
        }elseif ($x < 1000){
            return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        }elseif ($x < 2000){
            return " seribu" . terbilang($x - 1000);
        }elseif ($x < 1000000){
            return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        }elseif ($x < 1000000000){
            return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
        }
    }
    
    public function konversi_ke_kecil($jml_kecil, $jml_besar, $jml_datang_besar) {
        $hasil = ($jml_kecil / $jml_besar) * $jml_datang_besar;
        return $hasil;
    }
    
    public function konversi_ke_besar($stok_konversi, $jml_awal, $isi_besar) {
        $hasil = ($stok_konversi / $jml_awal) * $isi_besar;
        return $hasil;
    }
    
    public function format_mata_uang($harga) {
        return number_format($harga, 0 , '' , '.' );
    }
    
    public function enkrip_url($string) {
        $secret_key = "1111111111111111";
        $secret_iv = "2456378494765431";
        $encrypt_method = "aes-256-cbc";
        // hash
        $key = hash("sha256", $secret_key);
        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        //do the encryption given text/string/number
        $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($result);
        return $output;
    }

    public function dekrip_url($string) {
        $secret_key = "1111111111111111";
        $secret_iv = "2456378494765431";
        $encrypt_method = "aes-256-cbc";
        // hash
        $key = hash("sha256", $secret_key);
        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash("sha256", $secret_iv), 0, 16);
        //do the decryption given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}
