<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profile
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Profile extends CI_Controller{
    
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
            $data['saya'] = $this->Mglobals->getAllQR("SELECT * FROM identitas limit 1;");
            
            $this->load->view('head', $data);
            $this->load->view('sidebar');
            $this->load->view('identitas/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->session->userdata('logged_in')){
            $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml > 0){
                $status = $this->update();
            }else{
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function simpan() {
        $data = array(
            'kode' => $this->modul->autokode1('I','kode','identitas','2','7'),
            'nama_instansi' => $this->input->post('nama_instansi'),
            'alamat' => $this->input->post('alamat'),
            'kode_pos' => $this->input->post('kode_pos'),
            'no_telpon' => $this->input->post('no_telpon'),
            'kelurahan' => $this->input->post('kelurahan'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kota' => $this->input->post('kota'),
            'provinsi' => $this->input->post('provinsi'),
            'website' => $this->input->post('website'),
            'email' => $this->input->post('email'),
        );
        $update = $this->Mglobals->add("identitas",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function update() {
        $data = array(
            'nama_instansi' => $this->input->post('nama_instansi'),
            'alamat' => $this->input->post('alamat'),
            'kode_pos' => $this->input->post('kode_pos'),
            'no_telpon' => $this->input->post('no_telpon'),
            'kelurahan' => $this->input->post('kelurahan'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kota' => $this->input->post('kota'),
            'provinsi' => $this->input->post('provinsi'),
            'website' => $this->input->post('website'),
            'email' => $this->input->post('email'),
        );
        $update = $this->Mglobals->updateNK("identitas",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
}
