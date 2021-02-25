<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>

<!-- daterange -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/new/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo ucwords($label); ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo ucwords($label); ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo form_open('transaksi/filter',' id="FormulirFilter" class="form-horizontal"');?>  
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter</h3>

                        <div class="box-tools pull-right">                       
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Instansi</label>
                                    <div class="col-sm-9">
                                        <select class="select2" name="instansi">
                                            <option value="all">- SEMUA -</option> 
                                            <?php foreach ($instansi as $ins): 
                                            $selected = ($ins->instansi_id == $filter_instansi) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $ins->instansi_id;?>" <?php echo $selected?> ><?php echo $ins->instansi_nama;?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Jenis Dokumen</label>
                                    <div class="col-sm-9">
                                        <select class="select2" name="jenis_dok">
                                            <option value="all">- SEMUA -</option> 
                                            <?php foreach ($jenis_dok as $jdok):
                                            $selected = ($jdok->jdok_id == $filter_jdok) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $jdok->jdok_id;?>" <?php echo $selected?> ><?php echo $jdok->jdok_nama;?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tgl Kirim</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="tgl_kirim" class="form-control float-right" id="date_range" value="<?php echo $tgl_kirim ;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Kec / Desa</label>
                                    <div class="col-sm-9">
                                        <select class="select2" name="desa">
                                            <option value="all">- SEMUA -</option> 
                                            <?php foreach ($desa as $row):
                                            $selected = ($row->desa_id == $filter_desa) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $row->desa_id;?>" <?php echo $selected?> ><?php echo $row->label;?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status Kirim</label>
                                    <div class="col-sm-9">
                                        <select class="select2" name="status_kirim">
                                            <option value="all">- SEMUA -</option> 
                                            <?php foreach ($status_kirim as $row):
                                            $selected = ($row['id'] == $filter_status) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $row['id'];?>" <?php echo $selected?> ><?php echo $row['label']; ?></option>
                                            <?php endforeach; ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button class="btn btn-default modal-confirm btn-sm" type="submit" id="submitformView"><i class="fa fa-search"></i> Tampilkan</button>
                        </div>
                    </div>
                </div>
                </form>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
                        <?php  
                        echo level_user('transaksi', 'index', $this->session->userdata('kategori'),'add') > 0 ? '<a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah</a>':'&nbsp;';
                        ?>
                        <a class="btn btn-warning btn-sm" href="<?php echo base_url('transaksi/print_pdf/'); ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Cetak PDF</a>
                        <a class="btn btn-primary btn-sm" href="<?php echo base_url('transaksi/eksport_xls/'); ?>"><i class="fa fa-file-excel-o"></i> Export Xls</a>

						<div class="box-tools pull-right">						 
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    	</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover table-striped" id="trans_pengiriman">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>Instansi</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Driver</th>
                                            <th>Penerima</th>
                                            <th>Kec / Desa</th>
                                            <th>Tgl Kirim</th>
                                            <th>Status Kirim</th>
                                            <th width="13%">Aksi</th>
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
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <?php echo form_open('transaksi/pengiriman_tambah',' id="FormulirTambah" class="form-horizontal" enctype="multipart/form-data" ');?>  
            <div class="modal-header">
                <h4 class="modal-title">Tambah <?php echo ucwords($label); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Instansi <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="instansi">  
                                    <?php foreach ($instansi as $ins): ?>
                                    <option value="<?php echo $ins->instansi_id;?>"><?php echo $ins->instansi_nama;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>                        
                        <div class="form-group penerima">
                            <label class="col-sm-3 control-label">Penerima <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="penerima" class="form-control" maxlength="100" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kecamatan / Desa <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="desa">  
                                    <?php foreach ($desa as $row): ?>
                                    <option value="<?php echo $row->desa_id;?>"><?php echo $row->label;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group alamat">
                            <label class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" name="alamat" class="form-control" maxlength="255" />
                            </div>
                        </div>
                        <div class="form-group lokasi">
                            <label class="col-sm-3 control-label">Lokasi</label>
                            <div class="col-sm-9">
                                <input type="text" name="lokasi" class="form-control" maxlength="255" />
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Dokumen <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="jenis_dok">  
                                    <?php foreach ($jenis_dok as $jns): ?>
                                    <option value="<?php echo $jns->jdok_id;?>"><?php echo $jns->jdok_nama;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group driver">
                            <label class="col-sm-3 control-label">Driver <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="driver">  
                                    <?php foreach ($driver as $drv): ?>
                                    <option value="<?php echo $drv->id;?>"><?php echo $drv->nama_admin;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group keterangan">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9">
                                <input type="text" name="keterangan" class="form-control" />
                            </div>
                        </div>
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
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <?php echo form_open('transaksi/pengiriman_edit',' id="FormulirEdit" class="form-horizontal"');?> 
            <input type="hidden" name="idd" id="idd"> 
            <div class="modal-header">
                <h4 class="modal-title">Edit <?php echo ucwords($label); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Instansi <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="instansi" id="instansi">  
                                    <?php foreach ($instansi as $ins): ?>
                                    <option value="<?php echo $ins->instansi_id;?>"><?php echo $ins->instansi_nama;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>                        
                        <div class="form-group penerima">
                            <label class="col-sm-3 control-label">Penerima <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="penerima" id="penerima" class="form-control" maxlength="100" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kecamatan / Desa <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="desa" id="desa">  
                                    <?php foreach ($desa as $row): ?>
                                    <option value="<?php echo $row->desa_id;?>"><?php echo $row->label;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group alamat">
                            <label class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" name="alamat" id="alamat" class="form-control" maxlength="255" />
                            </div>
                        </div>
                        <div class="form-group lokasi">
                            <label class="col-sm-3 control-label">Lokasi</label>
                            <div class="col-sm-9">
                                <input type="text" name="lokasi" id="lokasi" class="form-control" maxlength="255" />
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jenis Dokumen <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="jenis_dok" id="jenis_dok">  
                                    <?php foreach ($jenis_dok as $jns): ?>
                                    <option value="<?php echo $jns->jdok_id;?>"><?php echo $jns->jdok_nama;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group driver">
                            <label class="col-sm-3 control-label">Driver <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select class="select2" name="driver" id="driver_detil">  
                                    <?php foreach ($driver as $drv): ?>
                                    <option value="<?php echo $drv->id;?>"><?php echo $drv->nama_admin;?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group keterangan">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9">
                                <input type="text" name="keterangan" id="keterangan" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary modal-confirm" type="submit" id="submitformEdit">Simpan Perubahan</button>
                        <button class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </footer>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <?php echo form_open('',' id="FormulirView" class="form-horizontal"');?> 
            <div class="modal-header">
                <h4 class="modal-title">Detail <?php echo ucwords($label); ?></h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Detail Info</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Foto</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Instansi</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="instansi_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div>                        
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Penerima</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="penerima_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Penerima Barang</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="penerima_barang_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Kecamatan / Desa</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="kec_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                             <input type="text" id="alamat_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Lokasi</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="lokasi_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Jenis Dokumen</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="dokumen_detil" class="form-control" disabled="disabled" />
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Driver</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="driver_view" class="form-control" disabled="disabled" />
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Keterangan</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="keterangan_detil" class="form-control" disabled="disabled"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Catatan</label>
                                        <div class="col-sm-9">
                                            <textarea id="catatan_detil" style="width: 100%" disabled="disabled"></textarea>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-sm-9" id="image_detil"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <footer class="modal-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-default" data-dismiss="modal">Tutup</button>
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
                                <h4>Yakin ingin menghapus data transaksi pengiriman ?</h4>
                                <blockquote class="quote-secondary">
                                    <div id="instansi_hapus"></div>
                                    <div id="nama_hapus"></div>
                                    <div id="tgl_hapus"></div>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer"> 
                        <div class="row">
                            <div class="col-md-12 text-right"> 
                                <?php echo form_open('transaksi/pengiriman_delete',' id="FormulirHapus"');?>  
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
            var tablepengiriman = $('#trans_pengiriman').DataTable({  
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    "url": "<?php echo base_url()?>transaksi/data_pengiriman",
                    "type": "GET"
                }, 
                "columnDefs": [
                    { 
                        "targets": [ 0 ], 
                        "orderable": false, 
                    },
                ],  
            });

            document.getElementById("FormulirFilter").addEventListener("submit", function (e) {
                $('#submitformView').html('Loading ...');
                document.getElementById("submitformView").setAttribute('disabled','disabled');
                var form = $('#FormulirFilter')[0];
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
                         
                    }else{
                        tablepengiriman.ajax.reload(); 
                    }
                    document.getElementById("submitformView").removeAttribute('disabled');
                    $('#submitformView').html('<i class="fa fa-search"></i> Tampilkan'); 
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
                    tablepengiriman.ajax.reload();   
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
                    url: '<?php echo base_url()?>transaksi/pengiriman_detail_edit',
                    data: 'id=' + dataId,
                    dataType    : 'json',
                    success: function(response) {  
                        $.each(response, function(i, item) { 
                            document.getElementById("penerima").setAttribute('value', item.penerima); 
                            document.getElementById("alamat").setAttribute('value', item.alamat);
                            document.getElementById("lokasi").setAttribute('value', item.lokasi); 
                            document.getElementById("keterangan").setAttribute('value', item.keterangan);
                            $("#instansi").select2("val", item.instansi);
                            $("#desa").select2("val", item.desa);
                            $("#jenis_dok").select2("val", item.dok_id);
                            $("#driver_detil").select2("val", item.driver);
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
                    tablepengiriman.ajax.reload();    
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
                var nama_dok    = $(elem).data("nama_dok");
                var inst        = $(elem).data("inst");
                var tgl         = $(elem).data("tgl");

                document.getElementById("idddelete").setAttribute('value', dataId);
                document.getElementById("nama_hapus").innerHTML = "Jenis Dokumen " + nama_dok;
                document.getElementById("instansi_hapus").innerHTML = inst;
                document.getElementById("tgl_hapus").innerHTML = "Tanggal " + tgl;
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
                    tablepengiriman.ajax.reload();
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

            function view(elem){
                var dataId = $(elem).data("id");
                $('#viewData').modal();        
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>transaksi/pengiriman_detail',
                    data: 'id=' + dataId,
                    dataType    : 'json',
                    success: function(response) {  
                        $.each(response, function(i, item) { 
                            document.getElementById("instansi_detil").value = item.instansi; 
                            document.getElementById("penerima_detil").value = item.penerima;
                            document.getElementById("penerima_barang_detil").value = item.penerima_barang;
                            document.getElementById("kec_detil").value = item.desa; 
                            document.getElementById("alamat_detil").value = item.alamat; 
                            document.getElementById("keterangan_detil").value = item.keterangan;
                            document.getElementById("catatan_detil").value = item.catatan;
                            document.getElementById("lokasi_detil").value = item.lokasi;
                            document.getElementById("dokumen_detil").value = item.dokumen;
                            document.getElementById("driver_view").value = item.driver;
                            document.getElementById("image_detil").innerHTML = item.foto; 
                        }); 
                    }
                });  
                return false;
            }
              
        </script>

