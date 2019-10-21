<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lapbm
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Lapbm extends CI_Controller{
    
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
            $this->load->view('laporan/barangmasuk');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("barang_masuk");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->idbm;
                $val[] = $row->tanggal;
                $str = '<table class="table table-hover mb-0 ps-container ps-theme-default">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Ukuran</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>';
                $list1 = $this->Mglobals->getAllQ("SELECT * FROM barang_masuk_detil where idbm = '".$row->idbm."';");
                foreach ($list1->result() as $row1) {
                    $barang = $this->Mglobals->getAllQR("select nama_barang, ukuran, idkategori from barang where idbarang = '".$row1->idbarang."';");
                    $nama_kategori = $this->Mglobals->getAllQR("select nama_kategori from kategori where idkategori = '".$barang->idkategori."';")->nama_kategori;
                    $str .= '<tr>';
                    $str .= '<td>'.$barang->nama_barang.'</td>';
                    $str .= '<td>'.$barang->ukuran.'</td>';
                    $str .= '<td>'.$nama_kategori.'</td>';
                    $str .= '<td>'.$row1->jumlah.'</td>';
                    $str .= '</tr>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
                
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
            $data['list'] = $this->Mglobals->getAll("barang_masuk");
            
            $html = $this->load->view('laporan/pdf_bm', $data, true);
            //this the the PDF filename that user will get to download
            $pdfFilePath = "BarangMasuk.pdf";
            //load mPDF library
            $this->load->library('m_pdf');
            //generate the PDF from the given html
            $this->m_pdf->pdf->AddPage('L');
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
