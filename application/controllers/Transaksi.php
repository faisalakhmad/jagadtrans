<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./phpspreadsheet/vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 

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

        $this->data['class_name'] = strtolower(static::class);
    }

    function index(){
    	$this->data['current_controller'] 	= __FUNCTION__;
        $this->data['label']                = 'Transaksi Pengiriman';
    	$this->data['instansi']          	= $this->transaksi_model->get_data_instansi(); 
    	$this->data['jenis_dok']          	= $this->transaksi_model->get_data_dok();
    	$this->data['desa']          		= $this->transaksi_model->get_data_desa();
        $this->data['driver']               = $this->transaksi_model->get_data_driver();
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
            $filter_tgl_awal = $filter_tgl_awal[2].'/'.$filter_tgl_awal[1].'/'.$filter_tgl_awal[0];

            $filter_tgl_akhir = explode('-', $filter_tgl_akhir);
            $filter_tgl_akhir = $filter_tgl_akhir[2].'/'.$filter_tgl_akhir[1].'/'.$filter_tgl_akhir[0];

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
        $start  = $this->start_numbering();      

        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('transaksi','index',$this->session->userdata('kategori'),'delete') > 0 ? '<a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" 
            	data-nama_dok="'.$this->security->xss_clean($r->jdok_nama).'"
            	data-inst="'.$this->security->xss_clean($r->instansi_nama).'"
            	data-tgl="'.$this->security->xss_clean(tgl_indo_short($r->trans_tanggal)).'"
             	class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>':'';

            $tomboledit = level_user('transaksi','index',$this->session->userdata('kategori'),'edit') > 0 ? '<a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>':'';

            $tombolview = level_user('transaksi','index',$this->session->userdata('kategori'),'read') > 0 ? '<a href="#" onclick="view(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-default" title="Lihat Detail"><i class="fa fa-search"></i></a>':'';

            $row[]  = $start++;
            $row[]  = $this->security->xss_clean($r->instansi_nama); 
            $row[]  = $this->security->xss_clean($r->jdok_nama); 
            $row[]  = $this->security->xss_clean($r->nama_admin); 
            $row[]  = $this->security->xss_clean($r->trans_penerima); 
            $row[]  = $this->security->xss_clean($r->kec_nama) . ' / '.$this->security->xss_clean($r->desa_nama);
            $row[]  = $this->security->xss_clean(tgl_indo_short($r->trans_tanggal));

            switch ($r->trans_status) {
                case '0':
                    $status = "<span class='btn-xs btn-warning'><i class='fa fa-check'></i> Belum</span>";
                    break;
                case '1':
                    $status = "<span class='btn-xs btn-success'><i class='fa fa-check'></i> Sudah</span>";
                    break;
                case '2':
                    $status = "<span class='btn-xs btn-danger'><i class='fa fa-times'></i> Gagal</span>";
                    break;
                
                default:
                    $status = '-';
                    break;
            }
            $row[]  = $this->security->xss_clean($status);             
            $row[]  = $tombolview.' '.$tomboledit.' '.$tombolhapus;
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
        $post       = $this->input->post();
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

        $hapus  = $this->transaksi_model;

        $post   = $this->input->post(); 
        $detil  = $hapus->get_detail_trans($post['idd']);

        if($hapus->hapusdata_pengiriman()){
            if(!empty($detil->row()->trans_foto)){
                if(file_exists('images/'.$detil->row()->trans_foto)){
                    unlink('images/'.$detil->row()->trans_foto);
                }
            } 
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

        if(!empty($query->row()->trans_foto)){
            $img = "<img class='img-responsive pad' src='../images/".$query->row()->trans_foto."' />";
        }

        $result = array(  
            "dokumen" => $this->security->xss_clean($query->row()->jdok_nama), 
            "instansi" => $this->security->xss_clean($query->row()->instansi_nama), 
            "penerima" => $this->security->xss_clean($query->row()->trans_penerima), 
            "penerima_barang" => $this->security->xss_clean($query->row()->trans_penerima_barang), 
            "desa" => $this->security->xss_clean($query->row()->kec_desa), 
            "alamat" => $this->security->xss_clean($query->row()->trans_alamat), 
            "keterangan" => $this->security->xss_clean($query->row()->trans_keterangan), 
            "catatan" => $this->security->xss_clean($query->row()->trans_catatan), 
            "lokasi" => $this->security->xss_clean($query->row()->trans_lokasi), 
            "driver" => $this->security->xss_clean($query->row()->nama_admin), 
            "foto" => $img
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
            "dok_id" => $this->security->xss_clean($query->row()->trans_jdok_id),
            "driver" => $this->security->xss_clean($query->row()->trans_user)
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
            $tgl_awal   = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0];

            $tgl_akhir  = $tgl[1];
            $tgl_akhir  = explode('/', $tgl_akhir);
            $tgl_akhir  = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];
        }else{
            $tgl_awal   = '';
            $tgl_akhir  = '';
        }
        

        $this->session->set_userdata('filter_tgl_awal', $tgl_awal);
        $this->session->set_userdata('filter_tgl_akhir', $tgl_akhir);

        $data['success']= true;
        echo json_encode($data);
    }

    function eksport_xls(){
        $spreadsheet    = new Spreadsheet();
        $data           = $this->transaksi_model->get_data_for_export(); 

        $spreadsheet->getProperties()->setCreator(APP_NAME)
        ->setLastModifiedBy(APP_NAME)
        ->setTitle('Export Excel Transaksi')
        ->setSubject('Export Excel Transaksi');

        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'NO')
        ->setCellValue('B1', 'TANGGAL')
        ->setCellValue('C1', 'INSTANSI')
        ->setCellValue('D1', 'JENIS DOKUMEN')
        ->setCellValue('E1', 'PENERIMA')
        ->setCellValue('F1', 'PENERIMA BARANG')
        ->setCellValue('G1', 'KEC / DESA')
        ->setCellValue('H1', 'ALAMAT')
        ->setCellValue('I1', 'LOKASI')
        ->setCellValue('J1', 'KETERANGAN')
        ->setCellValue('K1', 'CATATAN')        
        ;

        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(50);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(30);
        $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(30);


        $i=2; 
        foreach($data as $post) { 
            $tgl    = tgl_indo($post['trans_tanggal']);
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, (int)$i - 1)
            ->setCellValue('B'.$i, $tgl)
            ->setCellValue('C'.$i, $post['instansi_nama'])
            ->setCellValue('D'.$i, $post['jdok_nama'])
            ->setCellValue('E'.$i, $post['trans_penerima'])
            ->setCellValue('F'.$i, $post['trans_penerima_barang'])
            ->setCellValue('G'.$i, $post['kec_nama'].' / '.$post['desa_nama'])
            ->setCellValue('H'.$i, $post['trans_alamat'])
            ->setCellValue('I'.$i, $post['trans_lokasi'])
            ->setCellValue('J'.$i, $post['trans_keterangan'])
            ->setCellValue('K'.$i, $post['trans_catatan']);
            $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Eksport Transaksi Pengiriman');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Eksport_Transaksi_Pengiriman.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;  
 
    }

    function print_pdf(){
        ini_set('memory_limit', '512M');
        $this->load->library('tcpdf');

        $data['transaksi']      = $this->transaksi_model->get_data_for_export();
        $data['perusahaan']     = $this->data_perusahaan();
        $data['logo']           = base_url().'images/system/logo.jpg';

        $this->load->view('member/transaksi/'.__FUNCTION__, $data);
    }

    // INSTANSI
    function pengiriman_instansi(){
        $this->data['current_controller']   = __FUNCTION__;
        $this->data['label']                = 'Pengiriman';
        $this->data['jenis_dok']            = $this->transaksi_model->get_data_dok();
        $this->data['desa']                 = $this->transaksi_model->get_data_desa();
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
            $filter_tgl_awal = $filter_tgl_awal[2].'/'.$filter_tgl_awal[1].'/'.$filter_tgl_awal[0];

            $filter_tgl_akhir = explode('-', $filter_tgl_akhir);
            $filter_tgl_akhir = $filter_tgl_akhir[2].'/'.$filter_tgl_akhir[1].'/'.$filter_tgl_akhir[0];

            $this->data['tgl_kirim']          = $filter_tgl_awal.' - '.$filter_tgl_akhir;
        }

        level_user('transaksi',__FUNCTION__, $this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/transaksi/home_'.__FUNCTION__, $this->data);
    }

    function data_pengiriman_per_instansi(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->transaksi_model->get_pengiriman_datatable();
        $data   = array(); 
        $start  = $this->start_numbering();  

        foreach ($list as $r) { 
            $row = array(); 
            $tombolview = level_user('transaksi','pengiriman_instansi',$this->session->userdata('kategori'),'read') > 0 ? '<a href="#" onclick="view(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-warning" title="Lihat Detail"><i class="fa fa-search"></i></a>':'';

            $row[]  = $start++;
            $row[]  = $this->security->xss_clean($r->instansi_nama); 
            $row[]  = $this->security->xss_clean($r->jdok_nama); 
            $row[]  = $this->security->xss_clean($r->trans_penerima); 
            $row[]  = $this->security->xss_clean($r->kec_nama) . ' / '.$this->security->xss_clean($r->desa_nama);
            $row[]  = $this->security->xss_clean(tgl_indo_short($r->trans_tanggal));

            switch ($r->trans_status) {
                case '0':
                    $status = "<span class='btn-xs btn-warning'><i class='fa fa-check'></i> Belum</span>";
                    break;
                case '1':
                    $status = "<span class='btn-xs btn-success'><i class='fa fa-check'></i> Sudah</span>";
                    break;
                case '2':
                    $status = "<span class='btn-xs btn-danger'><i class='fa fa-times'></i> Gagal</span>";
                    break;
                
                default:
                    $status = '-';
                    break;
            }
            $row[]  = $this->security->xss_clean($status); 
            $row[]  = $tombolview;
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

    // INSTANSI
    function pengiriman_driver(){
        $this->data['current_controller']   = __FUNCTION__;
        $this->data['label']                = 'Pengiriman';
        $this->data['instansi']             = $this->transaksi_model->get_data_instansi(); 
        $this->data['jenis_dok']            = $this->transaksi_model->get_data_dok();
        $this->data['desa']                 = $this->transaksi_model->get_data_desa();
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
            $filter_tgl_awal = $filter_tgl_awal[2].'/'.$filter_tgl_awal[1].'/'.$filter_tgl_awal[0];

            $filter_tgl_akhir = explode('-', $filter_tgl_akhir);
            $filter_tgl_akhir = $filter_tgl_akhir[2].'/'.$filter_tgl_akhir[1].'/'.$filter_tgl_akhir[0];

            $this->data['tgl_kirim']          = $filter_tgl_awal.' - '.$filter_tgl_akhir;
        }

        level_user('transaksi',__FUNCTION__, $this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/transaksi/home_'.__FUNCTION__, $this->data);
    }

    function data_pengiriman_per_driver(){
        cekajax(); 
        $get    = $this->input->get();
        $list   = $this->transaksi_model->get_pengiriman_datatable();
        $data   = array(); 
        $start  = $this->start_numbering(); 
        
        foreach ($list as $r) { 
            $row = array(); 
            $tombolview = level_user('transaksi','pengiriman_driver',$this->session->userdata('kategori'),'read') > 0 ? '<a href="#" onclick="view(this)" data-id="'.$this->security->xss_clean($r->trans_id).'" class="btn btn-sm btn-warning" title="Lihat Detail"><i class="fa fa-search"></i></a>':'';
            $row[]  = $start++;
            $row[]  = $this->security->xss_clean($r->instansi_nama); 
            $row[]  = $this->security->xss_clean($r->jdok_nama); 
            $row[]  = $this->security->xss_clean($r->trans_penerima); 
            $row[]  = $this->security->xss_clean($r->kec_nama) . ' / '.$this->security->xss_clean($r->desa_nama);
            $row[]  = $this->security->xss_clean(tgl_indo_short($r->trans_tanggal));

            switch ($r->trans_status) {
                case '0':
                    $status = "<span class='btn-xs btn-warning'><i class='fa fa-check'></i> Belum</span>";
                    break;
                case '1':
                    $status = "<span class='btn-xs btn-success'><i class='fa fa-check'></i> Sudah</span>";
                    break;
                case '2':
                    $status = "<span class='btn-xs btn-danger'><i class='fa fa-times'></i> Gagal</span>";
                    break;
                
                default:
                    $status = '-';
                    break;
            }
            $row[]  = $this->security->xss_clean($status); 
            $row[]  = $tombolview;
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

}