<?
	$sql = "SELECT p.* FROM article_file p";
	$sql.= " WHERE p.article_id='".$did."'";		
	$sql.= " order by p.order_by ";
	$Conn->query($sql);
	
	
	$SlideList = $Conn->getResult();
	$CntRecSlide = $Conn->getRowCount();
  	if($CntRecSlide>0){
?>

                      <div class="topic-gallery">
                                      <span>Photo Gallery</span>                                 
                                   </div>  
                                   <div class="list-gal">
                                    <?  
 	for ($i=0;$i<$CntRecSlide;$i++) { 
		$Row = $SlideList[$i];
		$physical_name="./uploads/article/".$Row["physical_name"];
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="./images/photo_not_available.jpg";
		}
 ?>
                                     <div class="col-xs-12 col-sm-4 mbc">
                                      <a class="fancybox" rel="galleryset" href="<?=$physical_name?>">
                                        <img src="<?=$physical_name?>" class="img-responsive align-center"/>
                                      </a>
                                     </div>
                                  
                                       <? } ?>  
                                  
                                     <script type="text/javascript">
                                       $(document).ready(function(){
                                        $(".fancybox").fancybox({
                                          openEffect  : 'none',
                                          closeEffect : 'none'
                                        });
                                      });
                                     </script>
                                   </div>    
                                   
                                   
                                       <? } ?>