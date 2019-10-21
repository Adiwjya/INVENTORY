<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lapstok
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Lapstok extends CI_Controller{
    
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
            $this->load->view('laporan/stok');
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
                $val[] = $this->Mglobals->getAllQR("SELECT nama_kategori FROM kategori WHERE idkategori = '".$row->idkategori."'")->nama_kategori;
                $val[] = $row->nama_barang;
                $val[] = $row->ukuran;
                // hitung stok
                $masuk = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as masuk FROM barang_masuk_detil where idbarang = '".$row->idbarang."';")->masuk;
                $keluar = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as keluar FROM barang_keluar_detil where idbarang = '".$row->idbarang."';")->keluar;
                $stok = $masuk - $keluar;
                $val[] = $stok;
                
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
            
            $html = $this->load->view('laporan/pdf_stok', $data, true);
            //this the the PDF filename that user will get to download
            $pdfFilePath = "Stok.pdf";
            //load mPDF library
            $this->load->library('m_pdf');
            //generate the PDF from the given html
            //$this->m_pdf->pdf->AddPage('L');
            $this->m_pdf->pdf->WriteHTML($html);
            //download it.
            //$this->m_pdf->pdf->Output($pdfFilePath, "D");
            //view it.
            $this->m_pdf->pdf->Output($pdfFilePath, "I");
        }else{
            $this->modul->halaman('login');
        }
    }
}
