<?php
class Informasi_model extends CI_Model{

	var $column_search_informasi 	= array('info_judul', 'info_isi'); 
    var $column_order_informasi 	= array(null, 'info_judul','info_isi');
    var $order_informasi 			= array('info_tanggal' => 'DESC');

	function get_informasi_datatable(){
		$get = $this->input->get();
        $this->_get_query_informasi();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
	}

	private function _get_query_informasi(){
		$get = $this->input->get();
        $this->db->from('informasi'); 

        $i = 0; 
        foreach ($this->column_search_informasi as $item){
            if($get['search']['value']){ 
                if($i===0) {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }else{
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_pengiriman) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if(isset($get['order'])){
            $this->db->order_by($this->column_order_informasi[$get['order']['0']['column']], $get['order']['0']['dir']);
        }else
        if(isset($this->order_informasi)){
            $order = $this->order_informasi;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	function count_filtered_datatable_informasi(){
        $this->_get_query_informasi();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    function count_all_datatable_informasi(){
        $this->db->from('informasi');
        return $this->db->count_all_results();
    }

    function rules_informasi(){
        return [
            [
            'field' => 'judul',
            'label' => 'Judul',
            'rules' => 'required',
            ],
            [
            'field' => 'isi',
            'label' => 'Isi',
            'rules' => 'required',
            ]
        ];
    }

    function simpandata_informasi(){   
        $post = $this->input->post();   
        $array = array(
            'info_judul'=>$post["judul"],
            'info_isi'=>$post["isi"]
        );
        return $this->db->insert("informasi", $array);   
    } 

    function updatedata_informasi(){
    	$post = $this->input->post();
        $this->info_judul = $post["judul"]; 
        $this->info_isi = $post["isi"]; 
        return $this->db->update("informasi", $this, array('info_id' => $post['idd']));
    }

    function hapusdata_informasi(){
    	$post = $this->input->post(); 
        $this->db->where('info_id', $post['idd']);
        return $this->db->delete('informasi');  
    }
}