<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Coba
 *
 * @author Rampa praditya <https://pramediaenginering.com>
 */
class Coba extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('Zend');
    }
    
    function index(){
        $this->load->library('Zend');
        $this->Zend->load('Zend/Barcode');
    }
    
//    function generate($kode){
//        $this->zend->load('Zend/Barcode');
//        Zend_Barcode::render('code128', 'image', array('text' => $kode), array());
//    }
    
    public function barcode() {
        $kode = $this->uri->segment(3);
        $this->load->library('Zend');
        $this->Zend->load('Zend/Barcode');
        $imageResource = Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
        return $imageResource;
    }
}
