<? require("./lib/system_core.php"); ?>
<?  
$mgroup="HOME_MAIN";  
$did=$_REQUEST["did"];
$url_share=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/intro-detail.php?did=".$did;
updateStateArticle($did,$url_share);

$sql = "select p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,p.content_".strtolower($_SESSION['FRONT_LANG'])." as content_html ,u.firstname,u.lastname,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname  from ads_main p ";
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
                                       <span>FORBES THAILAND</span>
                                   </div>
                                   <div class="cat-navy"></div>
                                   <div class="clearfix"></div>
                                   <div class="article-detail"> 
                                 <?                             
 if($RowHead["flag_media"]=="UPLOADFILE"){
?>
     <script src="./johndyer-mediaelement/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="./johndyer-mediaelement/mediaelementplayer.min.css" />
  <div class="align-center">  
  <?

$physical_name="./uploads/ads/".$RowHead["filepic"];
	$flag_pic=1;
if (!(is_file($physical_name) && file_exists($physical_name) )) {
	$physical_name="./images/photo_not_available.jpg";
	$flag_pic=0;
}				
?>
<video class="vdoplay align-center" width="666" height="400" style="width: 100%; height: 100%;"  poster="<?=$physical_name?>" src="<?="./uploads/media/".$RowHead["filemedia_physical"]?>" type="video/mp4" 
id="player1" controls="controls" autoplay="false" preload="none"></video>
<script>

$('audio,video').mediaelementplayer({
mode: 'shim',
success: function(player, node) {
$('#' + node.id + '-mode').html('mode: ' + player.pluginType);
}
});

</script>
</div>
<? }else if($RowHead["flag_media"]=="EMBED"){ ?>
<div class="vdo_content align-center" >
<?php
    $url = $RowHead["embed_code"];
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
    $id = $matches[1];
  
?>
<iframe id="ytplayer" type="text/html" 
    src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
    frameborder="0" allowfullscreen></iframe> 
</div>

<? }else if($RowHead["flag_media"]=="UPLOADPIC"){ ?>
<?
$physical_name="./uploads/ads/".$RowHead["filepiccontent"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}
	if($flag_pic){
?>
    <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
    <? } ?>
<? } ?>
   <p class="topic">
  <?=$RowHead["name_content"]?>
   </p>
    <?=$RowHead["content_html"]?>
   <div class="clearfix"></div><br>
   <div class="img-writer">
   <?
  		$physical_user="./uploads/users/".$RowHead["filepic_user"];
	
		if (!(is_file($physical_user) && file_exists($physical_user) )) {
			$physical_user="./images/photo_not_available.jpg";
		
		}		
	?>
     <img src="<?=$physical_user?>" class="img-responsive">
   </div>
   <div class="txt-writer">
      <span class="name"><?=$RowHead["firstname"]?>  <?=$RowHead["lastname"]?></span><br>
      <span class="position"><?=$RowHead["usergroupname"]?></span>    
   </div>
    <div class="clearfix"></div><br>
    <p class="update">Update : <?=$dateshow?></p>
    <p class="view">View : <?=number_format($RowHead["cstate"],0)?></p><br>
    
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57021aaab4d01ff0"></script>


    <div class="box-click">
      <div class="share">
       <div class="addthis_sharing_toolbox"></div>
      </div>
      
      
      <div class="like">
      
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=509623369080549";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	
    <div class="fb-like" data-href="<?=$url_share?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>

      </div>
    </div>

                                   </div>  
                                <?
	$sql = "SELECT p.* FROM ads_file p";
	$sql.= " WHERE p.article_id='".$did."'";		
	$sql.= " order by p.order_by ";
	$Conn->query($sql);
	
	$SlideList = $Conn->getResult();
	$CntRecSlide = $Conn->getRowCount();
  	if($CntRecSlide>0){
?>

                      <div class="topic-gallery">
                                      <span>Photo Gallery</span>                                 
                                   </div>  
                                   <div class="list-gal">
                                    <?  
 	for ($i=0;$i<$CntRecSlide;$i++) { 
		$Row = $SlideList[$i];
		$physical_name="./uploads/ads/".$Row["physical_name"];
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
		}
 ?>
                                     <div class="col-xs-12 col-sm-4 mbc">
                                      <a class="fancybox" rel="galleryset" href="<?=$physical_name?>">
                                        <img src="<?=$physical_name?>" class="img-responsive align-center"/>
                                      </a>
                                     </div>
                                  
                                       <? } ?>  
                                  
                                     <script type="text/javascript">
                                       $(document).ready(function(){
                                        $(".fancybox").fancybox({
                                          openEffect  : 'none',
                                          closeEffect : 'none'
                                        });
                                      });
                                     </script>
                                   </div>    
                                   
                                   
                                       <? } ?>
                                                             
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-xs-12 col-sm-4">
                      <div class="row">
                           <? include('./inc-banner-right.php');	?>
                           <? include('./inc-popular-top.php');	?>      
                      </div>
                   </div>
                   <div class="clearfix"></div>
                 
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