<?php
class dashboard_model extends CI_Model{  
    public function hariini_total_dok(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "1"
          ')->get()->row(); 
    }

    public function hariini_total_dok_belum(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "0"
          ')->get()->row(); 
    }

    public function hariini_total_dok_gagal(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "3"
          ')->get()->row(); 
    }

    public function graph_per_kecamatan(){
      return $this->db->select('kec_nama AS kecamatan,
          COUNT(trans_id) AS jumlah_kirim
          FROM master_kecamatan
          LEFT JOIN master_desa ON kec_id = desa_kec_id
          LEFT JOIN trans_pengiriman ON trans_desa_id = desa_id AND trans_status = "1" AND trans_tanggal = CURRENT_DATE()
          GROUP BY kec_id
          ')->get()->result_array(); 
    }

    // per instansi
    public function hariini_total_dok_per_instansi(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "1"
          AND trans_instansi_id = "'.$this->session->userdata('id_instansi').'"
          ')->get()->row(); 
    }

    public function hariini_total_dok_belum_per_instansi(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "0"
          AND trans_instansi_id = "'.$this->session->userdata('id_instansi').'"
          ')->get()->row(); 
    }

    public function hariini_total_dok_gagal_per_instansi(){
        return $this->db->select('count(trans_id) as total')->from('trans_pengiriman')->where('DATE_FORMAT(trans_tanggal, "%Y-%m-%d") = CURDATE()
          AND trans_status = "3"
          AND trans_instansi_id = "'.$this->session->userdata('id_instansi').'"
          ')->get()->row(); 
    }

}