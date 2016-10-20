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
	$lbl_tab=_Add_." ".$_sourceMaster["name"];
	$ModuleAction_Current="InsertNewData";
	$v_status=1;
	
	$Row["site_code"]=$_SESSION["SITE_CODE"];
	
}else{
	$lbl_tab=_Edit_." ".$_sourceMaster["name"];;
	$ModuleAction_Current="UpdateData";
	
	$sql = "select *  from article_category where cate_id = '$ModuleDataID'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];
	
}

	
	?>
    <div class="modal-form">
    <form id="frmprompt"  style="margin:0; padding:0;" method="post" class="form-horizontal" onsubmit="return false;"> 
        <input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
        <input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
        <input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
     
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h3>Add New Category</h3>
</div>
<div class="modal-body">
<br />


<div class="control-group">
<label class="control-label" for="category_name">Category name</label>
<div class="controls">
<input type="text" id="category_name" name="category_name" class="request" value="<?=$Row["name"]?>" required>
<span class="help-block">Category name..</span>
</div>
</div>

<div class="control-group">
<label class="control-label" for="parent_id">Parent id</label>
<div class="controls">
<select id="parent_id" name="parent_id"  >
<option value="0" data-level="0" >-</option>
<? my_loadTreeCatSelect(0,$Row["parent_id"]); ?>
</select>      


<span class="help-block">Category name..</span>
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
	<a class="btn btn-success" onclick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></a>
	<a class="btn" data-dismiss="modal">Close</a>
</div>
</form>
</div>
<? 
}else if ($ModuleAction == "InsertNewData") {
?>
<?
		
		$insert="";
		$insert["site_code"] 			= "'S0001'";
		$insert["menu_id"] 				= "'".trim($_REQUEST['SysMenuID'])."'";
		$insert["name"] 				= "'".trim($_REQUEST['category_name'])."'";
		$insert["parent_id"] 			= "'".trim($_REQUEST['parent_id'])."'";
		$level=$_REQUEST["level"]+1;
		$insert["level"] 			= "'".trim($level)."'";
		
		$_order_by=SystemGetMaxOrder("article_category","site_code='S0001'")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		$sql = "insert into article_category(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
			

?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	
	$update="";
	$update[] = "name 		= '".trim($_REQUEST['category_name'])."'";
	$update[] = "parent_id 		= '".trim($_REQUEST['parent_id'])."'";
	$level=$_REQUEST["level"]+1;
	$update[] = "level 		= '".$level."'";
	
	$sql = "update  article_category set ".implode(",",array_values($update)) ;
	$sql.=" where cate_id = '".$_REQUEST['ModuleDataID']."'";		
	
	$Conn->execute($sql);
	//SystemGetTextToFileTest($sql); //funciton Test data
	
?>
<?

	} else if ($ModuleAction == "DeleteData") {
	/*
		$sql = "delete from "._TABLE_CUS_." where "._TABLE_CUS_."_ID = ".$_REQUEST['inputDataID'];
		$Conn->execute($sql);
	*/

?>


<?

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
		$sql="UPDATE article_category SET ".implode(",",$update)." WHERE cate_id='".$TmpArrID[$i]."' ";
		$Conn->execute($sql);
		//Sys_QueryExecute($sql);
	}
?>

<?
	
//	sleep(1);
	
}

?>