<? require("./lib/system_core.php"); ?>
<?  
$mgroup="RICH_MAIN";  
$did=$_REQUEST["did"];
$url_share=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/rich-detail.php?did=".$did;
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
                                       <span>LIST’S RICH <?=$source_navi["navi"];?></span>
                                   </div>
                                   <div class="cat-orange"></div>
                                   <div class="clearfix"></div>   
                                   <div class="article-detail"> 
                                   
                                     <? include('./inc-vdo.php');	?> 
                                       <p class="list-number"><?=$RowHead["order_by"]+1?></p>
                                       <p class="topic-rich">
                                         <span><?=$RowHead["name_content"]?> </span><br>
                                         <span><?=$RowHead["value_".strtolower($_SESSION['FRONT_LANG'])]?></span><br>
                                         <span><?=$RowHead["business_".strtolower($_SESSION['FRONT_LANG'])]?></span>
                                       </p><br>
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
                                <div class="box-click">
                                    
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57021aaab4d01ff0"></script>

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
                                   <?	include('./inc-gallery.php');	?>   
                                                             
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-xs-12 col-sm-4">
                      <div class="row">
                           <? include('./inc-banner-right.php');	?>
                           <? 	$mid="MNT01";include('./inc-popular-top.php');	?>      
                      </div>
                   </div>
                   <div class="clearfix"></div>
                 

	<?
	
	$mid="MNT01";
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id='".$mid."'  and p.flag_display='Y' and p.id<>'".$did."' and p.cate_id='".$RowHead["cate_id"]."'";			
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.order_by asc ";
	
	
	$Conn->query($sql,1,3);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	if($TotalRec){                    
	?>
                    <div class="col-xs-12 col-sm-4">
                      <hr class="line-detail">
                    </div>
                    
                    <div class="col-xs-12 col-sm-4">
                      <div class="topic-txt">similar Content</div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <hr class="line-detail">
                    </div>
                    <div class="clearfix"></div>
                    <div class="similar-list">
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
					$topic=SystemSubString($Row["name_content"],60,'');
					
					$_title_module=$_source_title[$Row["menu_id"]];
					$_color_module=$_source_color[$Row["menu_id"]];
					$_url_module=$_source_url[$Row["menu_id"]];	
			?>
                      <div class="col-xs-12 col-sm-4 mbc">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span><?=$_title_module?></span>
                              </div>
                              <div class="<?=$_color_module?>"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                   <a href="<?=$_url_module?>?did=<?=$Row["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                  <p class="list-number-sm"><?=$Row["order_by"]+1?></p>
                                       <p class="topic-rich-sm">
                                         <span><?=$topic?></span><br>
                                         <span><?=$Row["value_".strtolower($_SESSION['FRONT_LANG'])]?></span><br>
                                         <span class="rich_business"><?=$Row["business_".strtolower($_SESSION['FRONT_LANG'])]?></span>
                                       </p>
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
                    
					   
                      <?
					  
					  }	
					  
					  ?>  
                   
                   
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