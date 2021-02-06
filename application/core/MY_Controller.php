<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Controller extends CI_Controller {
    var $menu;
    var $data;
    
	public function __construct(){
		parent::__construct();

        $this->data['current_controller'] = '';
        $role = $this->session->userdata('kategori');
		$this->data['menu'] = $this->get_menu($role);
	}

	private function get_menu($role){
        $this->load->model('menu_model');
        $menu = array();
        $menu = $this->menu_model->user_menu($role);
        return $menu;
    }

}