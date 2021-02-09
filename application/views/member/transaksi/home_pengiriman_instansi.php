<?php $this->load->view('nav/header'); ?>
<?php $this->load->view('nav/menu'); ?>

<!-- daterange -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/new/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo ucwords($current_controller); ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo ucwords($current_controller); ?></li>
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
                            <button class="btn btn-success modal-confirm btn-sm" type="submit" id="submitformView"><i class="fa fa-search"></i> Tampilkan</button>
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
                        <h3></h3>

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
                                            <th width="7%">Aksi</th>
                                            <th>Instansi</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Penerima</th>
                                            <th>Kec / Desa</th>
                                            <th>Tgl Kirim</th>
                                            <th>Status</th>
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

<div class="modal fade" id="viewData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <?php echo form_open('',' id="FormulirView" class="form-horizontal"');?> 
            <div class="modal-header">
                <h4 class="modal-title">Detail <?php echo ucwords($current_controller); ?></h4>
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
                                        <label class="col-sm-3 control-label">Jenis Dokumen <span class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="dokumen_detil" class="form-control" disabled="disabled" />
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

<!-- Control Sidebar -->
<?php $this->load->view('nav/setting.php'); ?>
<div class="control-sidebar-bg"></div>
<?php $this->load->view('nav/footer'); ?>

<script type="text/javascript">
            var tablepengiriman = $('#trans_pengiriman').DataTable({  
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    "url": "<?php echo base_url()?>transaksi/data_pengiriman_per_instansi",
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
                             document.getElementById("image_detil").innerHTML = item.foto; 
                        }); 
                    }
                });  
                return false;
            }
              
        </script>

