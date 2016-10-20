<? require("./lib/system_core.php"); ?>
<?  
$mgroup="PR_NEWS_MAIN";  
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
   <article>   
    <?php include("inc-banner-head.php"); ?>
       
       <section class="content">
           <div class="container">
               <div class="row">
                  <div class="col-xs-12 col-sm-8 mb">
                       <div class="row">
 <?
  	$page=$_REQUEST["p"];

	
	if($page<1) $page=1;
	$pagesize=10;
	$mid="MNT15";
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id='".$mid."'  and p.flag_display='Y'  and  p.flag_approved='Y'  ";		
	if($cate_lel1>0){
		$sql.= "  and p.cate1_id='$cate_lel1' ";		
	}
	if($cate_lel2>0){
		$sql.= "  and p.cate2_id='$cate_lel2' ";		
	}
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.approveddate desc ";
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
                                       <span>pr news <?=$source_navi['navi']?></span>
                                   </div>
                                   <div class="cat-black"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="pr-detail.php?did=<?=$ContentList[0]["id"]?>">
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
                                        <a href="pr-detail.php?did=<?=$ContentList[0]["id"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
                    <?	include('./inc-list.php');	?>
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