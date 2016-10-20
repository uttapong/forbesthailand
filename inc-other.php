	<?
if(1){
	$sql = "SELECT p.id,p.filepic,p.menu_id,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM  hilight_main h";
	$sql.=" inner join article_main p on(p.id=h.content_id) ";
	$sql.= " WHERE  p.flag_display='Y' ";			
	$sql.=SystemGetSqlDateShow("p.dateshow1","p.dateshow2"); 
	$sql.= " ORDER BY h.order_by asc ";
	$Conn->query($sql,1,6);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	
	
	
	if($CntRecContentList<3){
		$c=6-$CntRecContentList;
		
	$sql = "SELECT p.id,p.filepic,p.menu_id,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content  FROM (SELECT * FROM article_main WHERE menu_id<>'MNT01' and flag_display='Y' ".SystemGetSqlDateShow("dateshow1","dateshow2")." ORDER BY updatedate DESC) p GROUP BY p.menu_id ";
		$Conn->query($sql,1,$c);
		$OtherList = $Conn->getResult();
		$CntRecOtherList = $Conn->getRowCount();
		$ContentList=array_merge($ContentList,$OtherList);
	}
	if($CntRecContentList){                    
	?>
                    
                    <div class="col-xs-12 col-sm-4">
                      <hr class="line-detail">
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <div class="topic-txt">Other Category</div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                      <hr class="line-detail">
                    </div>
                    <div class="clearfix"></div>
                    
                    <?
					$CntRecOtherTotal=$CntRecContentList+$CntRecOtherList;
					?>
                    
                   <div <? if($CntRecOtherTotal>1){ ?> id="owl-slide-other" class="owl-carousel owl-theme similar-list"  <? } ?> >
                 
                      <?
				   	for ($i=0;$i<($CntRecOtherTotal);$i++) {
					$Row = $ContentList[$i];
					
					$_title_similar=$_source_title[$Row["menu_id"]];
					$_color_similar=$_source_color[$Row["menu_id"]];
					$_url_similar=$_source_url[$Row["menu_id"]];
					$_url_seeall=$_source_seeall[$Row["menu_id"]];	
					
					$physical_name="./uploads/article/".$Row["filepic"];
					$flag_pic=1;
					if (!(is_file($physical_name) && file_exists($physical_name) )) {
						$physical_name="./images/photo_not_available.jpg";
						$flag_pic=0;
					}									
					$dateshow= getDisplayDate($Row["updatedate"]);	
					$topic=SystemSubString($Row["name_content"],60,'');
			?>
                      <div class="item col-xs-12 col-sm-4 mbc">
                        <div class="block">
                              <div class="tab-block-sm">
                                  <span><?=$_title_similar?></span>
                              </div>
                              <div class="<?=$_color_similar?>"></div>
                              <div class="clearfix"></div>
                              <div class="article-sm">
                                  <a href="<?=$_url_similar?>?did=<?=$Row["id"]?>"><img src="<?=$physical_name?>" class="img-responsive align-center"></a>
                                  <p class="topic">
                                     <?=$topic?>
                                      </p>
                                      <p class="update">Update : <?=$dateshow?></p>
                                      <p class="view">View : <?=number_format($Row["cstate"],0)?></p>
                              </div>
                              <div class="clearfix"></div>
                              <div class="see-all">
                                  <a href="<?=$_url_seeall?>"><?=_Detail_More_?> <i class="icon-arrow"></i></a>
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
if($CntRecOtherTotal>1){ ?>	
 var carousel_other = $('#owl-slide-other').owlCarousel({
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

<? } ?>