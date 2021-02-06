<?php
class User_model extends CI_Model{    

    var $column_search_user    = array('username', 'nama_admin','alamat','handphone','email'); 
    var $column_order_user     = array(null, 'nama_admin','username');
    var $order_user            = array('nama_admin' => 'ASC');

    function get_users_datatable(){
        $get = $this->input->get();
        $this->_get_query_users();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_query_users(){
        $get = $this->input->get();
        $this->db->select('a.*, b.kategori_user');
        $this->db->from('master_admin a'); 
        $this->db->join('kategori_user b', 'a.kategori = b.id');

        $i = 0; 
        foreach ($this->column_search_user as $item){
            if($get['search']['value']){ 
                if($i===0) {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }else{
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_user) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }

        if(isset($get['order'])){
            $this->db->order_by($this->column_order_user[$get['order']['0']['column']], $get['order']['0']['dir']);
        }else
        if(isset($this->order_user)){
            $order = $this->order_user;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_datatable_user(){
        $this->_get_query_users();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    function count_all_datatable_user(){
        $this->db->from('master_admin');
        return $this->db->count_all_results();
    }

    public function rules_user()
    {
        return [
            [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            ],
            [
            'field' => 'password2',
            'label' => 'Password Konfirmasi',
            'rules' => 'trim|required|matches[password]'
            ] ,
            [
            'field' => 'username',
            'label' => 'username',
            'rules' => 'is_unique[master_admin.username]|required',
            ] ,
            [
            'field' => 'nama',
            'label' => 'Nama user',
            'rules' => 'required',
            ] ,
            [
            'field' => 'alamat',
            'label' => 'alamat',
            'rules' => 'required',
            ] ,
            [
            'field' => 'hp',
            'label' => 'hp',
            'rules' => 'required',
            ] ,
            [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required',
            ] 
        ];
    }

    function simpandatauser(){   
        $post = $this->input->post();   
        $password= password_hash($post['password'], PASSWORD_BCRYPT);
        $array = array(
            'kategori'=>$post["kategori"], 
            'username'=>$post["username"], 
            'password'=>$password,  
            'nama_admin'=>$post["nama"], 
            'alamat'=>$post["alamat"], 
            'telepon'=>$post["hp"], 
            'handphone'=>$post["hp"],
            'aktif'=>$post["status"],
            'email'=>$post["email"]
        );
        return $this->db->insert("master_admin", $array);  
    }

    public function rulesuseredit()
    {
        return [ 
            [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim'
            ] ,
            [
            'field' => 'password2',
            'label' => 'Password Konfirmasi',
            'rules' => 'trim|matches[password]'
            ] ,
            [
            'field' => 'username',
            'label' => 'username',
            'rules' => 'required',
            ] ,
            [
            'field' => 'nama',
            'label' => 'Nama user',
            'rules' => 'required',
            ] ,
            [
            'field' => 'alamat',
            'label' => 'alamat',
            'rules' => 'required',
            ] ,
            [
            'field' => 'hp',
            'label' => 'handphone',
            'rules' => 'required',
            ] ,
            [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required',
            ],
            [
            'field' => 'status',
            'label' => 'status',
            'rules' => 'required',
            ]  
        ];
    }   

    function updatedatauser(){
        $post = $this->input->post();
        $this->kategori = $post["kategori"];
        $this->username = $post["username"];
        $this->nama_admin = $post["nama"];
        $this->alamat = $post["alamat"]; 
        $this->telepon = $post["hp"]; 
        $this->handphone = $post["hp"];  
        $this->email = $post["email"];   
        $this->aktif = $post["status"];   
        if($post["password"] !=''){
            $this->password = password_hash($post['password'], PASSWORD_BCRYPT);
        } 
        return $this->db->update("master_admin", $this, array('id' => $post['idd']));
    }
    
}