<?php
class Transaksi_model extends CI_Model{

    var $column_search_pengiriman 	= array('instansi_nama', 'jdok_nama', 'trans_penerima', 'kec_nama', 'desa_nama'); 
    var $column_order_pengiriman 	= array(null, 'instansi_nama','jdok_nama','trans_penerima','kec_nama');
    var $order_pengiriman 			= array('trans_tanggal' => 'DESC');

    function get_pengiriman_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_pengiriman();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_query_pengiriman()
    { 
        $get = $this->input->get();
        $this->db->from('trans_pengiriman'); 
        $this->db->join('master_instansi', 'instansi_id = trans_instansi_id');
        $this->db->join('master_jenis_dokumen', 'jdok_id = trans_jdok_id');
        $this->db->join('master_desa', 'trans_desa_id = desa_id');
        $this->db->join('master_kecamatan', 'desa_kec_id = kec_id');
        $this->db->join('master_admin', 'trans_user = master_admin.id');

        $sess_instansi      = $this->session->userdata('filter_instansi');
        $filter_jdok        = $this->session->userdata('filter_jdok');
        $filter_desa        = $this->session->userdata('filter_desa');
        $filter_status      = $this->session->userdata('filter_status');
        $filter_tgl_awal    = $this->session->userdata('filter_tgl_awal');
        $filter_tgl_akhir   = $this->session->userdata('filter_tgl_akhir');

        $i = 0; 
        foreach ($this->column_search_pengiriman as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_pengiriman) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if(!empty($sess_instansi)){
            $this->db->where("(trans_instansi_id = '$sess_instansi' OR 'all' = '$sess_instansi') ");
        }
        if(!empty($filter_jdok)){
            $this->db->where(" (trans_jdok_id = '$filter_jdok' OR 'all' = '$filter_jdok') ");
        } 
        if(!empty($filter_desa)){
            $this->db->where(" (trans_desa_id = '$filter_desa' OR 'all' = '$filter_desa') ");
        } 
        if(!empty($filter_status)){
            $this->db->where(" (trans_status = '$filter_status' OR 'all' = '$filter_status') ");
        } 
        if(!empty($filter_tgl_awal)){
            $this->db->where(" (trans_tanggal BETWEEN '$filter_tgl_awal' AND '$filter_tgl_akhir' ) ");
        }

        // per instansi
        if(!empty($this->session->userdata('id_instansi'))){
            $this->db->where(" trans_instansi_id = '".$this->session->userdata('id_instansi')."' ");
        }

        //driver
        if(!empty($this->session->userdata('kategori')) && $this->session->userdata('kategori') == ID_KATEGORI_USER_DRIVER){
            $this->db->where(" trans_user = '".$this->session->userdata('idadmin')."' ");
        }

        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_pengiriman[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_pengiriman))
        {
            $order = $this->order_pengiriman;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function count_filtered_datatable_pengiriman()
    {
        $this->_get_query_pengiriman();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    function count_all_datatable_pengiriman()
    {
        $this->db->from('trans_pengiriman');
        // per instansi
        if(!empty($this->session->userdata('id_instansi'))){
            $this->db->where(" trans_instansi_id = '".$this->session->userdata('id_instansi')."' ");
        }
        
        return $this->db->count_all_results();
    }

    function rules_pengiriman()
    {
        return [
            [
            'field' => 'penerima',
            'label' => 'Nama Penerima',
            'rules' => 'required',
            ] 
        ];
    }

    function simpandata_pengiriman(){   
        $post = $this->input->post();   
        $array = array(
            'trans_instansi_id'=>$post["instansi"],
            'trans_penerima'=>$post["penerima"],
            'trans_desa_id'=>$post["desa"],
            'trans_jdok_id'=>$post["jenis_dok"],
            'trans_alamat'=>$post["alamat"], 
            'trans_keterangan'=>$post["keterangan"],
            'trans_lokasi'=>$post["lokasi"],
            'trans_foto'=>$nama_file,
            'trans_tanggal'=> date("Y-m-d"),
            'trans_user'=>$post["driver"],
            'trans_user_pengubah'=>$this->session->userdata('idadmin')
        );
        return $this->db->insert("trans_pengiriman", $array);   
    } 

    function updatedata_pengiriman()
    {
        $post = $this->input->post();
        $this->trans_instansi_id 	= $post["instansi"]; 
        $this->trans_jdok_id 		= $post["jenis_dok"]; 
        $this->trans_penerima 		= $post["penerima"]; 
        $this->trans_desa_id 		= $post["desa"]; 
        $this->trans_alamat 		= $post["alamat"]; 
        $this->trans_keterangan 	= $post["keterangan"]; 
        $this->trans_lokasi 		= $post["lokasi"]; 
        $this->trans_user           = $post["driver"]; 
        $this->trans_update 		= date('Y-m-d H:i:s'); 

        return $this->db->update("trans_pengiriman", $this, array('trans_id' => $post['idd']));
    } 

    function hapusdata_pengiriman()
    {
        $post = $this->input->post(); 
        $this->db->where('trans_id', $post['idd']);
        return $this->db->delete('trans_pengiriman');  
    }

    function get_data_instansi(){
    	$this->db->select('*');
        $this->db->from('master_instansi'); 
        $this->db->order_by('instansi_nama');
        $query = $this->db->get();
        return $query->result();
    }

    function get_data_dok(){
    	$this->db->select('*');
        $this->db->from('master_jenis_dokumen'); 
        $this->db->order_by('jdok_nama');
        $query = $this->db->get();
        return $query->result();
    }

    function get_data_desa(){
    	$this->db->select('master_desa.*');
    	$this->db->select("CONCAT(kec_nama,' / ', desa_nama) AS label");
        $this->db->from('master_desa'); 
        $this->db->join('master_kecamatan', 'desa_kec_id = kec_id');
        $this->db->order_by('kec_nama');
        $this->db->order_by('desa_nama');
        $query = $this->db->get();
        return $query->result();
    }

    function get_data_driver(){
        $this->db->select('*');
        $this->db->from('master_admin'); 
        $this->db->where('kategori', ID_KATEGORI_USER_DRIVER);
        $this->db->order_by('nama_admin','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_detail_trans($id){
    	$this->db->select('trans_pengiriman.*');
    	$this->db->select("instansi_nama");
    	$this->db->select("jdok_nama");
        $this->db->select("nama_admin");
    	$this->db->select("CONCAT(kec_nama,' / ', desa_nama) AS kec_desa");
        $this->db->from('trans_pengiriman'); 
        $this->db->join('master_instansi', 'trans_instansi_id = instansi_id');
        $this->db->join('master_jenis_dokumen', 'jdok_id = trans_jdok_id');
        $this->db->join('master_desa', 'trans_desa_id = desa_id');
        $this->db->join('master_kecamatan', 'desa_kec_id = kec_id');
        $this->db->join('master_admin', 'trans_user = master_admin.id');
        $this->db->where('trans_id', $id);

        return $this->db->get();
    }

    function get_data_for_export(){ 
        $get = $this->input->get();
        $this->_get_query_pengiriman();
        $query = $this->db->get();
        return $query->result_array();
    }

}