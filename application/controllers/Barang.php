<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Barang
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Barang extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('Modul');
        $this->load->model('Mglobals');
    }
    
    public function index() {
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['email'] = $session_data['email'];
            $data['golongan'] = $session_data['golongan'];
            $data['nama'] = $session_data['nama'];
            $data['kategori'] = $this->Mglobals->getAll("kategori");
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('barang/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("barang");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->nama_barang;
                $val[] = $row->ukuran;
                $val[] = $this->Mglobals->getAllQR("SELECT nama_kategori FROM kategori where idkategori = '".$row->idkategori."';")->nama_kategori;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->idbarang."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idbarang."'".','."'".$row->nama_barang."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function coba() {
        echo $this->bar128(stripcslashes("123"));
    }
    
    public function bar128($text) { // Part 1, make list of widths
        $char128asc=' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'; 
        $char128wid = array(
         '212222','222122','222221','121223','121322','131222','122213','122312','132212','221213', // 0-9 
         '221312','231212','112232','122132','122231','113222','123122','123221','223211','221132', // 10-19 
         '221231','213212','223112','312131','311222','321122','321221','312212','322112','322211', // 20-29 
         '212123','212321','232121','111323','131123','131321','112313','132113','132311','211313', // 30-39 
         '231113','231311','112133','112331','132131','113123','113321','133121','313121','211331', // 40-49 
         '231131','213113','213311','213131','311123','311321','331121','312113','312311','332111', // 50-59 
         '314111','221411','431111','111224','111422','121124','121421','141122','141221','112214', // 60-69 
         '112412','122114','122411','142112','142211','241211','221114','413111','241112','134111', // 70-79 
         '111242','121142','121241','114212','124112','124211','411212','421112','421211','212141', // 80-89 
         '214121','412121','111143','111341','131141','114113','114311','411113','411311','113141', // 90-99
         '114131','311141','411131','211412','211214','211232','23311120' ); // 100-106
        $w = $char128wid[$sum = 104]; // START symbol
        $onChar=1;
        for($x=0;$x<strlen($text);$x++){
            if (!( ($pos = strpos($char128asc,$text[$x])) === false )){ // SKIP NOT FOUND CHARS
                $w.= $char128wid[$pos];
                $sum += $onChar++ * $pos;
            } 
            $w.= $char128wid[ $sum % 103 ].$char128wid[106]; //Check Code, then END
            //Part 2, Write rows
            $html="<style>
                    div.b128{
                     border-left: 1px black solid;
                     height: 60px;
                    } 
                    </style><table cellpadding=0 cellspacing=0><tr>"; 
            for($x=0;$x<strlen($w);$x+=2){
                $html .= "<td><div class=\"b128\" style=\"border-left-width:{$w[$x]};width:{$w[$x+1]}\"></div>"; 
            }
        }
        return "$html<tr><td colspan=".strlen($w)." align=center><font family=arial size=2><b>$text</table>";       
    }


    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from barang where nama_barang = '".$this->input->post('nama_barang')."' and ukuran = '".$this->input->post('ukuran')."';")->jml;
            if($cek > 0){
                $status = "Data sudah ada";
            }else{
                $data = array(
                    'idbarang' => $this->modul->autokode1('B','idbarang','barang','2','7'),
                    'nama_barang' => $this->input->post('nama_barang'),
                    'ukuran' => $this->input->post('ukuran'),
                    'idkategori' => $this->input->post('kategori')
                );
                $simpan = $this->Mglobals->add("barang",$data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if($this->session->userdata('logged_in')){
            $kondisi['idbarang'] = $this->uri->segment(3);
            $data = $this->Mglobals->get_by_id("barang", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged_in')){
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
                'ukuran' => $this->input->post('ukuran'),
                'idkategori' => $this->input->post('kategori')
            );
            $condition['idbarang'] = $this->input->post('id');
            $update = $this->Mglobals->update("barang",$data, $condition);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->session->userdata('logged_in')){
            $kondisi['idbarang'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("barang",$kondisi);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
