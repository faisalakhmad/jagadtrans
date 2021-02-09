<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Main_Controller {    
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('dashboard_model'); 
    }

	public function index(){  
        level_user('dashboard','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/beranda/beranda', $this->data);  
    }

    public function logout(){ 
        $this->session->sess_destroy();  
        redirect(base_url());
    }

    public function laporan_ringkas(){ 
        cekajax();    
        $hariini_total_dok          = $this->dashboard_model->hariini_total_dok();
        $hariini_total_dok_belum    = $this->dashboard_model->hariini_total_dok_belum();
        $hariini_total_dok_gagal    = $this->dashboard_model->hariini_total_dok_gagal();
        
        $result = array(   
            "hariini_total_dok"         => $this->security->xss_clean($hariini_total_dok->total),
            "hariini_total_dok_belum"   => $this->security->xss_clean($hariini_total_dok_belum->total),
            "hariini_total_dok_gagal"   => $this->security->xss_clean($hariini_total_dok_gagal->total)
         );    
        echo'['.json_encode($result).']';
    }

    public function laporan_ringkas_per_instansi(){ 
        cekajax();    
        $hariini_total_dok          = $this->dashboard_model->hariini_total_dok_per_instansi();
        $hariini_total_dok_belum    = $this->dashboard_model->hariini_total_dok_belum_per_instansi();
        $hariini_total_dok_gagal    = $this->dashboard_model->hariini_total_dok_gagal_per_instansi();
        
        $result = array(   
            "hariini_total_dok"         => $this->security->xss_clean($hariini_total_dok->total),
            "hariini_total_dok_belum"   => $this->security->xss_clean($hariini_total_dok_belum->total),
            "hariini_total_dok_gagal"   => $this->security->xss_clean($hariini_total_dok_gagal->total)
         );    
        echo'['.json_encode($result).']';
    }

    public function graph_per_kecamatan(){
        cekajax();  
        $data = $this->dashboard_model->graph_per_kecamatan();

        $arr_return = array();
        for ($i=0; $i < sizeof($data); $i++) { 
            $arr_return['grap'][$i]['name'] = $data[$i]['kecamatan'];
            $arr_return['grap'][$i]['data'] = array((int)$data[$i]['jumlah_kirim']);
        }
        echo json_encode($arr_return);
    }

    function instansi(){
        //dashboard untuk instansi
        level_user('dashboard',__FUNCTION__, $this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/beranda/beranda_'.__FUNCTION__, $this->data);  
    }

}
