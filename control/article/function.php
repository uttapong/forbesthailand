<?
function my_loadTreeCatSelect($ParentID,$ParentIDVal){
	global $Conn,$SysMenuID;
	$sql_f="cate_id,level,name_th,name_en";
	$sql = "SELECT $sql_f FROM article_category";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " AND menu_id='$SysMenuID'";
	$sql.= " ORDER BY order_by ASC";
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	//$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
			
		$ThisLevel = $Row["level"];
		
		$sql1 = "SELECT count(*) as CNT FROM article_category ";
		$sql1.=" WHERE parent_id ='".$Row["cate_id"]."' ";
		$sql.= " AND menu_id='$SysMenuID'";
		$sql1.=" ORDER BY order_by ASC";
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		 $RecordCount1= $ContentList1[0]["CNT"];
		
		
		$Status = "Enable";
	
		?>
      <option data-level="<?=$Row["level"]?>" <? if($ParentIDVal==$Row["cate_id"]){ ?> selected="selected" <? } ?> value="<?=$Row["cate_id"]?>"> <? for($aa=1;$aa<$ThisLevel;$aa++){?>&nbsp; &nbsp;<? } ?><?=$Row["name_".strtolower($_SESSION["LANG"])];?></option>
        <?
        if($RecordCount1>0){
			my_loadTreeCatSelect($Row["cate_id"],$ParentIDVal); 
		}
	}
}
?>


<?
function my_loadTreeCat($ParentID){
	global $Conn,$SysMenuID;
	
	$sql = "SELECT * FROM article_category";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " AND menu_id='$SysMenuID'";
	$sql.= " ORDER BY order_by ASC";
	
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
			
		$ThisLevel = $Row["level"];
		
		$sql1 = "SELECT count(*) as CNT FROM article_category ";
		$sql1.=" WHERE parent_id ='".$Row["cate_id"]."' ";
		$sql.= " AND menu_id='$SysMenuID'";
		$sql1.=" ORDER BY order_by ASC";
		
		
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		 $RecordCount1= $ContentList1[0]["CNT"];
		
		
		$Status = "Enable";
		$Status =  $Row["status"];
		
		?>
        <div class="parent-<?=$ParentID?>" rel="<?=$Row["cate_id"]?>" >
        	<?
            for($aa=1;$aa<$ThisLevel;$aa++){
			?>
            <div class="box-child ft-left line-vertical" rel="0"></div>
            <?
			}
			?>
            <div class="line-vertical ft-left">
                <div class="<?=$RecordCount1>0?"show-less":"none-child"?>"></div>
            </div>
            <div id="box-cat-inner" class="ft-left pd-l-10 tooltips" rel="<?=$Row["name_".strtolower($_SESSION["LANG"])]?>">
                <div id="box-<?=$Row["cate_id"]?>" class="box-categories box-menu-content <?=$Status=="Disable"?"Disable":"Enable"?>">
                    <div class="ft-left">
                        <div class="txt-head" style="max-width:300px; min-width:200px; white-space:nowrap; overflow:hidden;">
						<?
                        echo $Row["name_".strtolower($_SESSION["LANG"])];
						
						?>
                        </div>
                        
                    </div>
                    <div class="clear"></div>
                </div>
                <span class="labelactionbtn" >
                
                <div class="btn-group" >
                <button id="labelactionbtn-<?=$Row["cate_id"]?>" rel="<?=$ParentID?>" status="<?=$Row["status"]?>" class="btn btn-mini dropdown-toggle" data-toggle="dropdown" data-url-edit="<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$Row["cate_id"])?>">Edit <span class="caret"></span></button>
                <ul class="dropdown-menu"> </ul>
              </div>
                
                
                </span>
                
                
                
            </div>
            <div class="clear"></div>
        </div>
        <?
        if($RecordCount1>0){
			my_loadTreeCat($Row["cate_id"]); 
		}
	}
}
?>