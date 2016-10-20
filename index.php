<? require("./lib/system_core.php"); ?>
<?  $mgroup="HOME_MAIN";  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <?	include('./inc-meta-main.php');	?>
      
<!-- POPUP 14102559 --------------------- -->
	<style type="text/css">
        div.cover-page{
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            background-color:rgba(0, 0, 0, 0.9);
            z-index:900000;
            display:block;
        }
        div.cover-area{
          position:relative;
		  width:100%;
		  height:auto;
          max-width:800px;
          max-height: 500px;
          background-color:#fff;
          margin-top: 80px;
        }
        div.cover-close{
          position:absolute;
          top:-30px;
          right:-10px;
          font-size:2em;
          color:#fff;
          cursor: pointer;
        }
        @media screen and (max-device-width: 667px) {
          div.cover-close{
            font-size: 1.5em;
            top:0px;
            right:30px;
          }
        div.cover-area{
          margin-top: 20px;
        }
        }
    </style>
<!-- POPUP 14102559 --------------------- -->
      
     <script src="js/jquery.cookie.js"></script>
  </head>
  <body>
  
<!-- POPUP 14102559 --------------------- -->
<div class="cover-page">
	<center>
		<div class="cover-area" style="background-color:#000; text-align:center;">
        <center><div class="cover-close" onclick="close_cover()">X</div></center>
        	<img src="http://www.forbesthailand.com/images/cover.jpg" style="width:100%; max-width:800px;">
    	</div>
	</center>
</div>
<script language="javascript">

	$("div.cover-close").click(function() {
	       $('div.cover-page').css('display','none');
	       // $("div.cover-area video")[0].pause()
	       $('div.cover-area video').get(0).pause()
	});
</script>  
<!-- POPUP 14102559 --------------------- -->
  
  
  
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
		$pagesize=20;
		
		$sql_f="p.id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate";
		
		$sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content  FROM (SELECT * FROM cover_main WHERE  flag_display='Y' ".SystemGetSqlDateShow("dateshow1","dateshow2")." ORDER BY approveddate DESC) p  order by p.approveddate desc ";
		
		$Conn->query($sql,1,1);
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
	
	
		$ContentList[0]["menu_id"]="MNT02";
		$_title_module=$_source_title[$ContentList[0]["menu_id"]];
		$_color_module=str_replace('-sm','',$_source_color[$ContentList[0]["menu_id"]]);
		$_url_module=$_source_url[$ContentList[0]["menu_id"]];
		$_url_seeall=$_source_seeall[$ContentList[0]["menu_id"]];
		
		$content_html=$ContentList[0]["content_".strtolower($_SESSION['FRONT_LANG'])];
		$content_html = preg_replace("/<img[^>]+\>/i", " ", $content_html); 
		$content_html=strip_tags($content_html);
		$content_html = SystemSubString($content_html,300,'');
		
	?>
                           <div class="col-xs-12">
                               <div class="block mbc">
                                   <div class="tab-block">
                                       <span><?=$_title_module?> </span>
                                   </div>
                                   <div class="<?=$_color_module?>"></div>
                                   <div class="clearfix"></div>
                                   <div class="article">
                                       <a href="<?=$_url_module?>?did=<?=$ContentList[0]["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center img-effect"></a>
                                       <p class="topic main">
                                           <?=$ContentList[0]["name_content"]?>
                                             <span><?=$content_html?> </span>
                                       </p>
                                       <p class="update">Update : <?=$dateshow?></p>
                                       <p class="view">View : <?=number_format($ContentList[0]["cstate"],0)?></p>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="see-all">
                                        <a href="<?=$_url_seeall?>">see all <i class="icon-arrow"></i></a>
                                   </div>
                               </div>
                           </div>
                           <? } ?>
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
	$sql_f="p.id,p.menu_id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate";	
	$sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content  FROM (SELECT * FROM article_main WHERE menu_id<>'MNT01' and menu_id<>'MNT02'  and flag_display='Y' ".SystemGetSqlDateShow("dateshow1","dateshow2")." ORDER BY approveddate DESC) p GROUP BY p.menu_id order by p.approveddate desc ";
	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();			   
				   
	for ($i=0;$i<$CntRecContentList;$i++) {
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
		$_url_seeall=$_source_seeall[$Row["menu_id"]];	
		
		
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
                    
        <div class="clearfix"></div>  
        
		<?
         	$sql_f="p.id,p.menu_id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate,p.order_by";	
			
			$sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
			$sql.= " WHERE p.menu_id='MNT01'  and p.flag_display='Y' and  p.flag_approved='Y' ";
			$sql.= " and p.cate_id='2'  ".SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.order_by asc ";
		
            $Conn->query($sql,1,5);
            $ContentList = $Conn->getResult();
            $CntRecContentList = $Conn->getRowCount();
            $TotalContentRec= $Conn->getTotalRow();			   
                           
            if($TotalContentRec){
        ?>
                    <div class="col-xs-12 col-sm-4 mbc">
                        <div class="block">
                            <div class="tab-block-sm">
                                <span>List’s rich</span>
                            </div>
                            <div class="cat-orange-sm"></div>
                            <div class="clearfix"></div>
                            
                            <?
							for ($i=0;$i<$CntRecContentList;$i++) {
								$Row = $ContentList[$i];	
								
								$physical_name="./uploads/article/".$Row["filepic"];
								$flag_pic=1;
								if (!(is_file($physical_name) && file_exists($physical_name) )) {
									$physical_name="./images/photo_not_available.jpg";
									$flag_pic=0;
								}									
								$dateshow= getDisplayDate($Row["updatedate"]);	
								$topic=SystemSubString($Row["name_content"],80,'');
								
							?>
                            <div class="list-rank">
                                <div class="sorts">
                                    <span><?=$Row["order_by"]+1?></span>                
                                </div>
                                <div class="img-list rich">
                                    <img src="<?=$physical_name?>" class="img-responsive align-center">           
                                </div>
                                <div class="txt-list">
                                    <p><?=$Row["name_content"]?> (<?=$Row["value_".strtolower($_SESSION['FRONT_LANG'])]?>) <?=SystemSubString($Row["business_".strtolower($_SESSION['FRONT_LANG'])],30,'..')?></p>
                                    <span class="update">Update : <?=$dateshow?></span>        
                                </div>                    
                            </div>
                            <? } ?>
                             
                             
                            <div class="clearfix"></div>
                            <div class="see-all">
                                <a href="list-rich.php?cid=2">see all <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <? } ?>
                    
          <?
		 	$sql_f="p.id,p.menu_id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate";	
			$sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
			$sql.= " WHERE p.menu_id<>'MNT01'  and p.flag_display='Y' and  p.flag_approved='Y' ";
			$sql.= " ".SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.cstate desc ";
		
            $Conn->query($sql,1,5);
            $ContentList = $Conn->getResult();
            $CntRecContentList = $Conn->getRowCount();
            $TotalContentRec= $Conn->getTotalRow();			                      
            if($TotalContentRec){
        ?>
                    <div class="col-xs-12 col-sm-4 mbc">
                        <div class="block">
                            <div class="tab-block-sm">
                                <span>Most Popular</span>
                            </div>
                            <div class="cat-greenlight-sm"></div>
                            <div class="clearfix"></div>
                             <?
							for ($i=0;$i<$CntRecContentList;$i++) {
								$Row = $ContentList[$i];		
								$dateshow= getDisplayDate($Row["updatedate"]);	
								$topic=SystemSubString($Row["name_content"],40,'');
								
								
								$_url_module=$_source_url[$Row["menu_id"]];
							?>
                            <div class="list-rank">
                            <a href="<?=$_url_module?>?did=<?=$Row["id"]?>">
                                <div class="most">
                                    <span><?=($i+1)?></span>                
                                </div>
                                <div class="txt-most">
                                    <p><?=$topic?></p>
                                    <p class="update fs">Update : <?=$dateshow?></p>
                                    <p class="view fs">view : <?=number_format($Row["cstate"],0)?></p>        
                                </div>
                                </a>                    
                            </div>
                            <? } ?>          
                            
                            <div class="clearfix"></div>
                            <div class="see-more">
                                <a href="mostpopular.php?t=thismounth">see this month <i class="icon-arrow"></i></a>
                            </div>
                            <div class="see-more">
                                <a href="mostpopular.php">see all <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                       <? } ?>
					  <?
					  	$sql_f="p.id,p.menu_id,p.filepic,p.content_th,p.content_en,p.updatedate,p.cstate";	
                        $sql = "SELECT $sql_f,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
                        $sql.= " WHERE p.menu_id='MNT16'  and p.flag_display='Y' and  p.flag_approved='Y' ";
                        $sql.= " ".SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.approveddate desc ";
                    
                        $Conn->query($sql,1,5);
                        $ContentList = $Conn->getResult();
                        $CntRecContentList = $Conn->getRowCount();
                        $TotalContentRec= $Conn->getTotalRow();			                      
                        if($TotalContentRec){
                    ?>   
                    <div class="col-xs-12 col-sm-4 mbc">
                        <div class="block">
                            <div class="tab-block-sm">
                                <span>top list</span>
                            </div>
                            <div class="cat-navy-sm"></div>
                            <div class="clearfix"></div>
                               <?
							for ($i=0;$i<$CntRecContentList;$i++) {
								$Row = $ContentList[$i];		
								$dateshow= getDisplayDate($Row["updatedate"]);	
								$topic=SystemSubString($Row["name_content"],50,'..');
								
							?>
                            <div class="list-rank">
                                <div class="txt-top">
                                    <p><?=$topic?></p>
                                    <p class="update fs">Update :  <?=$dateshow?></p>
                                    <p class="view fs">view : <?=number_format($Row["cstate"],0)?></p>        
                                </div>                    
                            </div>
                            <? } ?>
                          
                         
                            <div class="clearfix"></div>                            
                            <div class="see-all">
                                <a href="toplist.php">see all <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                    <? } ?>
                      <?	include('./inc-contributor.php');	?>
               </div>
           </div>
       </section>
         <?	include('./inc-banner-footer.php');	?>
   </article>
   <div class="clearfix"></div>
        <!-- END  CONTENT -->
        
        <?
$ads_mid="SADST04";	

$sql = "SELECT p.id FROM ads_main p ";
$sql.= " WHERE p.menu_id='".$ads_mid."'";
$sql.= " and p.flag_display='Y'";
$sql.= " order by p.order_by asc ";
$Conn->query($sql);
$AdsPList = $Conn->getResult();
$CntRecAdsP = $Conn->getRowCount();

if($CntRecAdsP){
?>

	<a id="hidden_link" style="display:none;" class="fancybox" data-fancybox-type="ajax" href="index-action.php?ModuleAction=showContent&did=<?=$AdsPList[0]["id"]?>">&nbsp;</a>
<? } ?>
        <style>
		.fancybox-skin{
	background:transparent!important;
}
</style>
        
  <? include('./inc-footer.php');?>
  <? if($CntRecAdsP){ ?>
  <script>
  $(document).ready(function(){							
	if($.cookie('FLAG_ADS')!='NO'){			
		$("#hidden_link").fancybox({
			 padding: 0,
			wrapCSS : 'fancybox-custom',
			openEffect	: 'none',
			closeEffect	: 'none',
			closeBtn : true,
			scrolling   : 'no',
			minHeight   : 740,
			autoSize:true,
		}).trigger('click');
	}
});
  </script>
  <? } ?>
  </body>
</html>