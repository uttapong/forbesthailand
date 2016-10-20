<? require("./lib/system_core.php"); ?>
<?  
$mgroup="TOPLIST_MAIN";  
$did=$_REQUEST["did"];
$url_share=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/toplist-detail.php?did=".$did;
updateStateArticle($did,$url_share);

$sql = "select p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,p.content_".strtolower($_SESSION['FRONT_LANG'])." as content_html ,u.firstname,u.lastname,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname  from article_main p ";
$sql.=" left join sysuser u on(u.username=p.createby) ";
$sql.= "where  p.id='".$did."' ";
$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];

$cid=$RowHead["cate_id"];
$source_navi=getCategoryNavi($cid);
$cate_lel1=$source_navi['cate_lel1'];
$cate_lel2=$source_navi['cate_lel2'];

if($RowHead["menu_id"]==""){
	header("location:index.php");
}

$dateshow= getDisplayDate($RowHead["updatedate"]);
$content_des=$RowHead["content_".strtolower($_SESSION['FRONT_LANG'])];
$content_des = preg_replace("/<img[^>]+\>/i", " ", $content_des); 
$content_des=strip_tags($content_des);
$content_des = SystemSubString($content_des,200,'');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?	include('./inc-meta-detail.php');	?>
    <link href='https://fonts.googleapis.com/css?family=Kanit:200,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css"/>
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
  
  </head>
  <body>
      <!-- START HEADER -->
           <?	include('./inc-menu.php');	?>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <!-- START CONTENT -->
   <article>   
        <?php include("inc-banner-head.php"); ?>
       <section class="content">
           <div class="container">
               <div class="row">
                   <div class="col-xs-12 col-sm-8 mb">
                       <div class="row">
                           <div class="col-xs-12 mbc">
                               <div class="block">
                                   <div class="tab-block">
                                       <span>TOP LIST</span>
                                   </div>
                                   <div class="cat-navy"></div>
                                   <div class="clearfix"></div>
                                   <div class="article-detail"> 
                                   <?	include('./inc-content-detail.php');	?> 
                                   </div>  
                                   <?	include('./inc-gallery.php');	?>   
                                                             
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-xs-12 col-sm-4">
                      <div class="row">
                           <? include('./inc-banner-right.php');	?>
                           <? $mid="MNT16";include('./inc-popular-top.php');	?>      
                      </div>
                   </div>
                   <div class="clearfix"></div>
                   <?	$mid="MNT16"; include('./inc-similar.php');	?>
                   <?	include('./inc-other.php');	?> 
                    <?	include('./inc-contributor.php');	?>    
               </div>
           </div>
       </section>
                 <?	include('./inc-banner-footer.php');	?>
   </article>
   <div class="clearfix"></div>
        <!-- END  CONTENT -->
 <? include('./inc-footer.php');?>
  </body>
</html>