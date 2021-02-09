<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>

<script src="<?php echo base_url() ?>assets/new/plugins/highcharts/charts.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Selamat Datang Kembali, <?php echo $this->session->userdata('nama_admin'); ?>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<!-- Info boxes -->
<div class="row">
<div class="col-md-4 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-green"><i class="ion ion-ios-paperplane"></i></span>
<div class="info-box-content">
<span class="info-box-text">Jumlah Dokumen <b>Sudah</b><br>Diantar Hari Ini</span>
<span class="info-box-number"><strong class="amount" id="hariini_total_dok_sukses"></strong></span>
</div>
</div>
</div>
<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<div class="col-md-4 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-aqua"><i class="ion ion-ios-paperplane"></i></span>

<div class="info-box-content">
<span class="info-box-text">Jumlah Dokumen <b>Belum</b><br>Diantar Hari Ini</span>
<span class="info-box-number"><strong class="amount" id="hariini_total_dok_belum"></strong></span>
</div>
<!-- /.info-box-content -->
</div>
<!-- /.info-box -->
</div>
<!-- /.col -->
<div class="clearfix visible-sm-block"></div>

<div class="col-md-4 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-red"><i class="ion ion-ios-paperplane"></i></span>
<div class="info-box-content">
<span class="info-box-text">Jumlah Dokumen <b>Gagal</b><br>Diantar Hari Ini</span>
<span class="info-box-number"><strong class="amount" id="hariini_total_dok_gagal"></strong></span>

<!-- <span class="info-box-number"><strong class="amount" id="total_hutang_belum_bayar"></strong></span> -->
</div>
</div>
</div>

</div>
<!-- /.row -->

<div class="row">

<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<!-- /.col -->
</div>
<!-- /.row -->

<div class="row" style="display: none;">
<div class="col-md-12">
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>

    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
    </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="" id="graph_per_kecamatan"></div> 
        </div>
    </div>
    <!-- /.row -->
    </div>
    <!-- ./box-body -->

    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('nav/top_footer.php'); ?>
<?php $this->load->view('nav/setting.php'); ?>
<div class="control-sidebar-bg"></div>

<?php $this->load->view('nav/footer'); ?>

<script> 

$.ajax({
    url: '<?php echo base_url()?>dashboard/laporan_ringkas_per_instansi', // getchart.php
    dataType: 'JSON',
    type: 'GET', 
    success: function(response) {
    $.each(response, function(i, item) {  
    $('#hariini_total_dok_sukses').html(item.hariini_total_dok); 
    $('#hariini_total_dok_belum').html(item.hariini_total_dok_belum); 
    $('#hariini_total_dok_gagal').html(item.hariini_total_dok_gagal);  
    }); 
    }
});

/*$.ajax({
    url: '<?php echo base_url()?>dashboard/graph_per_kecamatan', // getchart.php
    dataType: 'JSON',
    type: 'GET', 
    success: function(response) {
        Highcharts.chart('graph_per_kecamatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Pengiriman Dokumen <b>Sudah</b> Diantar Per Kecamatan'
        },
        subtitle: {
        text: 'Per Hari Aktif'
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Dokumen Dikirim'
            }
        },

        xAxis: {
            categories: [
            '<?php echo date('d/m/Y'); ?>',
            ],
            crosshair: true
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px"><b>KECAMATAN</b></span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}</td>' +
            '<td style="padding:0">: <b>{point.y} Dokumen</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: response.grap
        });
    }
}); */



</script>