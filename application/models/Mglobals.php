<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mglobals
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class Mglobals extends CI_Model{
    
    public function getAllQ($q) {
        $list = $this->db->query($q);
        return $list;
    }
    
    public function getAllQR($q) {
        $list = $this->db->query($q);
        return $list->row();
    }
    
    public function getAll($table) {
        $this->db->from($table);
        return $this->db->get();
    }
    
    public function add($table, $data){
        $simpan = $this->db->insert($table,$data); 
        return $simpan;
    }
    
    public function delete($table,$kondisi){
        $this->db->where($kondisi);
        $delete = $this->db->delete($table);
        return $delete;
    }
    
    public function get_by_id($table, $kondisi){
        $this->db->from($table);
        $this->db->where($kondisi);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($table, $data, $condition){
        $this->db->where($condition);
        $update = $this->db->update($table, $data);
        return $update;
    }
    
    public function updateNK($table, $data){
        $update = $this->db->update($table, $data);
        return $update;
    }
}
