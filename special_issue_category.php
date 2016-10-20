<? require("./lib/system_core.php"); ?>
<?  
$mgroup="FORBES_THAI_MAIN";  
$cid=$_REQUEST["cid"];
$source_navi=getCategoryNavi($cid);
$cate_lel1=$source_navi['cate_lel1'];
$cate_lel2=$source_navi['cate_lel2'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <?	include('./inc-meta-main.php');	?>
  </head>
  <body>
      <!-- START HEADER -->
       <?	include('./inc-menu.php');	?>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <!-- START CONTENT -->
         <?
		$sql = "SELECT p.filepic FROM bg_main p";
		$sql.= " WHERE p.cate_key='LIFE_TH_".$cate_lel1."' ";;
		$sql.= " and p.flag_display='Y'";
		$sql.= " order by p.order_by asc ";
		
	
		$Conn->query($sql);
		$BGList = $Conn->getResult();
		$CntRecBG = $Conn->getRowCount();
		if($CntRecBG>0){
			$RowBG = $BGList[0];
			$physical_name_bg="./uploads/bg/".$RowBG["filepic"];
		?>
        <style>
		article.bg{
			background:url(<?=$physical_name_bg?>) no-repeat top center ; 
			background-attachment: fixed;
			-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; 
		}
		</style>     
        <? } ?>
   <article class="bg">  
    <?php include("inc-banner-head.php"); ?>
       
       <section class="content">
           <div class="container">
               <div class="row">
                  <div class="col-xs-12 col-sm-8 mbc">
                       <div class="row">
 <?
  	$page=$_REQUEST["p"];

	
	if($page<1) $page=1;
	$pagesize=10;
	$mid="MNT13";
	
	
		$sql = "SELECT p.id,p.filepic,p.cate2_name,p.content_th,p.content_en,p.cate_id,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,p.cstate  FROM (SELECT pp.*,cc.name_".strtolower($_SESSION['FRONT_LANG'])." as cate2_name FROM article_main pp ";
		$sql.=" inner join article_category cc on(cc.cate_id=pp.cate2_id) ";		  
		$sql.=" WHERE pp.menu_id='MNT13'  and pp.flag_display='Y'  and  pp.flag_approved='Y'   ";		
		$sql.=" and  pp.cate1_id='$cate_lel1' ";
		
		$sql.=SystemGetSqlDateShow("pp.dateshow1","pp.dateshow2");	
		
		$sql.="	  ORDER BY pp.approveddate DESC) p ";
		$sql.=" GROUP BY p.cate2_id order by p.approveddate desc ";
	
	
	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();
	
	if($TotalContentRec){
	$physical_name="./uploads/article/".$ContentList[0]["filepic"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}									
	$dateshow= getDisplayDate($ContentList[0]["updatedate"]);
	
	$content_html=$ContentList[0]["content_".strtolower($_SESSION['FRONT_LANG'])];
	$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
	$content_html=strip_tags($content_html);
	$content_html = SystemSubString($content_html,300,'');
	?>
                
                           <div class="col-xs-12">
                               <div class="block">
                                   <div class="tab-block">
                                       <span><?=$ContentList[0]["cate2_name"]?></span>
                                   </div>
                                   <div class="cat-white"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="special_issue-detail.php?did=<?=$ContentList[0]["id"]?>">
                                       <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
                                       </a>
                                       <p class="topic main"> 
                                            <?=$ContentList[0]["name_content"]?>
                                                <span><?=$content_html?> </span>
                                       </p>
                                       <p class="update">Update : <?=$dateshow?></p>
                                       <p class="view">View : <?=number_format($ContentList[0]["cstate"],0)?></p>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="see-all">
                                        <a href="special_issue.php?cid=<?=$ContentList[0]["cate_id"]?>">see all <i class="icon-arrow"></i></a>
                                   </div>
                               </div>
                           </div>
                   
                   <? } // Content 1. ?>
                       </div>
                   </div>
                   <div class="col-xs-12 col-sm-4">
                      <div class="row">
                                 <?	include('./inc-banner-right.php');	?>     
                      </div>
                   </div>
                   <div class="clearfix"></div>
                   
                   
                   
                   <div class="content-list">
                   <?
	
				   
	for ($i=1;$i<$CntRecContentList;$i++) {
		$Row = $ContentList[$i];	
		$physical_name="./uploads/article/".$Row["filepic"];
		$flag_pic=1;
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
			$flag_pic=0;
		}									
		$dateshow= getDisplayDate($Row["updatedate"]);	
		$topic=SystemSubString($Row["name_content"],60,'');
		
		$_title_module=$Row["cate2_name"];
		$_color_module="cat-white-sm";
		$_url_module="special_issue-detail.php";
		$_url_seeall="special_issue.php?cid=".$Row["cate_id"];
		
		
?>
                    <div class="col-xs-12 col-sm-4 mbc">
                        <div class="block">
                            <div class="tab-block-sm">
                                <span><?=$_title_module?></span>
                            </div>
                            <div class="<?=$_color_module?>"></div>
                            <div class="clearfix"></div>
                            <div class="article-sm">
                                <a class="a_pic" href="<?=$_url_module?>?did=<?=$Row["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                <p class="topic">
                                  <?=$topic?>
                                    </p>
                              <p class="update">Update : <?=$dateshow?></p>
                                    <p class="view">View : <?=number_format($Row["cstate"],0)?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="see-all">
                                <a href="<?=$_url_seeall?>">see all <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <? } ?>
                    </div>
                   
                   
                   
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