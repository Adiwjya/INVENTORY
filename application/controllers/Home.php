<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author Rampa Praditya <http://pra-media.com>
 */
class Home extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('Modul');
        $this->load->model('Mglobals');
    }
    
    public function index(){
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['email'] = $session_data['email'];
            $data['golongan'] = $session_data['golongan'];
            $data['nama'] = $session_data['nama'];
            $data['jmlanggota'] = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM anggota;")->jml;
            $data['jmlbarang'] = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM barang;")->jml;
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('content');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAllQ("SELECT a.idanggota, b.idbarang, ifnull(sum(jumlah),0) as jumlah FROM barang_keluar a, barang_keluar_detil b where a.idbk = b.idbk and date(a.tanggal) = '".$this->modul->TanggalSekarang()."' group by b.idbarang;");
            foreach ($list->result() as $row) {
                $val = array();
                $temp_barang = $this->Mglobals->getAllQR("select nama_barang, ukuran, idkategori from barang where idbarang = '".$row->idbarang."';");
                $nama_kategori = $this->Mglobals->getAllQR("select nama_kategori from kategori where idkategori = '".$temp_barang->idkategori."';")->nama_kategori;
                $anggota = $this->Mglobals->getAllQR("select NRP, nama from anggota where idanggota = '".$row->idanggota."';");
                
                $val[] = $anggota->NRP;
                $val[] = $anggota->nama;
                $val[] = $nama_kategori;
                $val[] = $temp_barang->nama_barang;
                $val[] = $temp_barang->ukuran;
                $val[] = $row->jumlah;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function logout(){
        $this->session->unset_userdata('logged_in');
        $this->modul->halaman('login');
    } 
}
