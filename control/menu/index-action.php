<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
	require("function.php");
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>

<?
if ($ModuleAction == "AddForm" || $ModuleAction == "EditForm") {



if($ModuleAction == "AddForm"){
	
	$lbl_tab=_Add_." Menu ";
	$ModuleAction_Current="InsertNewData";
	$v_status=1;
	
	$Row["site_code"]=$_SESSION["SITE_CODE"];
	
	
}else{
	$lbl_tab=_Edit_." Menu ";
	$ModuleAction_Current="UpdateData";
	
	$sql = "select *  from sysmenu where menu_id = '$ModuleDataID'";	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];
	$chk_storecate=strpos("C".$Row["module_code"],"store-menucate");	
	
	if($chk_storecate){
		$module_code="store-cate";
	}else{
		$module_code=$Row["module_code"];
	}
	
}



$SourceModule["group"]="Groups";
//$SourceModule["link"]="Web Link (เชื่อมต่อที่อยู่เว็ปไซต์ต่างๆ)";
//$SourceModule["contactform"]="Contact Form (ติดต่อเรา)";
//$SourceModule["home"]="Home (หน้าหลักของเว็บไซต์)";
//$SourceModule["article"]="Article (บทความ)";
$SourceModule["webpage"]="Web Page Content";


	?>
    <div class="modal-form">
    <form id="frmprompt"  style="margin:0; padding:0;" method="post" class="form-horizontal" onsubmit="return false;"> 
        <input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
        <input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
        <input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
        <input type="hidden" name="SysGroup" id="SysGroup" value="<?=$SysGroup?>" />
        
     
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h3><?=$lbl_tab?></h3>
</div>
<div class="modal-body">
<br />

<div class="control-group" >
    <label class="control-label" for="module_code">Module</label>
    <div class="controls">
    <select name="module_code" id="module_code"  onchange="mod_changeMouduleCode(this.value);">
     <?=SystemArraySelect($SourceModule,$module_code);?>     		          
    </select>
    </div>
</div>


<div id="area_weblink" class="control-group" <? if($Row["module_code"]!="link"){ ?>style="display:none" <? } ?> >
    <label class="control-label" for="weblink">Link </label>
    <div class="controls">
    <input type="text" id="weblink" name="weblink" value="<?=$Row["url"]?>" > 
    </div>
</div>






<div class="control-group">
<label class="control-label" for="category_name">Menu name</label>
<div class="controls">
<input type="text" id="category_name" name="category_name" value="<?=$Row["name"]?>" required>
</div>
</div>



<div class="control-group">
<label class="control-label" for="parent_id">Parent id</label>
<div class="controls">
<!--
<option value="0" data-level="0" >-</option>
-->
<select id="parent_id" name="parent_id" <? if($chk_storecate){?> disabled="disabled"<? } ?> >
<option value="0" data-level="0" >-</option>
<? my_loadTreeCatSelect(0,$Row["parent_id"]); ?>
</select>      
</div>
</div>


<!--
<div class="control-group error">
<label class="control-label" for="general-text">Category name</label>
<div class="controls">
<input type="text" id="general-text" name="general-text">
<span class="help-block">Category name..</span>
</div>
</div>
-->

</div>
<div class="modal-footer">
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
	<a class="btn btn-primary" onclick="submitFormContent();">Save Changes</a>
	<a class="btn" data-dismiss="modal">Close</a>
</div>
</form>
</div>
<? 
}else if ($ModuleAction == "InsertNewData") {
?>
<?
		
		$insert="";
		
		$_menu_id= SystemAutoNumber('menuweb','W',3,'GET');
		
		$insert["menu_id"] 			= "'".$_menu_id."'";
		$insert["site_code"] 			= "'S0001'";
		$insert["name"] 				= "'".trim($_REQUEST['category_name'])."'";
		$insert["parent_id"] 			= "'".trim($_REQUEST['parent_id'])."'";
		$insert["module_code"] 			= "'".trim($_REQUEST['module_code'])."'";
		$insert["menu_group"] 			= "'".trim($_REQUEST['SysGroup'])."'";
		$insert["lang_code"] 			= "'".$_SESSION["LANG"]."'";
		
		$insert["url"] 			= "'".trim($_REQUEST['weblink'])."'";
		
		
		$level=$_REQUEST["level"]+1;
		$insert["level"] 			= "'".trim($level)."'";
		$_order_by=SystemGetMaxOrder("sysmenu","site_code='S0001' and type='web'")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		$sql = "insert into sysmenu(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		
		SystemAutoNumber('menuweb','W',3,'ADD');
		
		if(trim($_REQUEST['module_code'])!="group"){		
			$insert="";
			$insert["usergroupcode"] 		= "'ADMIN'";
			$insert["menuid"] 				= "'".$_menu_id."'";
			$insert["controlaccess"] 		=  "'MANAGE'";	
			$sql = "insert into sysusergroupaccess(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);		
		}
			

?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	
	$update="";
	$update[] = "module_code 	= '".trim($_REQUEST['module_code'])."'";
	$update[] = "name 			= '".trim($_REQUEST['category_name'])."'";
	$update[] = "parent_id 		= '".trim($_REQUEST['parent_id'])."'";
	
	$update[] = "menu_group 	= '".trim($_REQUEST['SysGroup'])."'";
	$update[] = "url 			= '".trim($_REQUEST['weblink'])."'";
	
	
	$level=$_REQUEST["level"]+1;
	$update[] = "level 			= '".$level."'";
	
	$sql = "update  sysmenu set ".implode(",",array_values($update)) ;
	$sql.=" where menu_id = '".$_REQUEST['ModuleDataID']."'";		
	
	$Conn->execute($sql);
	//SystemGetTextToFileTest($sql); //funciton Test data
	
?>
<?

} else if ($ModuleAction == "DeleteData") {
	
	$cate_id= $_REQUEST["id"];
	
	
	$sql = "SELECT c.* FROM sysmenu c";
	$sql.= " WHERE c.parent_id='".$cate_id."'";
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntParent = $Conn->getRowCount();	
	
	if($CntParent>0){	
		echo "Parent";	
	}else{
		$sql = "delete from sysmenu where menu_id = '".$cate_id."'";
		$Conn->execute($sql);
		
	}
	


}else if($ModuleAction=="UpdateSortableCategories"){
	
	
	$DataID=$_REQUEST["DataID"];
	$DataOrder=$_REQUEST["DataOrder"];

	$TmpArrID = explode("-", $DataID);
	$TmpArrOrder= explode("-", $DataOrder);
	$TmpArrOrder = array_filter($TmpArrOrder);
	$TmpArrID = array_filter($TmpArrID);
	asort($TmpArrOrder);
	$TmpArrOrder = array_values($TmpArrOrder);
	$max = count($TmpArrID);

	for($i=0;$i<$max; $i++){
		$update="";
		$update[]="order_by='".$TmpArrOrder[$i]."'";
		$sql="UPDATE sysmenu SET ".implode(",",$update)." WHERE menu_id='".$TmpArrID[$i]."' ";
		$Conn->execute($sql);
		//Sys_QueryExecute($sql);
	}
?>


<?
	
//	sleep(1);
	
}

?>