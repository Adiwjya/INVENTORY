<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Changepass
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Changepass extends CI_Controller{
    
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
            $this->load->view('changepass/index');
            $this->load->view('footer');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->session->userdata('logged_in')){
            $email = $this->input->post('email');
            $oldpass = $this->input->post('oldpass');
            $newpass = $this->input->post('newpass');
            $data_old = $this->Mglobals->getAllQR("SELECT * FROM userconfig WHERE iduserconfig = '".$email."';");
            $oldpassdb = $this->modul->dekrip_pass($data_old->pass);
            if($oldpass == $oldpassdb){
                $data = array(
                    'pass' => $this->modul->enkrip_pass($newpass)
                );
                $kondisi['iduserconfig'] = $email;
                $update = $this->Mglobals->update("userconfig",$data, $kondisi);
                if($update == 1){
                    $status = "Data tersimpan";
                }else{
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "Password lama tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
           $this->modul->halaman('login');
        }
    }
}
