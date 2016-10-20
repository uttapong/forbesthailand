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
		var Vars="ModuleAction=getMoreContent&mid=<?=$mid?>&cid=<?=$cid?>&page="+$(this).attr('page');	
		
		$.ajax({
		url : "./list-action.php",
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