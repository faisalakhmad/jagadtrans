<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Instansi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_data_perusahaan(){
    	$this->db->select('*');
        $this->db->from('instansi'); 
        $query = $this->db->get();
        return $query->row_array();
    }

}