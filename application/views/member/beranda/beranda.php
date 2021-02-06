<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>

<script src="<?php echo base_url() ?>assets/new/plugins/highcharts/charts.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Dashboard
<small>Version 2.0</small>
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
<div class="col-md-3 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-aqua"><i class="ion ion-ios-paperplane"></i></span>
<div class="info-box-content">
<span class="info-box-text">Total Dokumen<br>Diantar Hari Ini</span>
<span class="info-box-number"><strong class="amount" id="hariini_total_dok"></strong></span>
</div>
</div>
</div>
<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<div class="col-md-3 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-green"><i class="ion ion-android-document"></i></span>

<div class="info-box-content">
<span class="info-box-text">KTP</span>
<span class="info-box-number"><strong class="amount" id="laba_hari_ini"></strong></span>
</div>
<!-- /.info-box-content -->
</div>
<!-- /.info-box -->
</div>
<!-- /.col -->

<div class="col-md-3 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-purple"><i class="ion ion-android-document"></i></span>
<div class="info-box-content">
<span class="info-box-text">KK</span>
<span class="info-box-number"><strong class="amount" id="penjualan_bulan_ini"></strong></span>

<!-- <span class="info-box-number"><strong class="amount" id="total_hutang_belum_bayar"></strong></span> -->
</div>
</div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
<div class="info-box">
<span class="info-box-icon bg-yellow"><i class="ion ion-android-document"></i></span>
<div class="info-box-content">
<span class="info-box-text">AKTA</span>
<span class="info-box-number"><strong class="amount" id="laba_bulan_ini"></strong></span>
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

<div class="row">
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
            <div class="" id="graph_1_bulan"></div> 
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
    url: '<?php echo base_url()?>dashboard/laporan_ringkas', // getchart.php
    dataType: 'JSON',
    type: 'GET', 
    success: function(response) {
    $.each(response, function(i, item) {  
    $('#hariini_total_dok').html(item.hariini_total_dok);  
    }); 
    }
});

Highcharts.chart('graph_1_bulan', {
        chart: {
        type: 'column'
        },
        title: {
        text: 'Grafik Per Kecamatan'
        },
        subtitle: {
        text: 'Per Tahun <?php echo date('Y'); ?>'
        },
        xAxis: {
        categories: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
        ],
        crosshair: true
        },
        yAxis: {
        min: 0,
        title: {
        text: 'Jumlah Dokumen Dikirim'
        }
        },

        xAxis: {
        title: {
        text: 'Kecamatan'
        }
        },
        tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
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
        series: [{
        name: 'Tokyo',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
        name: 'New York',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }, {
        name: 'London',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

        }, {
        name: 'Berlin',
        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

        }]
        });

</script>