<? require("./lib/system_core.php"); ?>
<?  
$mgroup="RICH_MAIN";  
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
	$mid="MNT01";
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id='".$mid."'  and p.flag_display='Y'  and  p.flag_approved='Y' ";		
	if($cate_lel1>0){
		$sql.= "  and p.cate1_id='$cate_lel1' ";		
	}
	if($cate_lel2>0){
		$sql.= "  and p.cate2_id='$cate_lel2' ";		
	}
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.approveddate asc ";

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
	
	?>
                
                           <div class="col-xs-12">
                               <div class="block mbc">
                                   <div class="tab-block">
                                       <span>List’s Rich <?=$source_navi['navi']?></span>
                                   </div>
                                   <div class="cat-orange"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="rich-detail.php?did=<?=$ContentList[0]["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center img-effect"></a>
                                       <p class="list-number">1</p>
                                       <p class="topic-rich">
                                         <span><?=$ContentList[0]["name_content"]?> </span><br>
                                         <span><?=$ContentList[0]["value_".strtolower($_SESSION['FRONT_LANG'])]?></span><br>
                                         <span><?=$ContentList[0]["business_".strtolower($_SESSION['FRONT_LANG'])]?></span>
                                       </p><br>
                               			<p class="update">Update : <?=$dateshow?></p>
                                       <p class="view">View : <?=number_format($ContentList[0]["cstate"],0)?></p>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="see-all">
                                        <a href="rich-detail.php?did=<?=$ContentList[0]["id"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
		
		$_title_module=$_source_title[$Row["menu_id"]];
		$_color_module=$_source_color[$Row["menu_id"]];
		$_url_module=$_source_url[$Row["menu_id"]];	
?>
                   
                      <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>List’s Rich GLOBAL</span>
                              </div>
                              <div class="cat-orange-sm"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                  <a href="rich-detail.php?did=<?=$Row["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                  <p class="list-number-sm"><?=$Row["order_by"]+1?></p>
                                       <p class="topic-rich-sm">
                                         <span><?=$Row["name_content"]?></span><br>
                                         <span><?=$Row["value_".strtolower($_SESSION['FRONT_LANG'])]?></span><br>
                                         <span class="rich_business"><?=SystemSubString($Row["business_".strtolower($_SESSION['FRONT_LANG'])],30,'..')?></span>
                                       </p>
                                    <p class="update">Update : <?=$dateshow?></p>
                                    <p class="view">View : <?=number_format($Row["cstate"],0)?></p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="rich-detail.php?did=<?=$Row["id"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
                              </div>
                          </div>
                      </div>
                      <? } ?>      
               </div>
                   <div class="clearfix"></div>   
                      <? if($TotalContentRec>$pagesize){ ?>                      
                    <div class="col-xs-12 col-sm-4 hide-xs">
                      <hr class="line-load">
                    </div>
                    <div class="col-xs-12 col-sm-4 mbc">
                 
                      <div class="load-more">
                        <a href="javascript:void(0)" id="loadMore"  page="<?=$page?>"  >Load More</a>
                      </div>
                 
                    </div>
                    <div class="col-xs-12 col-sm-4 hide-xs">
                      <hr class="line-load">
                    </div>
                    <? } ?>
<script type="text/javascript">
  $(function () {			  
	$(".list-load").slice(0, 9).show();
	$("#loadMore").on('click', function (e) {
		e.preventDefault();	
		var Vars="ModuleAction=getMoreContent&mid=<?=$mid?>&cid=<?=$cid?>&page="+$(this).attr('page');	
		
		$.ajax({
		url : "./rich-action.php",
		data : Vars,
		type : "post",
		dataType: 'json',
		cache : false ,
		success : function(resp){
			$(".content-list").append(resp.html);
			if(resp.end==true){
				$( ".load-more" ).parent().append('<hr class="line-load">'); 
				$(".load-more").hide(); 
			}else{
				$("#loadMore").attr('page',resp.page);	
			}
			 $(".list-load:hidden").slice(0, 3).slideDown();
			if ($(".list-load:hidden").length == 0) {
				$("#load").fadeOut('slow');
			}	
		}
		});			
	});
});
</script>
                   </div>
                    <?	//include('./inc-list.php');	?>
                    <?	include('./inc-contributor.php');	?>
               </div>
           </div>
       </section>
        <section class="ads">
           <div class="container-fluid">
            <div class="row">
                <img src="images/main/ads_bot.png" class="img-responsive align-center">
            </div>
           </div>
       </section>
   </article>
   <div class="clearfix"></div>
        <!-- END  CONTENT -->
   <? include('./inc-footer.php');?>
  </body>
</html>