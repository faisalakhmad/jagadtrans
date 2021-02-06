
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo APP_NAME ?> | Log in</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="assets/new/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/new/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/new/bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="assets/new/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="assets/new/plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="login-logo">
<a><b><?php echo APP_NAME_FRONT ?></b><?php echo APP_NAME_END ?></a>
</div>
<!-- /.login-logo -->
<div class="login-box-body">
<p class="login-box-msg">Sign in to start your session</p>

<?php echo form_open('login/authlogin',' id="Formulir" ');?> 
<div class="form-group has-feedback username">
<input name="username" type="text" class="form-control" placeholder="Username" value="" />
<span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback password">
<input name="password" type="password" class="form-control" placeholder="Password" value="" />
<span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
<div class="col-xs-8">
<div class="checkbox icheck">
</div>
</div>
<!-- /.col -->
<div class="col-xs-4">
<button type="submit" class="btn btn-primary btn-block btn-flat" id="submitform">Log In</button>
</div>
<!-- /.col -->
</div>
</form>
</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="assets/new/bower_components/jquery/dist/jquery.min.js"></script>
<script src="assets/new/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>    
<script src="assets/new/plugins/iCheck/icheck.min.js"></script>
<script src="assets/javascripts/theme.init.js"></script>
<script src="assets/vendor/pnotify/pnotify.custom.js"></script>

<script>  
document.getElementById("Formulir").addEventListener("submit", function (e) {  
blurForm();      
$('.help-block').hide();
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
window.setTimeout(function() {  
document.getElementById("submitform").removeAttribute('disabled');  
$('#submitform').html('Login');    
var objek = Object.keys(data.errors);                     

for (var key in data.errors) {
if (data.errors.hasOwnProperty(key)) { 
var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
$('.'+key).addClass('has-error');
$('input[name="' + key + '"]').after(msg);  
}
}   
}, 500);
return false;
} else { 
$('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
PNotify.removeAll();  
document.getElementById("submitform").removeAttribute('disabled'); 
document.getElementById("Formulir").reset();  
$('#submitform').html('Login');
new PNotify({
title: 'Notifikasi',
text: data.message,
type: 'success'
}); 
window.location='<?php echo base_url()?>'+data.beranda;   
}
}).fail(function(data) {  
document.getElementById("submitform").removeAttribute('disabled'); 
$('#submitform').html('Login');    
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

</body>
</html>
