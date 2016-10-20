<?
require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ckeditor/ckeditor.js');
if ($ModuleAction=="") $ModuleAction="Datalist";
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html ><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?=$Sys_Title?></title>
<meta name="description" content="uAdmin is a Professional, Responsive and Flat Admin Template created by pixelcave and published on Themeforest">
<meta name="author" content="pixelcave">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="google" value="notranslate" />
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet">
<script src="../js/jquery.js"></script>
<script src="../lib/js/function.js"></script>
</head>
<body class="login" >
<div id="login-logo">
<!--
<a href="#"><img data-src="../js/holder.js/150x100" class="img-polaroid"></a>
-->
<br>
<br>
<br>

</div>

<div id="login-container">

  
<br>
<form id="loginfrm"  method="post" class="form-inline" style="display:inline-block" onSubmit="return false;" >
<input type="hidden" name="ModuleAction" id="ModuleAction" value="Login"  />
<div class="control-group">
<div class="input-prepend">
<span class="add-on"><i class="icon-user"></i></span>
<input type="text" id="inputLoginUsername" name="inputLoginUsername" placeholder="Username.." required>
</div>
</div>
<div class="control-group">
<div class="input-prepend">
<span class="add-on"><i class="icon-asterisk"></i></span>
<input type="password" id="inputLoginPassword" name="inputLoginPassword" placeholder="Password.." required>
</div>
</div>
<div class="control-group remove-margin clearfix">
<div class="btn-group pull-right">
<button id="login-button-pass" class="btn btn-small btn-warning" data-toggle="tooltip" title="" data-original-title="Forgot pass?"><i class="icon-lock"></i></button>
<button onClick="SystemLogin();" class="btn btn-small btn-success"><i class="icon-arrow-right"></i> Login</button>
</div>

</div>
</form>
<script>
$('#inputLoginPassword').bind('keypress', function(e) {
	if(e.keyCode==13){
		SystemLogin();
	}
});
</script>
</div>
</body>
</html>