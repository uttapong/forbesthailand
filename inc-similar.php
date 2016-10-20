

	<?
	
	
	$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
	$sql.= " WHERE p.menu_id='".$mid."'  and p.flag_display='Y' and p.id<>'".$did."'";			
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY p.updatedate desc ";
	
	
	$Conn->query($sql,1,6);
	$ContentList = $Conn->getResult();
	$CntRecContentSimilar = $Conn->getRowCount();
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
                 
                    <div <? if($CntRecContentSimilar>1){ ?> id="owl-slide-similar" class="owl-carousel owl-theme similar-list"  <? } ?> >
                      <?
				 
				   	for ($i=0;$i<$CntRecContentSimilar;$i++) {
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
                      <div class="item col-xs-12 col-sm-4 mbc">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span><?=$_title_module?></span>
                              </div>
                              <div class="<?=$_color_module?>"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                  <a href="<?=$_url_module?>?did=<?=$Row["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                  <p class="topic">
                                     <?=$topic?>
                                      </p>
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
                    
					   
                      <?
					  
					  }	
					  
					  ?>
<script>   
    <? 
if($CntRecContentSimilar>1){ ?>	
 var carousel_similar = $('#owl-slide-similar').owlCarousel({
		loop: true,
		margin: 10,
		responsiveClass: true,
		navText: [ '<i></i>', '<i></i>' ],
		responsive: {
		  0: {
			items: 1,
			nav: true,
			  margin: 30
		  },
		  1001: {
			items:3,
			nav: true,	 
			margin: 0
		  }
		}
	  });
<? } ?>   
</script>