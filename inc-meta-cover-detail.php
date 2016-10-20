<title><?=_SYSTEM_WEB_TITLE_?> : <?=$RowHead["name_content"]?></title>
<link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon" />
<meta name="description" content="<?=$content_des?>" />
<meta name="keywords" content="<?=$RowHead["keyword_".strtolower($_SESSION['FRONT_LANG'])]?>" />
<meta property="og:title"           content="<?=$RowHead["name_content"]?>" />
<meta property="og:description"           content="<?=$content_des?>" />
<meta property="og:url"           content="<?=$url_share?>" />
<?
$physical_name="./uploads/cover/".$RowHead["filepic"];
if ((is_file($physical_name) && (file_exists($physical_name)))  ) {
	?>
   <meta property="og:image"   content="<?=_SYSTEM_HOST_NAME_?>/<?="uploads/cover/".$RowHead["filepic"]?>?<?=date('U')?>" /> 
    <?
}
?>
 <link href='https://fonts.googleapis.com/css?family=Kanit:200,500' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css"/>
<link rel="stylesheet" type="text/css" href="css/owl-carousel/owl.carousel.css"/>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="js/modernizr.js"></script>
<script src="js/jquery/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script> 
<script src="./css/owl-carousel/owl.carousel.js"></script>