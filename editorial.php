<? require("./lib/system_core.php"); ?>
<?  $mgroup="HOME_MAIN";  ?>
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
	$type=$_REQUEST["t"];
	
	if($page<1) $page=1;
	$pagesize=10;
	
	
	$sql = "SELECT u.userid,u.firstname_".strtolower($_SESSION['FRONT_LANG'])." as firstname_txt,u.lastname_".strtolower($_SESSION['FRONT_LANG'])." as lastname_txt,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname,u.content_".strtolower($_SESSION['FRONT_LANG'])." as content_html   FROM sysuser u";
$sql.=" left join sysusergroup ug on(ug.usergroupcode=u.usergroupcode) ";
$sql.= " WHERE 1=1 and u.username<>'admin' ";		
	$sql.= " ORDER BY u.order_by asc ";

	
	$Conn->query($sql,$page,$pagesize);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	$TotalContentRec= $Conn->getTotalRow();
	
	if($TotalContentRec){
	$physical_name="./uploads/users/".$ContentList[0]["filepic_user"];
	$flag_pic=1;
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="./images/photo_not_available.jpg";
		$flag_pic=0;
	}									
	$dateshow= getDisplayDate($ContentList[0]["updatedate"]);
	$_url_module="editorial-detail.php";
	
	?>
                
                           <div class="col-xs-12">
                               <div class="block mbc">
                                   <div class="tab-block">
                                       <span>EDITORIAL & CONTRIBUTOR</span>
                                   </div>
                                   <div class="cat-greendark"></div>
                                   <div class="clearfix"></div>    
                                   <div class="article">
                                       <a href="<?=$_url_module?>?did=<?=$ContentList[0]["userid"]?>">
                                       <img src="<?=$physical_name?>" class="img-responsive align-center img-effect">
                                       </a>
                                       <p class="topic main"> 
                                            <?=$ContentList[0]["firstname_txt"]?>  <?=$ContentList[0]["lastname_txt"]?>
                                       
                                            <br><span class="position"> <?=$ContentList[0]["usergroupname"]?> </span>        
                                       
                                       </p>
                                      
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="see-all">
                                        <a href="<?=$_url_module?>?did=<?=$ContentList[0]["userid"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
                  
                  
                  <div class="content-list user">
<?
	for ($i=1;$i<$CntRecContentList;$i++) {
		$Row = $ContentList[$i];	
		$physical_name="./uploads/users/".$Row["filepic_user"];
		$flag_pic=1;
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
			$flag_pic=0;
		}									
		$dateshow= getDisplayDate($Row["updatedate"]);	
		$topic=SystemSubString($Row["name_content"],40,'..');
		
		$_url_module="editorial-detail.php";
?>
                      <div class="col-xs-12 col-sm-4 mbc list-load">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span>EDITORIAL & CONTRIBUTOR</span>
                              </div>
                              <div class="cat-greendark-sm"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                  <a class="a_picuser" href="<?=$_url_module?>?did=<?=$Row["userid"]?>">  
                                  <img src="<?=$physical_name?>" class="img-responsive align-center"> 
                                  </a> 
                                	
                                    <p class="topic"> <?=$Row["firstname_txt"]?>  <?=$Row["lastname_txt"]?></p>
                                    <p class="position"><?=$Row["usergroupname"]?> </p>
                                  
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="<?=$_url_module?>?did=<?=$Row["userid"]?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
		url : "./editorial-action.php",
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