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
        $hariini_total_dok = $this->dashboard_model->hariini_total_dok();
        /*$total_laba_hari_ini = $this->dashboard_model->total_laba_hari_ini();

        $total_penjualan_minggu_ini = $this->dashboard_model->total_penjualan_minggu_ini(); 
        $total_penjualan_bulan_ini = $this->dashboard_model->total_penjualan_bulan_ini(); 
        $laba_bulan_ini = $this->dashboard_model->laba_bulan_ini(); 
         
        $akan_jatuh_tempo = $this->dashboard_model->akan_jatuh_tempo();  
        $sudah_jatuh_tempo = $this->dashboard_model->sudah_jatuh_tempo();  
        $dibayar_minggu = $this->dashboard_model->dibayar_minggu();  
        $total_hutang_belum_bayar = $this->dashboard_model->total_hutang_belum_bayar();  
        $total_piutang_belum_bayar = $this->dashboard_model->total_piutang_belum_bayar();   
        $total_po = $this->db->count_all('purchase_order');
        $total_pembelian = $this->db->count_all('pembelian_langsung');  
        $total_penerimaan = $this->db->count_all('penerimaan_barang'); 
        $total_retur = $this->db->count_all('retur_pembelian');  */
         
        $result = array(   
            "hariini_total_dok" => $this->security->xss_clean($hariini_total_dok->total)

            /*"sudah_jatuh_tempo" => $this->security->xss_clean($sudah_jatuh_tempo." Transaksi"),
            "total_hutang_belum_bayar" => $this->security->xss_clean(rupiah($total_hutang_belum_bayar->total)),
            "total_penjualan_minggu_ini" => $this->security->xss_clean(rupiah($total_penjualan_minggu_ini->total)),
            "total_piutang_belum_bayar" => $this->security->xss_clean(rupiah($total_piutang_belum_bayar->total)),
            "total_penjualan_hari_ini" => $this->security->xss_clean(rupiah($total_penjualan_hari_ini->total)),
            "total_laba_hari_ini" => $this->security->xss_clean(rupiah($total_laba_hari_ini->total)),
            "total_penjualan_bulan_ini" => $this->security->xss_clean(rupiah($total_penjualan_bulan_ini->total)),
            "laba_bulan_ini" => $this->security->xss_clean(rupiah($laba_bulan_ini->total)),
            "dibayar_minggu" => $this->security->xss_clean(rupiah($dibayar_minggu->total)),*/
         );    
        echo'['.json_encode($result).']';
    }

    public function penjualan_2_minggu(){ 
        cekajax(); 
        $now = new DateTime('12 days ago');
        $interval = new DateInterval( 'P1D');
        $period = new DatePeriod( $now, $interval, 13); 
        foreach( $period as $day) {
            $tgl = $day->format( 'Y-m-d');  
            $data['jumlah'] = $this->dashboard_model->penjualan($tgl); 
            $data['tanggal'] = $tgl;
            $data_array[] = $data;
        } 
        echo json_encode($data_array);
    }
    public function cash_2_minggu(){ 
        cekajax();
        $now = new DateTime('12 days ago');
        $interval = new DateInterval( 'P1D');
        $period = new DatePeriod( $now, $interval, 13); 
        foreach( $period as $day) {
            $tgl = $day->format( 'Y-m-d');   
            $masuk = $this->dashboard_model->cash_masuk($tgl); 
            $data['masuk'] = $masuk->total == null ? 0 : $masuk->total;
            $laba = $this->dashboard_model->laba_masuk($tgl); 
            $data['laba'] = $laba->total == null ? 0 : $laba->total;
            $data['tanggal'] = $tgl;
            $data_array[] = $data;
        } 
        echo json_encode($data_array);
    }

    public function graph_1_tahun(){ 
        cekajax();
        $month = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

        foreach( $month as $row) {
           $data = $this->dashboard_model->penjualan_perbulan($row);
           $data_jual[] = $data->total == null ? 0 : (int)$data->total;
           $laba = $this->dashboard_model->laba_perbulan($row);
           $data_laba[] = $laba->total == null ? 0 : (int)$laba->total;
        } 

        $data_array['jual'] = $data_jual;
        $data_array['laba'] = $data_laba;
        echo json_encode($data_array);
    }

    public function graph_1_bulan(){ 
        cekajax();
        $bulan = date('m');
        $tahun = date('Y');
        
        $last_day = $this->lastOfMonth($tahun, $bulan);#echo $last_day;die;

        for ($i=1; $i <= $last_day; $i++) { 
            $data = $this->dashboard_model->penjualan_perhari($tahun.'-'.$bulan.'-'.$i);
            $data_jual[] = $data->total == null ? 0 : (int)$data->total;
            $laba = $this->dashboard_model->laba_perhari($tahun.'-'.$bulan.'-'.$i);
            $data_laba[] = $laba->total == null ? 0 : (int)$laba->total;
            $data_tgl[] = (int)$i;
        }

        $data_array['tanggal'] = $data_tgl;
        $data_array['jual'] = $data_jual;
        $data_array['laba'] = $data_laba;
        echo json_encode($data_array);
    }

    function lastOfMonth($year, $month) {
        return date("d", strtotime('-1 second', strtotime('+1 month',strtotime($month . '/01/' . $year. ' 00:00:00'))));
    }   
    

    public function produk_kadaluarsa(){     
        cekajax();    
        $subitem= $this->dashboard_model->get_produk_kadaluarsa(); 
        $arraysub =[];
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_item;
			$subArray['nama_item']=$r->nama_item;  
			$subArray['tgl_expired']= tgl_indo($r->tgl_expired);       
            $arraysub[] =  $subArray ; 
        }   
        echo'{"datasub":'.json_encode($arraysub).'}';
    }

    public function produk_terlaris(){     
        cekajax();    
        $subitem= $this->dashboard_model->get_produk_terlaris(); 
        $arraysub =[];
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_item;
			$subArray['nama_item']=$r->nama_item;   
			$subArray['total']=$r->total ." ". $r->satuan;  
            $subArray['qty']=$r->stok;    
            $arraysub[] =  $subArray ; 
        }   
        echo'{"datasub":'.json_encode($arraysub).'}';
    }

}
