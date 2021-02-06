<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends Main_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }   
        $this->load->model('password_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
	public function index()
	{   
        #level_user('password','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/password/home', $this->data);
    } 
	function gantipassword(){  
        cekajax(); 
        $password = $this->password_model;
		$validation = $this->form_validation; 
        $validation->set_rules($password->rules());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            $post = $this->input->post();
            $datapass['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            if($password->editpassword($datapass)){  
                $data['success']= true;
                $data['message']="Berhasil merubah password"; 
            } else{
				$errors['fail'] = "Gagal melakukan update data";
				$data['errors'] = $errors;
			} 
        } 
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
}
