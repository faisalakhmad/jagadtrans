<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo ucwords($label); ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Data <?php echo ucwords($label); ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
                        <?php  
                        echo level_user('informasi','index', $this->session->userdata('kategori'),'add') > 0 ? '<a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Informasi</a>':'&nbsp;';
                        ?>

						<div class="box-tools pull-right">						 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    	</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover table-striped" id="table_informasi">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>Judul</th>
                                            <th>Isi</th>
                                            <th>Tanggal</th>
                                            <th width="10%">Aksi</th>
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

<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('informasi/informasi_tambah',' id="FormulirTambah" class="form-horizontal"');?>  
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?php echo ucwords($label); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group judul">
                    <label class="col-sm-3 control-label">Judul <?php echo ucwords($label); ?> <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="judul" class="form-control" maxlength="255" />
                    </div>
                </div> 
                <div class="form-group isi">
                    <label class="col-sm-3 control-label">Isi <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <textarea name="isi" cols="60" rows="8"></textarea>
                    </div>
                </div> 
            </div>
            <footer class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary modal-confirm" type="submit" id="submitform">Simpan</button>
                        <button class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </footer>
            </form>
        </div>
    </div>
</div>
         
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('informasi/informasi_edit',' id="FormulirEdit" class="form-horizontal"');?>  
            <input type="hidden" name="idd" id="idd">
            <div class="modal-header">
                <h4 class="modal-title">Edit <?php echo ucwords($label); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group judul">
                    <label class="col-sm-3 control-label">Judul <?php echo ucwords($label); ?> <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="judul" id="judul_detail" class="form-control" maxlength="255" />
                    </div>
                </div>
                <div class="form-group isi">
                    <label class="col-sm-3 control-label">Isi <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <textarea name="isi" cols="60" rows="8" id="isi_detail"></textarea>
                    </div>
                </div> 
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary modal-confirm" type="submit" id="submitformEdit">Simpan Perubahan</button>
                        <button class="btn btn-default" data-dismiss="modal">Batalkan</button>
                    </div>
                </div>
            </footer>
            </form>
        </div>
    </div>
</div>

       <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel  panel-danger">
                    <header class="panel-heading">
                        <h2 class="panel-title">Konfirmasi Hapus Data</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <h4>Yakin ingin menghapus data informasi judul <label id="nama_hapus"></label> ?</h4> 
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer"> 
                        <div class="row">
                            <div class="col-md-12 text-right"> 
                                <?php echo form_open('informasi/informasi_delete',' id="FormulirHapus"');?>  
                                <input type="hidden" name="idd" id="idddelete">
                                <button type="submit" class="btn btn-danger" id="submitformHapus">Ya</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                                </form>
                            </div>
                        </div>
                    </footer>
                </section>
                </div>
            </div>
        </div>  



<!-- Control Sidebar -->
<?php $this->load->view('nav/setting.php'); ?>
<div class="control-sidebar-bg"></div>
<?php $this->load->view('nav/footer'); ?>

<script type="text/javascript">
            var table_informasi = $('#table_informasi').DataTable({  
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    "url": "<?php echo base_url()?>informasi/data_informasi",
                    "type": "GET"
                }, 
                "columnDefs": [
                    { 
                        "targets": [ 0 ], 
                        "orderable": false, 
                    },
                ],  
            });

            document.getElementById("FormulirTambah").addEventListener("submit", function (e) {  
            blurForm();       
            $('.help-block').hide();
            $('.form-group').removeClass('has-error');
            document.getElementById("submitform").setAttribute('disabled','disabled');
            $('#submitform').html('Loading ...');
            var form = $('#FormulirTambah')[0];
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
                    $('#submitform').html('Simpan');    
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) { 
                            var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                            $('.'+key).addClass('has-error');
                            $('input[name="' + key + '"]').after(msg);  
                            $('textarea[name="' + key + '"]').after(msg);  
                        }
                        if (key == 'fail') {   
                            new PNotify({
                                title: 'Notifikasi',
                                text: data.errors[key],
                                type: 'danger'
                            }); 
                        }
                    }
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll(); 
                    table_informasi.ajax.reload();   
                    document.getElementById("submitform").removeAttribute('disabled'); 
                    $('#tambahData').modal('hide'); 
                    document.getElementById("FormulirTambah").reset();  
                    $('#submitform').html('Simpan');   
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.message,
                        type: 'success'
                    });  
                }
                }).fail(function(data) {   
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            }); 
            
            function edit(elem){
                var dataId = $(elem).data("id");
                document.getElementById("idd").setAttribute('value', dataId);
                $('#editData').modal();        
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>informasi/informasi_detail',
                    data: 'id=' + dataId,
                    dataType    : 'json',
                    success: function(response) {  
                        $.each(response, function(i, item) { 
                        document.getElementById("judul_detail").setAttribute('value', item.judul); 
                        document.getElementById("isi_detail").value = item.isi; 
                        }); 
                    }
                });  
                return false;
            }
            document.getElementById("FormulirEdit").addEventListener("submit", function (e) {  
            blurForm();       
            $('.help-block').hide();
            $('.form-group').removeClass('has-error');
            document.getElementById("submitformEdit").setAttribute('disabled','disabled');
            $('#submitformEdit').html('Loading ...');
            var form = $('#FormulirEdit')[0];
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
                    document.getElementById("submitformEdit").removeAttribute('disabled');  
                    $('#submitformEdit').html('Simpan Perubahan');    
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) { 
                            var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                            $('.'+key).addClass('has-error');
                            $('input[name="' + key + '"]').after(msg);  
                            $('textarea[name="' + key + '"]').after(msg);
                        }
                        if (key == 'fail') {   
                            new PNotify({
                                title: 'Notifikasi',
                                text: data.errors[key],
                                type: 'danger'
                            }); 
                        }
                    }
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll();
                    table_informasi.ajax.reload();    
                    document.getElementById("submitformEdit").removeAttribute('disabled'); 
                    $('#editData').modal('hide');        
                    document.getElementById("FormulirEdit").reset();    
                    $('#submitformEdit').html('Simpan Perubahan');   
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.message,
                        type: 'success'
                    });
                }
                }).fail(function(data) {    
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            }); 
            function hapus(elem){ 
                var dataId      = $(elem).data("id");
                var data_nama   = $(elem).data("title");
                document.getElementById("idddelete").setAttribute('value', dataId);
                document.getElementById("nama_hapus").innerHTML = data_nama;
                $('#modalHapus').modal();        
            }
            document.getElementById("FormulirHapus").addEventListener("submit", function (e) {  
            blurForm();       
            $('.help-block').hide();
            $('.form-group').removeClass('has-error');
            document.getElementById("submitformHapus").setAttribute('disabled','disabled');
            $('#submitformHapus').html('Loading ...');
            var form = $('#FormulirHapus')[0];
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
                    document.getElementById("submitformHapus").removeAttribute('disabled');  
                    $('#submitformHapus').html('Ya');     
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) { 
                        if (key == 'fail') {   
                            new PNotify({
                                title: 'Notifikasi',
                                text: data.errors[key],
                                type: 'danger'
                            }); 
                        }
                    }
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll();   
                    table_informasi.ajax.reload();
                    document.getElementById("submitformHapus").removeAttribute('disabled'); 
                    $('#modalHapus').modal('hide');        
                    document.getElementById("FormulirHapus").reset();    
                    $('#submitformHapus').html('Ya'); 
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.message,
                        type: 'success'
                    });  
                }
                }).fail(function(data) {   
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            }); 
              
        </script>

