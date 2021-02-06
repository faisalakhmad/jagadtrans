<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends Main_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('master_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
    
	public function index()
	{    
        level_user('master','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/beranda',$data);
    }

    function instansi(){
        $this->data['current_controller'] = __FUNCTION__;
        $this->load->view('member/master/'.__FUNCTION__, $this->data);
    }

    function datainstansi(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->master_model->get_instansi_datatable();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','instansi',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->instansi_id).'" data-nama="'.$this->security->xss_clean($r->instansi_nama).'" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';
            $tomboledit = level_user('master','instansi',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->instansi_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';
            $row[]  = $tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->instansi_nama); 
            $row[]  = $this->security->xss_clean($r->instansi_keterangan); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_instansi(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_instansi(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function instansitambah(){ 
        cekajax(); 
        $simpan     = $this->master_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_instansi());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_instansi()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";   
            }else{
                $errors['fail'] = "gagal melakukan update data";
                $data['errors'] = $errors;
            }  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function instansi_detail(){  
        cekajax(); 
        $query = $this->db->get_where('master_instansi', array('instansi_id' => $this->input->get("id")),1);
        $result = array(  
            "nama" => $this->security->xss_clean($query->row()->instansi_nama), 
            "keterangan" => $this->security->xss_clean($query->row()->instansi_keterangan), 
        );    
        echo'['.json_encode($result).']';
    }

    function instansi_edit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_instansi());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_instansi()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function instansi_delete(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdata_instansi()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    // jenis dokumen -=-----------------------------
    function jenis_dokumen(){
        $this->data['label_title']          = 'Jenis Dokumen'; 
        $this->data['current_controller']   = __FUNCTION__;
        $this->load->view('member/master/'.__FUNCTION__, $this->data);
    }

    function data_jenis_dok(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->master_model->get_jenis_dok_datatable();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','jenis_dokumen',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->jdok_id).'" data-nama="'.$this->security->xss_clean($r->jdok_nama).'" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';
            $tomboledit = level_user('master','jenis_dokumen',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->jdok_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';
            $row[]  = $tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->jdok_nama); 
            $row[]  = $this->security->xss_clean($r->jdok_keterangan); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_jenis_dok(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_jenis_dok(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function jenis_dok_tambah(){ 
        cekajax(); 
        $simpan     = $this->master_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_jenis_dok());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_jenis_dok()){
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

    function jenis_dok_edit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_jenis_dok());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_jenis_dok()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function jenis_dok_delete(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdata_jenis_dok()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function jenis_dok_detail(){  
        cekajax(); 
        $query = $this->db->get_where('master_jenis_dokumen', array('jdok_id' => $this->input->get("id")),1);
        $result = array(  
            "nama" => $this->security->xss_clean($query->row()->jdok_nama), 
            "keterangan" => $this->security->xss_clean($query->row()->jdok_keterangan), 
        );    
        echo'['.json_encode($result).']';
    }


    // KECAMATAN------------------------------------------------------------------------------
    function kecamatan(){
        $this->data['current_controller']   = __FUNCTION__;
        $this->load->view('member/master/'.__FUNCTION__, $this->data);
    }

    function data_jenis_kec(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->master_model->get_data_kec();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','jenis_dokumen',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kec_id).'" data-nama="'.$this->security->xss_clean($r->kec_nama).'" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';
            $tomboledit = level_user('master','jenis_dokumen',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kec_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';
            $row[]  = $tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->kec_nama); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_kec(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_kec(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function kec_tambah(){ 
        cekajax(); 
        $simpan     = $this->master_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_kec());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_kec()){
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

    function kec_edit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_kec());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_kec()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function kec_delete(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdata_kec()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function kec_detail(){  
        cekajax(); 
        $query = $this->db->get_where('master_kecamatan', array('kec_id' => $this->input->get("id")),1);
        $result = array(  
            "nama" => $this->security->xss_clean($query->row()->kec_nama)
        );    
        echo'['.json_encode($result).']';
    }

    // DESA ---------------------------------------------------------------------------------------------
    function desa(){
        $this->data['kecamatan']            = $this->db->get('master_kecamatan')->result(); 
        $this->data['current_controller']   = __FUNCTION__;
        $this->load->view('member/master/'.__FUNCTION__, $this->data);
    }

    function data_desa(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->master_model->get_data_desa();
        $data   = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','desa',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->desa_id).'" data-nama="'.$this->security->xss_clean($r->desa_nama).'" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';
            $tomboledit = level_user('master','desa',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->desa_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';
            $row[]  = $tomboledit.' '.$tombolhapus;
            $row[]  = $this->security->xss_clean($r->desa_nama); 
            $row[]  = $this->security->xss_clean($r->kec_nama); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_desa(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_desa(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function desa_tambah(){ 
        cekajax(); 
        $simpan     = $this->master_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rules_desa());

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{                  
            if($simpan->simpandata_desa()){
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

    function desa_edit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post   = $this->input->post();

        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rules_desa());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedata_desa()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function desa_delete(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdata_desa()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function desa_detail(){  
        cekajax(); 
        $query = $this->db->get_where('master_desa', array('desa_id' => $this->input->get("id")),1);
        $result = array(  
            "desa_nama" => $this->security->xss_clean($query->row()->desa_nama),
            "kec_id" => $this->security->xss_clean($query->row()->desa_kec_id)
        );    
        echo'['.json_encode($result).']';
    }







	  
	public function dokter()
	{   
        $this->data['current_controller'] = 'dokter';
        level_user('master','dokter',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/dokter_v2', $this->data);
    }  
    public function datadokter()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_dokter_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array();  
            $tombolhapus = level_user('master','dokter',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','dokter',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Detail</a></li>   
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->kode_dokter);
            $row[] = $this->security->xss_clean($r->nama_dokter);
            $row[] = $this->security->xss_clean($r->jenis_kelamin);
            $row[] = $this->security->xss_clean($r->handphone); 
            $row[] = $this->security->xss_clean($r->telepon); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_dokter(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_dokter(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }
    public function doktertambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesdokter());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->simpandatadokter()){ 
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";  
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function dokterdetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_dokter', array('kode_dokter' => $this->input->get("id")),1);
        $result = array(  
            "nama_dokter" => $this->security->xss_clean($query->row()->nama_dokter),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone),
            "kode_dokter" => $this->security->xss_clean($query->row()->kode_dokter), 
        );    
    	echo'['.json_encode($result).']';
    }
    public function dokteredit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesdokteredit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->updatedatadokter()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";   
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    public function dokterhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatadokter()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors="fail";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
	public function supplier()
	{   
        $this->data['current_controller'] = 'supplier';
        level_user('master','supplier',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/supplier_v2', $this->data);
    }  
    public function datasupplier()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_supplier_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','supplier',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','supplier',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu">   
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->nama_supplier);
            $row[] = $this->security->xss_clean($r->kontak_person);
            $row[] = $this->security->xss_clean($r->telepon);
            $row[] = $this->security->xss_clean($r->alamat);  
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_supplier(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_supplier(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }
    public function suppliertambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessupplier());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->simpandatasupplier()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";  
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
           
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function supplierdetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('master_supplier', array('id' => $idd),1);
        $result = array(  
            "nama_supplier" => $this->security->xss_clean($query->row()->nama_supplier),
            "kontak_person" => $this->security->xss_clean($query->row()->kontak_person),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
        );    
    	echo'['.json_encode($result).']';
    }
    public function supplieredit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessupplier());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->updatedatasupplier()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
              
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function supplierhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatasupplier()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function pembeli()
	{   
        $this->data['current_controller'] = 'pembeli';
        level_user('master','pembeli',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->data['dokter'] = $this->db->get('master_dokter')->result();
        $this->load->view('member/master/pembeli_v2',$this->data);
    }  
    
    public function datapembeli()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_pembeli_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','pembeli',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','pembeli',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu"> 
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->id).'">Detail</a></li>
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->nama_pembeli);
            $row[] = $this->security->xss_clean($r->jenis_kelamin);
            $row[] = $this->security->xss_clean($r->handphone);
            $row[] = $this->security->xss_clean($r->email);  
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_pembeli(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_pembeli(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }

    public function pembelitambah(){ 
        cekajax(); 
        $post = $this->input->post();
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembeli());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            $insert_id = $simpan->simpandatapembeli();
            if($insert_id > 0) { 
                $data['success']= true;
                $data['pembeli']= $post["nama_pembeli"];
                $data['id_pembeli']= $insert_id;
                $data['message']="Berhasil menyimpan data";
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    public function pembelidetail(){  
        cekajax(); 
       $idd = intval($this->input->get("id")); 
       $nama_dokter ="";
       $query = $this->db->select("nama_pembeli, kode_dokter, jenis_kelamin, alamat, telepon, handphone, email, kode_dokter")->get_where('master_pembeli', array('id' => $idd),1);
       if(!empty($query->row()->kode_dokter)){    
           $dokter = $this->db->select("nama_dokter")->get_where('master_dokter', array('kode_dokter' => $query->row()->kode_dokter),1);
           $nama_dokter = $dokter->row()->nama_dokter;
       }

        $result = array(  
            "nama_pembeli" => $this->security->xss_clean($query->row()->nama_pembeli),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone),
            "email" => $this->security->xss_clean($query->row()->email), 
            "nama_dokter" => $this->security->xss_clean($nama_dokter),  
            "kode_dokter" => $this->security->xss_clean($query->row()->kode_dokter), 
        );    
    	echo'['.json_encode($result).']';
    }
    public function pembeliedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembeli());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            $simpan->updatedatapembeli();
            $data['success']= true;
            $data['message']="Berhasil menyimpan data";
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function pembelihapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatapembeli()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors="fail";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function itemkategori()
	{   
        $this->data['current_controller'] = 'itemkategori';
        level_user('master','itemkategori',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/itemkategori_v2', $this->data);
    }  
    public function datakategori()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_kategori_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','itemkategori',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','itemkategori',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_kategori(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_kategori(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }
    public function kategoritambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->ruleskategori());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
            if($simpan->simpandatakategori()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";   
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    
    public function kategoridetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_kategori', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namakategori" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 
    public function kategoriedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->ruleskategori());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{    
                if($simpan->updatedatakategori()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function kategorihapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatakategori()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
	public function satuan()
	{   
        $this->data['current_controller'] = 'satuan';
        level_user('master','satuan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/satuan_v2', $this->data);
    }  
    public function datasatuan()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_satuan_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','satuan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','satuan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_satuan(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_satuan(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function satuantambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessatuan());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
			if($simpan->simpandatasatuan()){
				$data['success']= true;
				$data['message']="Berhasil menyimpan data";   
			}else{
				$errors['fail'] = "gagal melakukan update data";
				$data['errors'] = $errors;
			}			
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    
    public function satuandetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_satuan', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namasatuan" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 
    public function satuanedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulessatuan());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{     
				if($simpan->updatedatasatuan()){
					$data['success']= true;
					$data['message']="Berhasil menyimpan data";   
				}else{
					$errors['fail'] = "gagal melakukan update data";
					$data['errors'] = $errors;
				}						
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function satuanhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatasatuan()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
    
    public function merk()
	{   
        $this->data['current_controller'] = 'merk';
        level_user('master','merk',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/merk_v2', $this->data);
    }
    public function datamerk()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_merk_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','satuan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','satuan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">                        
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_merk(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_merk(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    

    public function merkdetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_merk', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namamerk" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 

    public function merkedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesmerk());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedatamerk()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function merkhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdata_instansi()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
	
	public function items()
	{  
        level_user('master','items',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->data['kategori'] = $this->db->get('master_kategori')->result(); 
        $this->data['satuan'] = $this->db->get('master_satuan')->result(); 
        $this->data['merk'] = $this->db->get('master_merk')->result(); 
        $this->data['current_controller'] = 'items';
        $this->load->view('member/master/items_v2',$this->data);
    }

    public function render_barcode_item(){
        $time = time();
        $today = date('mydis');
        return 'TM'.$time.$today;
    }

    public function dataitems()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_item_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','items',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="javascript:void(0);" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_item).'"
            data-nama="'.$this->security->xss_clean($r->nama_item).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','items',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="javascript:void(0);" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <a type="button" class="btn mb-xs mt-xs mr-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu"> 
                            <li><a href="javascript:void(0);" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Detail</a></li> 
                            '.$tomboledit.'
                            '.$tombolhapus.' 
                        </ul>
                    </div>
                    ';
				    
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item);  
            $row[] = $this->security->xss_clean(rupiah($r->harga_beli)); 
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual)); 
            //$row[] = $this->security->xss_clean($r->lokasi); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_item(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_item(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function itemstambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitems());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{

            // render barcode
            $_POST['kode_item'] = $this->render_barcode_item();

			if($simpan->simpandataitems()){
				$data['success']= true;
				$data['message']="Berhasil menyimpan data";   
			}else{
				$errors['fail'] = "gagal melakukan update data";
				$data['errors'] = $errors;
			}  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function itemdetail(){  
        cekajax(); 
        $idd = $this->input->get("id"); 
        $query = $this->db->get_where('master_item', array('kode_item' => $idd),1);
        $result = array(  
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "jenis" => $this->security->xss_clean($query->row()->jenis),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "satuan" => $this->security->xss_clean($query->row()->satuan),
            "merk" => $this->security->xss_clean($query->row()->merk),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan), 
            "lokasi" => $this->security->xss_clean($query->row()->lokasi), 
            "harga_jual" => $this->security->xss_clean(rupiah($query->row()->harga_jual)),
            "harga_jual_edit" => $this->security->xss_clean($query->row()->harga_jual),
            "harga_beli" => $this->security->xss_clean($query->row()->harga_beli),
            "gambar" => $this->security->xss_clean($query->row()->gambar), 
        );    
    	echo'['.json_encode($result).']';
    }
    
    public function itemsedit(){ 
        cekajax(); 
        $simpan = $this->master_model; 
        $post = $this->input->post();
        if($post["kode_item"] == $post["idd"]){  
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesitemsedit());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{       
                if($simpan->updatedataitems()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  				
            }
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesitems());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{          
                if($simpan->updatedataitems()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function itemshapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdataitem()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function racikan()
	{    
        level_user('master','racikan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->data['itemobat'] = $this->db->get_where('master_item', array('jenis' => 'obat'))->result();
        $this->data['kategori'] = $this->db->get('master_kategori')->result(); 
        $this->data['satuan'] = $this->db->get('master_satuan')->result(); 
        $this->data['current_controller'] = 'racikan';
        $this->load->view('member/master/racikan_v2',$this->data);
    }  
    
    public function dataracikan()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_dataracikan_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','racikan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_item).'" data-nama="'.$this->security->xss_clean($r->nama_item).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','racikan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Edit</a></li>':'';
            $row[] = ' <div class="btn-group dropup">
                        <a type="button" class="mb-xs mt-xs mr-xs btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Detail</a></li> 
                            '.$tomboledit.'
                            '.$tombolhapus.' 
                        </ul>
                    </div>
                    '; 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual));   
            $row[] = $this->security->xss_clean(rupiah($r->upah_peracik));  
            $row[] = $this->security->xss_clean($r->aturan_pakai); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_dataracikan(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_dataracikan(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function racikandetail(){  
        cekajax(); 
        $idd = $this->input->get("id");
        $query = $this->db->get_where('master_item', array('kode_item' => $idd),1);
        $result = array(  
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "jenis" => $this->security->xss_clean($query->row()->jenis),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "satuan" => $this->security->xss_clean($query->row()->satuan),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan), 
            "lokasi" => $this->security->xss_clean($query->row()->lokasi), 
            "harga_jual" => $this->security->xss_clean(rupiah($query->row()->harga_jual)), 
            "harga_jual_edit" => $this->security->xss_clean($query->row()->harga_jual), 
            "aturan_pakai" => $this->security->xss_clean($query->row()->aturan_pakai), 
            "upah_peracik" => $this->security->xss_clean(rupiah($query->row()->upah_peracik)), 
            "upah_peracik_edit" => $this->security->xss_clean($query->row()->upah_peracik), 
            "gambar" => $this->security->xss_clean($query->row()->gambar), 
        );     
        
		$subitem= $this->master_model->get_dataracikan($idd); 
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_obat;
			$subArray['nama_item']=$r->nama_item;  
			$subArray['jumlah_obat_dibuat']=$r->jumlah_obat_dibuat;   
			$subArray['jumlah_obat_dipakai']=$r->jumlah_obat_dipakai;     
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    
    public function pilihanobat()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_pilihanobat_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean($r->kategori);   
            $row[] = ' 
            <a onclick="pilihobat(this)"  data-namaitem="'.$r->nama_item.'" data-id="'.$r->kode_item.'" class="mt-xs mr-xs btn btn-info datarowobat" role="button"><i class="fa fa-check-square-o"></i></a>
            '; 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_pilihanobat(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_pilihanobat(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function racikantambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitems());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_obat = $this->input->post("kode_obat");   
            if(isset($kode_obat) === TRUE AND $kode_obat[0]!='')
            {  
                if($simpan->simpandataracikan()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                } 
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih obat yang ingin diracik";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function racikanhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdataracikan()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    public function racikanedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitemsedit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_obat = $this->input->post("kode_obat");   
            if(isset($kode_obat) === TRUE AND $kode_obat[0]!='')
            {  
                if($simpan->updatedataracikan()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                } 
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih obat yang ingin diracik";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
}