<? require("./lib/system_core.php"); ?>
<?  $mgroup="COVER_MAIN";  
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
		$sql.= " WHERE p.cate_key='COVER' ";;
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
                  <div class="col-xs-12 col-sm-8 mb">
                       <div class="row">
 <?
  $page=$_REQUEST["p"];
	if($page<1) $page=1;
	$pagesize=10;
	$mid="MNT02";
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM cover_main p";
	$sql.= " left join cover_category c on(c.cate_id=p.cate_id) ";
	$sql.= " WHERE 1=1 and p.flag_display='Y' and  p.flag_approved='Y' ";	
	if($cate_lel1>0){
		$sql.= "  and p.cate_id='$cid' ";		
	}
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	//$sql.= " ORDER BY p.approveddate desc ";
	$sql.= " ORDER BY  c.order_by desc, p.createdate desc ";
	
	//echo $sql;

	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();
	
	if($TotalContentRec){
	$physical_name="./uploads/cover/".$ContentList[0]["filepic"];
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
                               <div class="block mbc">
                                   <div class="tab-block">
                                       <span>cover</span>
                                   </div>
                                   <div class="cat-red"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="cover_inside.php?did=<?=$ContentList[0]["id"]?>">
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
                                        <a href="cover_inside.php?did=<?=$ContentList[0]["id"]?>">see all <i class="icon-arrow"></i></a>
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
		$physical_name="./uploads/cover/".$Row["filepic"];
		$flag_pic=1;
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
			$flag_pic=0;
		}									
		$dateshow= getDisplayDate($Row["updatedate"]);	
		$topic=SystemSubString($Row["name_content"],60,'');
		$Row["menu_id"]="MNT02";
		$_title_module=$_source_title[$Row["menu_id"]];
		$_color_module=$_source_color[$Row["menu_id"]];
		$_url_module="cover_inside.php";
?>
                      <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span><?=$_title_module?></span>
                              </div>
                              <div class="<?=$_color_module?>"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                              	<? if($mid=="MNT14"){ ?>
                               		<div class="col-xs-12">
                                          <div class="row">
                                              <figure class="play-link">
                                                  <img src="<?=$physical_name?>" class="img-responsive align-center">
                                                  <a href="<?=$_url_module?>?did=<?=$Row["id"]?>">
                                                    <figcaption><i class="icon-vdo"></i></figcaption>
                                                  </a>
                                              </figure>
                                          </div>
                                      </div>
                                      <div class="clearfix"></div>
                              		<? }else{ ?>
                                      <a class="a_piccover" href="<?=$_url_module?>?did=<?=$Row["id"]?>">
                                  <img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                    <? } ?>
                                
                                    <p class="topic"> <?=$topic?></p>
                                    <p class="update">Update : <?=$dateshow?></p>
                                    <p class="view">View : <?=number_format($Row["cstate"],0)?></p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="<?=$_url_module?>?did=<?=$Row["id"]?>">see all <i class="icon-arrow"></i></a>
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
		url : "./cover-action.php",
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
			 $(".list-load:hidden").slice(0, 9).slideDown();
			if ($(".list-load:hidden").length == 0) {
				$("#load").fadeOut('slow');
			}	
		}
		});			
	});
});
</script>
                   
                   
                   
                   
                   
                   
                   
                   
                   
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