<? require("./lib/system_core.php"); ?>
<?  
$mgroup="FORBES_LIFE_MAIN";  
$did=$_REQUEST["did"];
$url_share=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/forbes-life-detail.php?did=".$did;
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
                                       <span>FORBES LIFE</span>
                                   </div>
                                   <div class="cat-purple"></div>
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
                           <? $mid="MNT08";include('./inc-popular-top.php');	?>      
                      </div>
                   </div>
                   <div class="clearfix"></div>
                   <?	$mid="MNT08"; include('./inc-similar.php');	?>
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