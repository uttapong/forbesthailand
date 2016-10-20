<?
	
	
		$sql = "SELECT u.userid,u.firstname_".strtolower($_SESSION['FRONT_LANG'])." as firstname_txt,u.lastname_".strtolower($_SESSION['FRONT_LANG'])." as lastname_txt,u.filepic as filepic_user,u.position_".strtolower($_SESSION['FRONT_LANG'])." as usergroupname   FROM sysuser u";
	$sql.=" left join sysusergroup ug on(ug.usergroupcode=u.usergroupcode) ";
	$sql.= " WHERE 1=1 and u.username<>'admin' ";		
	$sql.= " ORDER BY u.order_by asc ";
	
	
	$Conn->query($sql,1,12);
	$ContentList = $Conn->getResult();
	$CntRecContentList = $Conn->getRowCount();
	if($CntRecContentList){
	
	
	
?>
<div class="col-xs-12">
                        <div class="block-writer">
                            <div class="tab-block-lg">
                                <span>Editorial & Contributor</span>
                            </div>
                            <div class="cat-greendark-lg"></div>
                            <div class="clearfix"></div>
                            <div class="pd-writer">
                            
                            <?
								for ($i=0;$i<$CntRecContentList;$i++) {
									$Row = $ContentList[$i];	
									$physical_user="./uploads/users/".$Row["filepic_user"];
	
									if (!(is_file($physical_user) && file_exists($physical_user) )) {
										$physical_user="./images/photo_not_available.jpg";
									
									}							
							?>
                            
                                <div class="grid-writer">
                                    <div class="list-writer">
                                        <div class="img-writer">
                                            <a href="editorial-detail.php?did=<?=$Row["userid"]?>"><img src="<?=$physical_user?>" class="img-responsive align-center"></a>        
                                        </div>
                                        <div class="txt-writer">
                                            <span class="name"><?=$Row["firstname_txt"]?>  <?=$Row["lastname_txt"]?></span><br>
                                            <span class="position"><?=$Row["usergroupname"]?></span>        
                                        </div> 
                                    </div>                            
                                </div> 
                                
                                <? } ?>                      
                            </div>
                            <div class="clearfix"></div>                            
                            <div class="see-all">
                                <a href="editorial.php">see all <i class="icon-arrow"></i></a>
                            </div>
                        </div>
                    </div>
 <? } ?>