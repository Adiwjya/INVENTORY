<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Anggota
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Anggota extends CI_Controller{
    
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
            $data['pangkat'] = $this->Mglobals->getAll("pangkat");
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('anggota/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("anggota");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->NRP;
                $val[] = $row->nama;
                $val[] = $this->Mglobals->getAllQR("SELECT nama_pangkat FROM pangkat where idpangkat = '".$row->idpangkat."';")->nama_pangkat;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align: center;">'
                        . '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->idanggota."'".')"><i class="ft-edit"></i> Edit</a>&nbsp;'
                        . '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->idanggota."'".','."'".$row->NRP."'".')"><i class="ft-delete"></i> Delete</a>'
                        . '</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged_in')){
            $cek = $this->Mglobals->getAllQR("select count(*) as jml from pangkat where nama_pangkat = '".$this->input->post('nama')."';")->jml;
            if($cek > 0){
                $status = "Data sudah ada";
            }else{
                $data = array(
                    'idanggota' => $this->modul->autokode1('A','idanggota','anggota','2','7'),
                    'NRP' => $this->input->post('nrp'),
                    'nama' => $this->input->post('nama'),
                    'idpangkat' => $this->input->post('pangkat'),
                    'keterangan' => $this->input->post('keterangan')
                );
                $simpan = $this->Mglobals->add("anggota",$data);
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
            $kondisi['idanggota'] = $this->uri->segment(3);
            $data = $this->Mglobals->get_by_id("anggota", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged_in')){
            $data = array(
                'NRP' => $this->input->post('nrp'),
                'nama' => $this->input->post('nama'),
                'idpangkat' => $this->input->post('pangkat'),
                'keterangan' => $this->input->post('keterangan'),
            );
            $condition['idanggota'] = $this->input->post('id');
            $update = $this->Mglobals->update("anggota",$data, $condition);
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
            $kondisi['idanggota'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("anggota",$kondisi);
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
