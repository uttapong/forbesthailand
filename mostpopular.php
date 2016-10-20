<? require("./lib/system_core.php"); ?>
<?  $mgroup="MOST_POPULAR_MAIN";  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=_SYSTEM_WEB_TITLE_?></title>
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Kanit:200,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
	$type=$_REQUEST["t"];
	
	if($page<1) $page=1;
	$pagesize=10;

	if($type=="thismounth"){
		$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,s.num as statshow FROM article_main p";
		$sql.=" inner join article_statmonth s on(s.article_id=p.id) ";
		$sql.= " WHERE p.menu_id<>'MNT01'  and p.flag_display='Y' ";
		$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.cstate desc ";	
	}else{
		$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content,p.cstate as statshow FROM article_main p";
		$sql.= " WHERE p.menu_id<>'MNT01'  and p.flag_display='Y' and p.cstate>0 ";
		$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.cstate desc ";	
	}
	
	
	

	
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
	$_url_module=$_source_url[$ContentList[0]["menu_id"]];	
	
	?>
                
                           <div class="col-xs-12">
                               <div class="block">
                                   <div class="tab-block">
                                       <span>MOST POPULAR <? if($type=="thismounth"){ ?> THIS MONTH <? } ?></span>
                                   </div>
                                   <div class="cat-greenlight"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="<?=$_url_module?>?did=<?=$ContentList[0]["id"]?>">
                                       <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
                                       </a>
                                       <p class="topic"> 
                                            <?=$ContentList[0]["name_content"]?>
                                       </p>
                                       <p class="update">Update : <?=$dateshow?></p>
                                       <p class="view">View : <?=number_format($ContentList[0]["statshow"],0)?></p>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="see-all">
                                        <a href="<?=$_url_module?>?did=<?=$ContentList[0]["id"]?>">see all <i class="icon-arrow"></i></a>
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
		$topic=SystemSubString($Row["name_content"],40,'..');
		
		$_title_module=$_source_title[$Row["menu_id"]];
		$_color_module=$_source_color[$Row["menu_id"]];
		$_url_module=$_source_url[$Row["menu_id"]];	
?>
                      <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>MOST POPULAR</span>
                              </div>
                              <div class="cat-greenlight-sm"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                  <a class="a_pic" href="<?=$_url_module?>?did=<?=$Row["id"]?>">  
                                  <img src="<?=$physical_name?>" class="img-responsive align-center"> 
                                  </a> 
                                	<div class="most">
                                    <span><?=$i+1?></span>                
                                	</div>
                                    <div class="most-topic">
                                    <p class="topic"> 
                               		 <?=$topic?>
                                    </p>
                                    </div>
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
		url : "./most-action.php",
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