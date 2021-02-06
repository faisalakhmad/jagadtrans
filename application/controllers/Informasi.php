<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends Main_Controller {
    var $arr_status_kirim;

    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('informasi_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    }

    function index(){
        $this->data['current_controller']   = 'Informasi';
        level_user('informasi','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/informasi/home', $this->data);
    }

    function data_informasi(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->informasi_model->get_informasi_datatable();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('transaksi','index',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->info_id).'" 
                data-title="'.$this->security->xss_clean($r->info_judul).'"
                class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';

            $tomboledit = level_user('transaksi','index',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->info_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';

            $row[]  = $tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->info_judul); 
            $row[]  = $this->security->xss_clean($r->info_isi); 
            $row[]  = $this->security->xss_clean(tgl_indo_short($r->info_tanggal));

            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->informasi_model->count_all_datatable_informasi(),
            "recordsFiltered" => $this->informasi_model->count_filtered_datatable_informasi(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function informasi_tambah(){
        cekajax();
        $simpan     = $this->informasi_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_informasi());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_informasi()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";   
            }else{
                $errors['fail'] = "Gagal menyimpan data";
                $data['errors'] = $errors;
            }  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function informasi_detail(){
        cekajax(); 
        $query = $this->db->get_where('informasi', array('info_id' => $this->input->get("id")),1);
        $result = array(  
            "judul" => $this->security->xss_clean($query->row()->info_judul), 
            "isi" => $this->security->xss_clean($query->row()->info_isi), 
        );    
        echo'['.json_encode($result).']';
    }

    function informasi_edit(){
        cekajax(); 
        $simpan = $this->informasi_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_informasi());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_informasi()){
                    $data['success']= true;
                    $data['message']="Berhasil mengupdate data";   
                }else{
                    $errors['fail'] = "Gagal mengupdate data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function informasi_delete(){
        cekajax(); 
        $hapus = $this->informasi_model;
        if($hapus->hapusdata_informasi()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "Gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
}