</div>
<!-- ./wrapper -->
<script src="<?php echo base_url() ?>assets/new/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/new/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/chart.js/Chart.js"></script>
<script src="<?php echo base_url() ?>assets/new/dist/js/demo.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/select2/select2.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/javascripts/theme.init.js"></script> 
<script src="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/raphael/raphael.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/morris/morris.js"></script>

<script src="<?php echo base_url() ?>assets/new/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/new/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
$('.select2').select2({
});

$('#date_range').daterangepicker({
locale: { 
format: 'DD/MM/YYYY',
cancelLabel: 'Clear'
}
});

$('#date_range').on('cancel.daterangepicker', function(ev, picker) {
//do something, like clearing an input
$('#date_range').val('');
});
</script>

</body>
</html>