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
if ($ModuleAction == "Datalist") {
	if(!$Page){
		$Page=$_REQUEST["SysPage"];
	}
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["SysTextSearch"]);
	$SysCateID=$_REQUEST["SysCateID"];
	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.order_by";
	if ($SysSort=="") $SysSort="asc";
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.* FROM sysusergroup p";
//	$sql.=" left join sysusercate c on(c.usercatecode=p.usercatecode) ";
	$sql.= " WHERE 1=1 ";
	

	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	if (trim($SysCateID)>0){
		$sql.=" AND (p.cate_id  = '".$SysCateID."' ";
		$sql.=")";
	}
	
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	
	
?>	



<form name="mySearch" id="mySearch" action="./group.php" method="post">
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden"  name="SysModURL" id="SysModURL" value="group-action.php"/>
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemGetReturnURL()?>"/>
<input type="hidden" name="SysPage"  id="SysPage" value="<?=$Page?>">
<input type="hidden" name="SysPageSize"  id="SysPageSize" value="<?=$PageSize?>">
<input type="hidden" name="SysTotalPageCount"  id="SysTotalPageCount" value="<?=$TotalPageCount?>">
<input type="hidden"  name="SysTextSearch" id="SysTextSearch" value="<?=$SysTextSearch?>">
<input type="hidden"  name="SysFSort" id="SysFSort" value="<?=$SysFSort?>"/>
<input type="hidden" name="SysSort"  id="SysSort" value="<?=$SysSort?>"/>
<input type="hidden" name="SysCateID"  id="SysCateID" value="<?=$_REQUEST["SysCateID"]?>"/>
</form>


<div class="clearfix">
<div class="btn-group pull-right">
<div class="dataTables_filter" >

<div class="input-append">
<input type="text" id="input_search" name="input_search" value="<?=$SysTextSearch?>" class="input-medium"  placeholder="search..">
<button class="btn" onclick="sysListTextSearch();"><i class="icon-search"></i></button>
</div>
</div>

</div>
<a href="group.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New Group</a>

<a href="group.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=Sorting")?>" class="btn" ><i class="icon-list"></i> Sorting</a>

<div class="line-control-header"></div>
</div>

<div  class="dataTables_wrapper form-inline" role="grid">
 <?
$v_paging["Page"]=$Page;
$v_paging["Type"]="HEAD";
$v_paging["PageSize"]=$PageSize;
$v_paging["TotalRec"]=$TotalRec;
$v_paging["CntRecInPage"]=$RowCountInPage;
SystemPaging($v_paging);
?>

<style>
.dataTable tbody td {
	/*
	vertical-align:top;
	*/
}
</style>
            
<table class="table table-bordered table-hover dataTable" >
<thead>
<tr role="row">
<th  >#</th>
<th <?=SysGetTitleSort('p.usergroupcode',$SysFSort,$SysSort)?>   >Group Code </th>
<th <?=SysGetTitleSort('p.usergroupname',$SysFSort,$SysSort)?>   ></i>  Group Name  </th>

<th <?=SysGetTitleSort('p.publish',$SysFSort,$SysSort)?> style="width: 200px; text-align:center;" >Publish Permissions</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,100,100);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/users/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td class="" valign="top" style="vertical-align:text-top;"  >
<a href="javascript:void(0)"><h5><?=$Row["usergroupcode"]?></h5></a>
</td>
<td class="" valign="top" style="vertical-align:text-top;" >
<?=$Row["usergroupname"]?>
</td>
<td class="span2" style="text-align:center;" ><?=$source_permiss[$Row["publish"]]?> </td>
<td class="span1 text-center ">
<div class="btn-group">
<a href="group.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["usergroupcode"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
<a  _id="<?=$Row["id"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>
</div>
</td>
</tr>
<? } ?>
</tbody>
</table>

<?
$v_paging["Page"]=$Page;
$v_paging["Type"]="FOOTER";
$v_paging["PageSize"]=$PageSize;
$v_paging["TotalRec"]=$TotalRec;
$v_paging["CntRecInPage"]=$RowCountInPage;
SystemPaging($v_paging);
?>

</div>
<script>
$(".btn-del").click(function() {
	 if (confirm('Delete?')) {
		var Vars="ModuleAction=DeleteData&id="+$(this).attr('_id');
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				window.location=window.location;
			}
		});
	 }	
});

</script>


<? 
}else if ($ModuleAction == "InsertNewData") {
?>
<?

	
	$sql = "select usergroupcode  from sysusergroup where usergroupcode = '".trim($_REQUEST['input_groupcode'])."'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	
	if($Content[0]["usergroupcode"]!=""){
		$returnArray[error] = "duplicate";
		$returnArray[text] = "Duplicate the user group code";		
		echo json_encode($returnArray);
		exit;	
	}
	
		$inputPermiss=$_REQUEST["inputPermiss"];
		
		foreach($inputPermiss as $key=>$val){		
			$insert="";
			$insert["usergroupcode"] 		= "'".$_REQUEST['input_groupcode']."'";
			$insert["menuid"] 				= "'".$key."'";
			$insert["controlaccess"] 		=  "'".$val."'";	
			$sql = "insert into sysusergroupaccess(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);	
		}
	
		$insert="";		
		$insert["usergroupcode"] 			= "'".trim($_REQUEST['input_groupcode'])."'";
		$insert["usergroupname"] 			= "'".trim($_REQUEST['input_fname'])."'";
		$insert["publish"] 			= "'".trim($_REQUEST['input_publish'])."'";
	
		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		$insert["createdate"] 			= "sysdate()";
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		
		$_order_by = SystemGetMaxOrder("sysusergroup","1=1")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
			
		$sql = "insert into sysusergroup(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		
		$returnArray[error] = "true";
		$returnArray[text] = "Insert complete";		
		echo json_encode($returnArray);
		exit;
			
	
?>

<? 
}else if ($ModuleAction == "UpdateData") {

	$inputPermiss=$_REQUEST["inputPermiss"];
//	$sql = "delete from sysusergroupaccess where usergroupcode = '".$_REQUEST['ModuleDataID']."'";
	
	/*
	 DELETE pgc
     FROM guide_category pgc 
LEFT JOIN guide g
       ON g.id_guide = gc.id_guide 
    WHERE g.id_guide IS NULL
	*/
	
	$sql = "delete uga from sysusergroupaccess uga left join sysmenu m on(m.menu_id=uga.menuid) where uga.usergroupcode = '".$_REQUEST['ModuleDataID']."' and m.lang_code='".$_SESSION["LANG"]."'";
	
	$Conn->execute($sql);

	foreach($inputPermiss as $key=>$val){		
		$insert="";
		$insert["usergroupcode"] 		= "'".$_REQUEST['ModuleDataID']."'";
		$insert["menuid"] 				= "'".$key."'";
		$insert["controlaccess"] 		=  "'".$val."'";	
		$sql = "insert into sysusergroupaccess(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);	
	}
	
	$update="";
	$update[] = "usergroupname 		= '".trim($_REQUEST['input_fname'])."'";
	$update[] = "publish 		= '".trim($_REQUEST['input_publish'])."'";
	
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	
	$sql = "update  sysusergroup set ".implode(",",array_values($update)) ;
	$sql.=" where usergroupcode = '".$_REQUEST['ModuleDataID']."'";	
	$Conn->execute($sql);

	$returnArray[error] = "true";
	$returnArray[text] = "Insert complete";		
	echo json_encode($returnArray);
	exit;
	
?>



<? 
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "SELECT f.filepic FROM article_main f";
$sql.= " WHERE f.id='".$pid."'";

$Conn->query($sql);
$ContentList = $Conn->getResult();	
$Row = $ContentList[0];	
$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/news'; 
$physical_name=$Row["filepic"];

@unlink($libraryFolder."/".$physical_name);


$sql = "delete from article_main where id = '".$pid."'";
$Conn->execute($sql);

?>


<?
}else if($ModuleAction=="UpdateSortable"){
	
	
	$DataID=$_REQUEST["DataID"];
	$DataOrder=$_REQUEST["DataOrder"];

	$TmpArrID = explode("-", $DataID);
	$TmpArrOrder= explode("-", $DataOrder);
	$TmpArrOrder = array_filter($TmpArrOrder);
	$TmpArrID = array_filter($TmpArrID);
	
	$TmpArrOrder = array_values($TmpArrOrder);
	$max = count($TmpArrID);

	for($i=0;$i<$max; $i++){
		$update="";
		$update[]="order_by='".($i)."'";
		$sql="UPDATE article_main SET ".implode(",",$update)." WHERE id='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>




<? 
}else if ($ModuleAction == "FormUpLoad") {
?>
<style>



</style>

<div class="modal-form" >
    <form id="frmprompt"  style="margin:0; padding:0;" method="post" class="form-horizontal" onsubmit="return false;"> 
        <input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
        <input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
        <input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
     
<div class="modal-header" >
	<a class="close" data-dismiss="modal">&times;</a>
	<h3>Add New Category</h3>
</div>
<div class="modal-body" style="width:500px;">
<br />


<div class="control-group">
<label class="control-label" for="category_name">Category name</label>
<div class="controls">
<input type="text" id="category_name" name="category_name" value="<?=$Row["name"]?>" required>
<span class="help-block">Category name..</span>
</div>
</div>

<div class="control-group">
<label class="control-label" for="parent_id">Parent id</label>
<div class="controls">
<select id="parent_id" name="parent_id" required>
<option value="0" data-level="0" >-</option>
<? my_loadTreeCatSelect(0,$Row["parent_id"]); ?>
</select>      
<span class="help-block">Category name..</span>
</div>
</div>

</div>
<div class="modal-footer">
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
	<a class="btn btn-success" onclick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></a>
	<a class="btn" data-dismiss="modal">Close</a>
</div>
</form>
</div>


<?
}

?>