<?
function my_loadTreeCatSelect($ParentID,$ParentIDVal){
	global $Conn,$SysGroup;
	
	$sql = "SELECT * FROM sysmenu";
	$sql.= " WHERE parent_id='$ParentID' ";
	$sql.= " AND type='web' ";
	$sql.= " and menu_group='$SysGroup'";
	$sql.= " AND lang_code ='".$_SESSION["LANG"]."'";
	$sql.= " ORDER BY order_by ASC";
	
	
	
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
			
		$ThisLevel = $Row["level"];
		
		
		
		$sql1 = "SELECT count(*) as CNT FROM sysmenu ";
		$sql1.=" WHERE parent_id ='".$Row["menu_id"]."' ";
		
		$sql1.=" ORDER BY order_by ASC";
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		 $RecordCount1= $ContentList1[0]["CNT"];
		
		
		$Status = "Enable";
			
		if($_SESSION["Sys_Session_Lang"]=="th"){
			$Status =  $Row["status"];
		}else{
			$Status =  $Row["status"];
		}
		?>
      <option data-level="<?=$Row["level"]?>" <? if($ParentIDVal==$Row["menu_id"]){ ?> selected="selected" <? } ?> value="<?=$Row["menu_id"]?>"> <? for($aa=1;$aa<$ThisLevel;$aa++){?>&nbsp; &nbsp;<? } ?><?=$Row["name"];?></option>
        <?
        if($RecordCount1>0){
			my_loadTreeCatSelect($Row["menu_id"],$ParentIDVal); 
		}
	}
}
?>

<?
function my_loadTreeCat($ParentID,$SysType,$SysGroup){
	global $Conn,$PermissionSource;
	
	$sql = "SELECT * FROM sysmenu ";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " AND type='".$SysType."' ";
	$sql.= " AND menu_group='$SysGroup'";
	$sql.= " AND lang_code ='".$_SESSION["LANG"]."'";
	$sql.= " ORDER BY order_by ASC";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
			
		$ThisLevel = $Row["level"];
		
		$sql1 = "SELECT count(*) as CNT FROM "._SYSTEM_TABLE_MENU_;
		$sql1.=" WHERE parent_id ='".$Row["menu_id"]."' ";
		//$sql1.=" AND "._TABLE_MENU_."_TABID='$CatTabID'";
		#$sql1.= " AND "._TABLE_MENU_."_LANG='".$_SESSION["Sys_Session_Lang"]."'";
		$sql1.=" ORDER BY order_by ASC";
		
		
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		 $RecordCount1= $ContentList1[0]["CNT"];
		
		
		$Status = "Enable";
		
		
		
		if($_SESSION["Sys_Session_Lang"]=="th"){
			$Status =  $Row["status"];
		}else{
			$Status =  $Row["status"];
		}
		
		$_permission="HIDE";
		if (array_key_exists($Row["menu_id"], $PermissionSource)) {
			$_permission= $PermissionSource[$Row["menu_id"]];
		}
		
		?>
        <div class="parent-<?=$ParentID?> row" rel="<?=$Row["menu_id"]?>" >
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
            <div id="box-cat-inner"  class="ft-left pd-l-10 tooltips" rel="<?=$Row["name"]?>">
                <div id="box-<?=$Row["menu_id"]?>" class="box-categories box-menu-content <?=$Status=="Disable"?"Disable":"Enable"?>">
                    <div class="ft-left">
                        <div class="txt-head" style="max-width:300px; white-space:nowrap; overflow:hidden;">
						<?
                        if($_SESSION["Sys_Session_Lang"]=="th"){
							echo $Row["name"];
						}else{
							echo $Row["name"];
						}
						?>
                        </div>
                        
                    </div>
                    <div class="clear"></div>
                </div>
             
            </div>
               <span class="box-action" >
                <? if($ThisLevel>0 && $Row["module_code"]!="group"){ ?>
               <label class="box-hide checkbox"><input type="radio" class="permiss_hide" name="inputPermiss[<?=$Row["menu_id"]?>]" id="inputPermissH<?=$Row["menu_id"]?>" value="HIDE" <? if($_permission=="HIDE"){?> checked <? } ?> > Hide </label>
               <label class="box-hide checkbox"><input type="radio" class="permiss_view" name="inputPermiss[<?=$Row["menu_id"]?>]" id="inputPermissH<?=$Row["menu_id"]?>" value="VIEW" <? if($_permission=="VIEW"){?> checked <? } ?> > View </label>
                 <label class="box-hide checkbox"><input type="radio" class="permiss_manage" name="inputPermiss[<?=$Row["menu_id"]?>]" id="inputPermissH<?=$Row["menu_id"]?>" value="MANAGE" <? if($_permission=="MANAGE"){?> checked <? } ?>> Manage </label>
              <? } ?> 
                </span>  
            
            <div class="clear"></div>
        </div>
        <?
        if($RecordCount1>0){
			my_loadTreeCat($Row["menu_id"],$SysType,$SysGroup); 
		}
	}
}
?>