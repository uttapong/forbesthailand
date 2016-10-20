<? require("./lib/system_core.php"); ?>
<?  
$mgroup="TOPLIST_MAIN";  
$did=$_REQUEST["did"];
$sql = "SELECT u.userid,u.firstname_".strtolower($_SESSION['FRONT_LANG'])." as firstname_txt,u.lastname_".strtolower($_SESSION['FRONT_LANG'])." as lastname_txt,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname,u.content_".strtolower($_SESSION['FRONT_LANG'])." as content_html,u.username   FROM sysuser u";
$sql.=" left join sysusergroup ug on(ug.usergroupcode=u.usergroupcode) ";
$sql.= "where  u.userid='".$did."' ";

$Conn->query($sql);
$Content = $Conn->getResult();
$RowHead=$Content[0];


$cid=$RowHead["cate_id"];
$source_navi=getCategoryNavi($cid);
$cate_lel1=$source_navi['cate_lel1'];
$cate_lel2=$source_navi['cate_lel2'];

if($RowHead["menu_id"]==""){
	//header("location:index.php");
}
$url_share=_SYSTEM_HOST_NAME_."/".strtolower($_SESSION['FRONT_LANG'])."/editorial-detail.php?did=".$did;
$dateshow= getDisplayDate($RowHead["updatedate"]);
$content_des=$RowHead["content_".strtolower($_SESSION['FRONT_LANG'])];
$content_des = preg_replace("/<img[^>]+\>/i", " ", $content_des); 
$content_des=strip_tags($content_des);
$content_des = SystemSubString($content_des,200,'');

$username=$RowHead["username"];
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
                                       <span>EDITORIAL & CONTRIBUTOR</span>
                                   </div>
                                   <div class="cat-navy"></div>
                                   <div class="clearfix"></div>
                                   <div class="article-detail"> 
                                   <?	//include('./inc-content-detail.php');	?> 
                                   <?
								    $physical_name="./uploads/users/".$RowHead["filepic_user"];
									if (!(is_file($physical_name) && file_exists($physical_name) )) {
										$physical_name="./images/photo_not_available.jpg";
									
									}	
									?>
																	   
                                 <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
                                     <p class="topic"> 
                                            <?=$RowHead["firstname_txt"]?>  <?=$RowHead["lastname_txt"]?>
                                       
                                            <br><span class="position"> <?=$RowHead["usergroupname"]?> </span>        
                                       
                                       </p>
                                         <?=$RowHead["content_html"]?>
                                   </div>  
                                
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
                   
                   
                   <?
				    	$page=$_REQUEST["p"];

	
	if($page<1) $page=1;
	$pagesize=9;
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.createby='$username'  and p.flag_display='Y'  and  p.flag_approved='Y' ";		
	
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.approveddate desc ";
	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();
	?>
                   
                   
                   <div class="content-list">
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
                      <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span><?=$_title_module?></span>
                              </div>
                              <div class="<?=$_color_module?>"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                              	<? if($mid=="MNT14"){ ?>
                               		<div class="col-xs-12" >
                                          <div class="row vdopic" >
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
                                      <a class="a_pic" href="<?=$_url_module?>?did=<?=$Row["id"]?>">
                                  <img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                    <? } ?>
                                
                                    <p class="topic"> <?=$topic?></p>
                                    <p class="update">Update : <?=$dateshow?></p>
                                    <p class="view">View : <?=number_format($Row["cstate"],0)?></p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="<?=$_url_module?>?did=<?=$Row["id"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
		var Vars="ModuleAction=getMoreContent&username=<?=$username?>&cid=<?=$cid?>&page="+$(this).attr('page');	
		
		$.ajax({
		url : "./editor-action.php",
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
                  <div class="clearfix"></div>
                  
                   <?	include('./inc-other.php');	?> 
                  
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