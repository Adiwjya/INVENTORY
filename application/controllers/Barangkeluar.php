<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaksi Barang Keluar
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Barangkeluar extends CI_Controller{
    
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
            $this->load->view('t_keluar/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("barang_keluar");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->idbk;
                $val[] = $row->tanggal;
                $val[] = $this->Mglobals->getAllQR("SELECT nama FROM anggota where idanggota = '".$row->idanggota."';")->nama;
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
                $list1 = $this->Mglobals->getAllQ("SELECT * FROM barang_keluar_detil where idbk = '".$row->idbk."';");
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
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$this->modul->enkrip_url($row->idbk)."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idbk."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function detil() {
        if($this->session->userdata('logged_in')){
            $session_data = $this->session->userdata('logged_in');
            $data['email'] = $session_data['email'];
            $data['golongan'] = $session_data['golongan'];
            $data['nama'] = $session_data['nama'];
            $data['anggota'] = $this->Mglobals->getAll("anggota");
            $kode_enkrip = $this->uri->segment(3);
            if(strlen($kode_enkrip) > 0){
                $kode_dekrip = $this->modul->dekrip_url($kode_enkrip);
                $jml_kode = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM barang_keluar where idbk = '".$kode_dekrip."';")->jml;
                if($jml_kode > 0){
                    $data['kode'] = $kode_dekrip;
                    $data['tanggal'] = $this->Mglobals->getAllQR("SELECT tanggal FROM barang_keluar where idbk = '".$kode_dekrip."';")->tanggal;
                    
                    $anggota = $this->Mglobals->getAllQR("SELECT a.idanggota, a.nama from anggota a, barang_keluar b where a.idanggota = b.idanggota and b.idbk ='".$kode_dekrip."';");
                    
                    $data['idanggota'] = $anggota->idanggota;
                    $data['namaanggota'] = $anggota->nama;
                }else{
                    $this->modul->halaman('barangkeluar');
                }
            }else{
                $data['kode'] = $this->modul->autokode1('K','idbk','barang_keluar','2','7');
                $data['tanggal'] = $this->modul->TanggalWaktu();
                $data['idanggota'] = "";
                $data['namaanggota'] = "";
            }
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('t_keluar/detil');
            $this->load->view('footer');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from barang_keluar where idbk = '".$this->input->post('idbk')."';")->jml;
            $jml = $this->Mglobals->getAllQR("select jumlah from barang_masuk_detil where idbarang = '".$this->input->post('kode_barang')."';")->jumlah;
            if($cek > 0){
                
                if($jml >= $this->input->post('jumlah')){
                    $status = $this->simpandetil();
                }else{
                    $status = "Jumlah melebihi Stok yang tersedia";
                }
            }else{
                if($jml >= $this->input->post('jumlah')){
                    $status = $this->simpanhead_detil();
                }else{
                    $status = "Jumlah melebihi Stok yang tersedia";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpanhead_detil() {
        $data = array(
            'idbk' => $this->input->post('idbk'),
            'tanggal' => $this->input->post('tanggal'),
            'idanggota' => $this->input->post('idanggota'),
        );
        $simpan = $this->Mglobals->add("barang_keluar",$data);
        if($simpan == 1){
            $data_detil = array(
                'idbk_detil' => $this->modul->autokode1('D','idbk_detil','barang_keluar_detil','2','8'),
                'idbarang' => $this->input->post('kode_barang'),
                'jumlah' => $this->input->post('jumlah'),
                'idbk' => $this->input->post('idbk')
            );
            $simpan1 = $this->Mglobals->add("barang_keluar_detil",$data_detil);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }    
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function simpandetil() {
        $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM barang_keluar_detil where idbarang = '".$this->input->post('kode_barang')."' and idbk = '".$this->input->post('idbk')."';")->jml;
        if($jml > 0){
            $jmllama = $this->Mglobals->getAllQR("SELECT jumlah FROM barang_keluar_detil where idbarang = '".$this->input->post('kode_barang')."' and idbk = '".$this->input->post('idbk')."';")->jumlah;
            $jmlbaru = $jmllama + $this->input->post('jumlah');
            
            $data_detil = array(
                'jumlah' => $jmlbaru
            );
            $kond['idbarang'] = $this->input->post('kode_barang');
            $kond['idbk'] = $this->input->post('idbk');
            $simpan1 = $this->Mglobals->update("barang_keluar_detil",$data_detil, $kond);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }else{
            $data_detil = array(
                'idbk_detil' => $this->modul->autokode1('D','idbk_detil','barang_keluar_detil','2','8'),
                'idbarang' => $this->input->post('kode_barang'),
                'jumlah' => $this->input->post('jumlah'),
                'idbk' => $this->input->post('idbk')
            );
            $simpan1 = $this->Mglobals->add("barang_keluar_detil",$data_detil);
            if($simpan1 == 1){
                $status = "Data Tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
        }
        
        return $status;
    }
    
    public function ganti(){
        if($this->session->userdata('logged_in')){
            $kodedetil = $this->uri->segment(3);
            $data = $this->Mglobals->getAllQR("SELECT a.idbk_detil, a.idbarang, b.nama_barang, b.ukuran, c.nama_kategori, a.jumlah FROM barang_keluar_detil a, barang b, kategori c where a.idbarang = b.idbarang and b.idkategori = c.idkategori and a.idbk_detil = '".$kodedetil."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged_in')){
            $data = array(
                'idbarang' => $this->input->post('kode_barang'),
                'jumlah' => $this->input->post('jumlah')
            );
            $condition['idbk_detil'] = $this->input->post('kode_detil');
            $update = $this->Mglobals->update("barang_keluar_detil",$data, $condition);
            if($update == 1){
                 $status = "Data Tersimpan";
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
            $kondisi['idbk'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("barang_keluar",$kondisi);
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
    
    public function ajax_barang() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAllQ("select a.idbarang, a.nama_barang, a.ukuran, b.nama_kategori from barang a, kategori b where a.idkategori = b.idkategori ;");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Pilih" onclick="pilih('."'".$row->idbarang."'".','."'".$row->nama_barang."'".','."'".$row->ukuran."'".','."'".$row->nama_kategori."'".')"><i class="ft-check"></i> Pilih</a>'
                        . '</div>';
                $val[] = $row->nama_barang;
                $val[] = $row->ukuran;
                $val[] = $row->nama_kategori;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_anggota() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAllQ("select idanggota, NRP, nama from anggota;");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Pilih" onclick="pilih_anggota('."'".$row->idanggota."'".','."'".$row->NRP."'".','."'".$row->nama."'".')"><i class="ft-check"></i> Pilih</a>'
                        . '</div>';
                $val[] = $row->NRP;
                $val[] = $row->nama;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_detil() {
        if($this->session->userdata('logged_in')){
            $kode = $this->uri->segment(3);
            $data = array();
            $list = $this->Mglobals->getAllQ("SELECT * FROM barang_keluar_detil where idbk = '".$kode."';");
            foreach ($list->result() as $row) {
                $val = array();
                // data barang
                $barang = $this->Mglobals->getAllQR("select nama_barang, ukuran, idkategori from barang where idbarang = '".$row->idbarang."';");
                $val[] = $barang->nama_barang;
                $val[] = $barang->ukuran;
                $val[] = $this->Mglobals->getAllQR("select nama_kategori from kategori where idkategori = '".$barang->idkategori."';")->nama_kategori;
                $val[] = $row->jumlah;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->idbk_detil."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idbk_detil."'".', '."'".$barang->nama_barang."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapusdetil() {
        if($this->session->userdata('logged_in')){
            $kondisi['idbk_detil'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("barang_keluar_detil",$kondisi);
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
    
    public function getStok() {
        if($this->session->userdata('logged_in')){
            $kode = $this->uri->segment(3);
            
            $masuk = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as masuk FROM barang_masuk_detil where idbarang = '".$kode."';")->masuk;
            $keluar = $this->Mglobals->getAllQR("SELECT ifnull(sum(jumlah),0) as keluar FROM barang_keluar_detil where idbarang = '".$kode."';")->keluar;
            
            $stok = $masuk - $keluar;
            
            echo json_encode(array("status" => $stok));
        }else{
            $this->modul->halaman('login');
        }
    }
}
