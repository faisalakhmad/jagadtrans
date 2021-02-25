<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Main_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form','email'));
        $this->data['class_name'] = strtolower(static::class);
    }

    function index(){
        $this->data['current_controller'] = __FUNCTION__;
        $this->data['label']              = 'user';
        $this->data['kategori']           = $this->user_model->get_data_kategori_with_except(ID_KATEGORI_USER_DRIVER);
        $this->data['instansi']           = $this->db->get('master_instansi')->result(); 

        level_user('user','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/user/home', $this->data);
    }  

    function data_users(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->user_model->get_users_datatable();
        $data   = array(); 
        $start  = $this->start_numbering();  

        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('user','index',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'" 
                data-title="'.$this->security->xss_clean($r->nama_admin).'"
                class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';

            $tomboledit = level_user('user','index',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';
            $tombolview = level_user('user','index',$this->session->userdata('kategori'),'read') > 0 ? '<a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->id).'" class="btn btn-sm btn-default" title="View"><i class="fa fa-search"></i></a>':'';

            $status = $r->aktif == '1' ? "<span class='btn   btn-xs  btn-success'>Aktif</span>":"<span class='btn  btn-xs btn-danger'>Blokir</span>";

            $row[]  = $start++;
            $row[]  = $this->security->xss_clean($r->nama_admin); 
            $row[]  = $this->security->xss_clean($r->username); 
            $row[]  = $this->security->xss_clean($r->kategori_user); 
            $row[]  = $this->security->xss_clean($status); 
            $row[]  = $tombolview.' '.$tomboledit.' '.$tombolhapus;

            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->user_model->count_all_datatable_user(),
            "recordsFiltered" => $this->user_model->count_filtered_datatable_user(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    function user_tambah(){
        cekajax(); 
        $simpan     = $this->user_model;
        $validation = $this->form_validation; 
        $post       = $this->input->post();

        if($post['kategori'] == ID_KATEGORI_USER_INSTANSI){
            $validation->set_rules($simpan->rules_user_add_instansi());
        }else{
            $validation->set_rules($simpan->rules_user());
        }

        $validation->set_rules($simpan->rules_user());

        $is_valid_email = valid_email($this->input->post('email'));

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else
        if(!$is_valid_email){
            $errors['email']    = 'Email not valid';
            $data['errors']     = $errors;
        }else{             
            if($simpan->simpandatauser()){
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
        
    public function user_detail(){  
        cekajax(); 
        $idd = $this->input->get("id");   
        $query = $this->db->select("a.id, a.kategori, a.username, a.nama_admin, a.email, a.jenis_kelamin, a.aktif, a.alamat, a.telepon, a.handphone, a.email, b.kategori_user, a.id_instansi")->from("master_admin a")->join('kategori_user b', 'a.kategori = b.id')->where('a.id', $idd, 1)->get(); 
        $status = $query->row()->aktif == '1' ? "<span class='btn   btn-xs  btn-success'>Aktif</span>":"<span class='btn  btn-xs btn-danger'>Blokir</span>";
        $result = array(  
            "kategori" => $this->security->xss_clean($query->row()->kategori_user),
            "kategori_value" => $this->security->xss_clean($query->row()->kategori),
            "username" => $this->security->xss_clean($query->row()->username),
            "nama_admin" => $this->security->xss_clean($query->row()->nama_admin),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone), 
            "email" => $this->security->xss_clean($query->row()->email),  
            "aktif_value" => $this->security->xss_clean($query->row()->aktif),
            "status" =>$status,
            "instansi" =>$this->security->xss_clean($query->row()->id_instansi)
        );    
    	echo'['.json_encode($result).']';
    }

    function useredit(){ 
        cekajax(); 
        $simpan = $this->user_model; 
        $post = $this->input->post();
        $validation = $this->form_validation; 
        
        if($post['kategori'] == ID_KATEGORI_USER_INSTANSI){
            $validation->set_rules($simpan->rulesuseredit_instansi());
        }else{
            $validation->set_rules($simpan->rulesuseredit());
        }

        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{       
            if($simpan->updatedatauser()){
                $data['success']= true;
                $data['message']="Berhasil mengupdate data";   
            }else{
                $errors['fail'] = "Gagal mengupdate data";
                $data['errors'] = $errors;
            }  				
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    function userhapus(){ 
        cekajax(); 
        $hapus = $this->user_model;
        if($hapus->hapusdatauser()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    function list_driver(){
        $this->data['current_controller']   = __FUNCTION__;
        $this->data['label']                = 'Driver';

        level_user('user',__FUNCTION__, $this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/user/'.__FUNCTION__, $this->data);
    }

    function data_driver(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->user_model->get_driver_datatable();
        $data   = array(); 
        $start  = $this->start_numbering();  

        foreach ($list as $r) { 
            $row = array(); 

            $tombolhapus = level_user('user','index',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'" 
                data-title="'.$this->security->xss_clean($r->nama_admin).'"
                class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';

            $tomboledit = level_user('user','index',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';

            $status = $r->aktif == '1' ? "<span class='btn   btn-xs  btn-success'>Aktif</span>":"<span class='btn  btn-xs btn-danger'>Blokir</span>";

            $row[]  = $start++;
            $row[]  = $this->security->xss_clean($r->nama_admin); 
            $row[]  = $this->security->xss_clean($r->alamat); 
            $row[]  = $this->security->xss_clean($r->handphone); 
            $row[]  = $this->security->xss_clean($r->email);
            $row[]  = $status;
            $row[]  = $tomboledit.' '.$tombolhapus;

            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->user_model->count_all_datatable_driver(),
            "recordsFiltered" => $this->user_model->count_filtered_datatable_driver(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }
    
}