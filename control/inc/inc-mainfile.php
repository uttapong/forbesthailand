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
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet">
<link href="../css/jquery-ui.css" rel="stylesheet">
<link href="../js/icheck/blue.css" rel="stylesheet">
<link rel="shortcut icon" href="../favicon.ico" />

<script src="../js/modernizr.js"></script>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/bootstrap-tooltip.js"></script>
<script src="../js/main.js"></script>
<script src="../js/jquery.dropdownPlain.js"></script>
<script src="../lib/js/function.js"></script>
<!--
<script src="../js/jquery-ui-1.8.11.custom.min.js"></script>
-->
<script src="../js/jquery-ui.js"></script>
<script src="../js/holder/holder.js"></script>
<script src="../js/jquery.icheck.min.js"></script>



<?
if(is_array($Sys_MainFile)){
foreach($Sys_MainFile as $val){	
	if($val['type']=='javascript'){
		echo 	'<script src="'.$val['path'].'"></script>';
	}	
}
}
?>



</head>