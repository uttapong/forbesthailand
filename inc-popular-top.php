   <?
			$sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
			$sql.= " WHERE p.flag_display='Y' ";
			if($mid!=""){
				$sql.=" and p.menu_id='".$mid."'";
			}
			$sql.= " ".SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.cstate desc ";
			
            $Conn->query($sql,1,3);
            $ContentList = $Conn->getResult();
            $CntRecContentList = $Conn->getRowCount();
            $TotalContentRec= $Conn->getTotalRow();			                      
            if($TotalContentRec){
        ?>
<div class="col-xs-12 mbc">
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
								
							?>
                                  <div class="list-rank">
                                      <div class="most">
                                          <span><?=($i+1)?></span>                
                                      </div>
                                      <div class="txt-most">
                                          <p><?=$topic?></p>
                                          <p class="update fs">Update : <?=$dateshow?></p>
                                    <p class="view fs">view : <?=number_format($Row["cstate"],0)?></p>        
                                      </div>                    
                                  </div>
                                  <? } ?> 
                                  <div class="clearfix"></div>
                                  <div class="see-more">
                                      <a href="mostpopular.php?t=thismounth&mid=<?=$mid?>">see this month <i class="icon-arrow"></i></a>
                                  </div>
                                  <div class="see-more">
                                      <a href="mostpopular.php?mid=<?=$mid?>">see all <i class="icon-arrow"></i></a>
                                  </div>
                              </div>
                          </div>
            <? } ?>
            
                   <?
                        $sql = "SELECT p.*,p.name_".strtolower($_SESSION['FRONT_LANG'])." as name_content FROM article_main p";
                        $sql.= " WHERE p.menu_id='MNT16'  and p.flag_display='Y' ";
                        $sql.= " ".SystemGetSqlDateShow("p.dateshow1","p.dateshow2")."  order by p.updatedate desc ";
                    
                        $Conn->query($sql,1,3);
                        $ContentList = $Conn->getResult();
                        $CntRecContentList = $Conn->getRowCount();
                        $TotalContentRec= $Conn->getTotalRow();			                      
                        if($TotalContentRec){
                    ?>             
                          <div class="col-xs-12 mbc">
                        <div class="block">
                            <div class="tab-block-sm">
                                <span>top list</span>
                            </div>
                            <div class="cat-blue-sm"></div>
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
                                    <p class="update fs">Update : <?=$dateshow?></p>
                                    <p class="view fs">view :  <?=number_format($Row["cstate"],0)?></p>        
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