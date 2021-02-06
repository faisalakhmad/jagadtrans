<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Ubah Password
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Ubah Password</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="box">
                    <?php echo form_open('password/gantipassword',' id="Formulir" ',' class="form-horizontal" ');?> 
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
							     <div class="form-group password">
                                    <label class="col-sm-5 control-label">Password </label>
                                    <div class="col-sm-7">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div><br><br>
                                <div class="form-group password2">
                                    <label class="col-sm-5 control-label">Konfirmasi Password </label>
                                    <div class="col-sm-7">
                                        <input type="password" name="password2" class="form-control">
                                    </div>
                                </div>
                            </div>
						</div>
						<!-- /.row -->
					</div>
                    <div class="box-footer">
                        <button class="btn btn-primary btn-sm" id="submitform">Submit </button>
                        <button type="reset" class="btn btn-default btn-sm">Reset</button>
                    </div>
					<!-- /.box-footer -->
                    </form>
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

<script> 
    $(document).ready(function() {
        document.getElementById("Formulir").addEventListener("submit", function (e) {  
            PNotify.removeAll();  
            blurForm();       
            $('.form-group').removeClass('has-error');
            document.getElementById("submitform").setAttribute('disabled','disabled');
            $('#submitform').html('Loading ...');
            var form = $('#Formulir')[0];
            var formData = new FormData(form);
            var xhrAjax = $.ajax({
            type        : 'POST',
            url         : $(this).attr('action'), 
            data        : formData, 
            processData: false,
            contentType: false,
            cache: false, 
            dataType    : 'json'
            }).done(function(data) { 
            if ( ! data.success) {       
                $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                document.getElementById("submitform").removeAttribute('disabled');  
                $('#submitform').html('Submit');    
                var objek = Object.keys(data.errors);   
                for (var key in data.errors) {
                    if (data.errors.hasOwnProperty(key)) { 
                        $('.'+key).addClass('has-error');   
                            new PNotify({
                                title: 'Notifikasi Eror',
                                text: data.errors[key],
                                type: 'error'
                            }); 
                    }
                }  
            } else { 
                $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                document.getElementById("submitform").removeAttribute('disabled'); 
                document.getElementById("Formulir").reset();  
                $('#submitform').html('Submit'); 
                new PNotify({
                    title: 'Notifikasi',
                    text: data.message,
                    type: 'success'
                }); 
            }
            }).fail(function(data) {  
                document.getElementById("submitform").removeAttribute('disabled'); 
                $('#submitform').html('Submit');     
                new PNotify({
                    title: 'Notifikasi',
                    text: "Request gagal, browser akan direload",
                    type: 'danger'
                }); 
                window.setTimeout(function() {  location.reload();}, 2000);
            }); 
            e.preventDefault(); 
        });
    });
</script>

