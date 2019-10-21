<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lapbarcode
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Lapbarcode extends CI_Controller {
    
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
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('laporan/barcode');
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
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    
    public function cetak() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $data['list'] = $this->Mglobals->getAll("barang");
            
            $this->load->view('laporan/pdf_barcode', $data);
        }else{
            $this->modul->halaman('login');
        }
    }
}
