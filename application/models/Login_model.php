<?php

class Login_model extends CI_Model{
    public function get($where){
        $this->db->where($where);
        return $this->db->get('usuario')->row();
    }
}