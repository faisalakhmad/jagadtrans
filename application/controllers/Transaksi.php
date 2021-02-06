<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends Main_Controller {
    var $arr_status_kirim;

    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('transaksi_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));

        $this->arr_status_kirim[0]['id'] = '0';
        $this->arr_status_kirim[0]['label'] = 'Belum Dikirim';
        $this->arr_status_kirim[1]['id'] = '1';
        $this->arr_status_kirim[1]['label'] = 'Sudah Dikirim';
        $this->arr_status_kirim[2]['id'] = '2';
        $this->arr_status_kirim[2]['label'] = 'Gagal Dikirim';
    }

    function index(){
    	$this->data['current_controller'] 	= 'Transaksi Pengiriman';
    	$this->data['instansi']          	= $this->transaksi_model->get_data_instansi(); 
    	$this->data['jenis_dok']          	= $this->transaksi_model->get_data_dok();
    	$this->data['desa']          		= $this->transaksi_model->get_data_desa();
        $this->data['status_kirim']         = $this->arr_status_kirim;

        $this->data['filter_instansi']      = $this->session->userdata('filter_instansi');
        $this->data['filter_jdok']          = $this->session->userdata('filter_jdok');
        $this->data['filter_status']        = $this->session->userdata('filter_status');
        $this->data['filter_tgl_awal']      = $this->session->userdata('filter_tgl_awal');
        $this->data['filter_desa']          = $this->session->userdata('filter_desa');

        $filter_tgl_awal                    = $this->session->userdata('filter_tgl_awal');
        $filter_tgl_akhir                   = $this->session->userdata('filter_tgl_akhir');
        if(!empty($filter_tgl_awal)){
            $filter_tgl_awal = explode('-', $filter_tgl_awal);
            $filter_tgl_awal = $filter_tgl_awal[1].'/'.$filter_tgl_awal[2].'/'.$filter_tgl_awal[0];

            $filter_tgl_akhir = explode('-', $filter_tgl_akhir);
            $filter_tgl_akhir = $filter_tgl_akhir[1].'/'.$filter_tgl_akhir[2].'/'.$filter_tgl_akhir[0];

            $this->data['tgl_kirim']          = $filter_tgl_awal.' - '.$filter_tgl_akhir;
        }

    	level_user('transaksi','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/transaksi/home', $this->data);
    }

    function data_pengiriman(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->transaksi_model->get_pengiriman_datatable();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('transaksi','index',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" 
            	data-nama_dok="'.$this->security->xss_clean($r->jdok_nama).'"
            	data-inst="'.$this->security->xss_clean($r->instansi_nama).'"
            	data-tgl="'.$this->security->xss_clean(tgl_indo_short($r->trans_tanggal)).'"
             	class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';

            $tomboledit = level_user('transaksi','index',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';

            $tombolview = level_user('transaksi','index',$this->session->userdata('kategori'),'read') > 0 ? '<a href="#" onclick="view(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-default" title="Lihat Detail"><i class="fa fa-search"></i></a>':'';

            $row[]  = $tombolview.' '.$tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->instansi_nama); 
            $row[]  = $this->security->xss_clean($r->jdok_nama); 
            $row[]  = $this->security->xss_clean($r->trans_penerima); 
            $row[]  = $this->security->xss_clean($r->kec_nama) . ' / '.$this->security->xss_clean($r->desa_nama);
            $row[]  = $this->security->xss_clean(tgl_indo_short($r->trans_tanggal));

            switch ($r->trans_status) {
                case '0':
                    $status = 'Belum Dikirim';
                    break;
                case '1':
                    $status = 'Sudah Dikirim';
                    break;
                case '0':
                    $status = 'Gagal Dikirim';
                    break;
                
                default:
                    $status = '-';
                    break;
            }
            $row[]  = $this->security->xss_clean($status); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->transaksi_model->count_all_datatable_pengiriman(),
            "recordsFiltered" => $this->transaksi_model->count_filtered_datatable_pengiriman(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function pengiriman_tambah(){ 
        #cekajax(); 
        $simpan     = $this->transaksi_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_pengiriman());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_pengiriman()){
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

    function pengiriman_edit(){ 
        cekajax(); 
        $simpan = $this->transaksi_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_pengiriman());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_pengiriman()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "Gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function pengiriman_delete(){ 
        cekajax(); 
        $hapus = $this->transaksi_model;
        if($hapus->hapusdata_pengiriman()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function pengiriman_detail(){  
        cekajax(); 
        $query = $this->transaksi_model->get_detail_trans($this->input->get("id"));
        $result = array(  
            "dokumen" => $this->security->xss_clean($query->row()->jdok_nama), 
            "instansi" => $this->security->xss_clean($query->row()->instansi_nama), 
            "penerima" => $this->security->xss_clean($query->row()->trans_penerima), 
            "desa" => $this->security->xss_clean($query->row()->kec_desa), 
            "alamat" => $this->security->xss_clean($query->row()->trans_alamat), 
            "keterangan" => $this->security->xss_clean($query->row()->trans_keterangan), 
            "lokasi" => $this->security->xss_clean($query->row()->trans_lokasi), 
            "foto" => $this->security->xss_clean($query->row()->trans_foto)
        );    
        echo'['.json_encode($result).']';
    }

    function pengiriman_detail_edit(){  
        cekajax(); 
        $query = $this->db->get_where('trans_pengiriman', array('trans_id' => $this->input->get("id")),1);
        $result = array(  
            "penerima" => $this->security->xss_clean($query->row()->trans_penerima), 
            "alamat" => $this->security->xss_clean($query->row()->trans_alamat), 
            "lokasi" => $this->security->xss_clean($query->row()->trans_lokasi), 
            "keterangan" => $this->security->xss_clean($query->row()->trans_keterangan), 
            "instansi" => $this->security->xss_clean($query->row()->trans_instansi_id), 
            "desa" => $this->security->xss_clean($query->row()->trans_desa_id), 
            "dok_id" => $this->security->xss_clean($query->row()->trans_jdok_id)
        );    
        echo'['.json_encode($result).']';
    }

    function filter(){
        cekajax(); 
        $post   = $this->input->post();
        $this->session->set_userdata('filter_instansi', $post['instansi']);
        $this->session->set_userdata('filter_jdok', $post['jenis_dok']);
        $this->session->set_userdata('filter_desa', $post['desa']);
        $this->session->set_userdata('filter_status', $post['status_kirim']);

        if(!empty($post['tgl_kirim'])){
            $tgl = explode(' - ', $post['tgl_kirim']);
            $tgl_awal   = $tgl[0];
            $tgl_awal   = explode('/', $tgl_awal);
            $tgl_awal   = $tgl_awal[2].'-'.$tgl_awal[0].'-'.$tgl_awal[1];

            $tgl_akhir  = $tgl[1];
            $tgl_akhir  = explode('/', $tgl_akhir);
            $tgl_akhir  = $tgl_akhir[2].'-'.$tgl_akhir[0].'-'.$tgl_akhir[1];
        }else{
            $tgl_awal   = '';
            $tgl_akhir  = '';
        }
        

        $this->session->set_userdata('filter_tgl_awal', $tgl_awal);
        $this->session->set_userdata('filter_tgl_akhir', $tgl_akhir);

        $data['success']= true;
        echo json_encode($data);
    }

}