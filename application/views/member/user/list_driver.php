<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Daftar <?php echo ucwords($current_controller); ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Daftar <?php echo ucwords($current_controller); ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
                        <h3></h3>

						<div class="box-tools pull-right">						 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    	</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover table-striped" id="table_driver">
                                    <thead>
                                        <tr>
                                            <th>Nama Driver</th>
                                            <th>Alamat</th>
                                            <th>No. Hp</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> 
							</div>
						</div>
						<!-- /.row -->
					</div>
					<!-- /.box-footer -->
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

<!-- Control Sidebar -->
<?php $this->load->view('nav/setting.php'); ?>
<div class="control-sidebar-bg"></div>
<?php $this->load->view('nav/footer'); ?>

<script type="text/javascript">
    var table_driver = $('#table_driver').DataTable({  
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": "<?php echo base_url()?>user/data_driver",
            "type": "GET"
        }, 
        "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
        ],  
    });
</script>

