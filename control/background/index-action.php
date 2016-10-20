<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
	require("function.php");
	$SysPMS=SystemGetPermissionText($SysMenuID);
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>

<?
$sourceBGMenu["COVER"]="COVER";
$sql = "SELECT  *  FROM article_category a ";
$sql.= "WHERE  a.menu_id='MNT13' and a.level='1' ";
$sql.= " ORDER BY a.order_by asc";	

$Conn->query($sql);
$BGCateList = $Conn->getResult();
$CntRecBG = $Conn->getRowCount();
for ($j=0;$j<$CntRecBG;$j++) {
	$RowCate = $BGCateList[$j];
	$sourceBGMenu["LIFE_TH_".$RowCate["cate_id"]]="FORBES LIFE THAILAND : ".$RowCate["name_".strtolower($_SESSION['FRONT_LANG'])];
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
	
	
	$SysCateID=$_REQUEST["SysCateID"];
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.* FROM bg_main p";
	//$sql.=" left join article_category c on(c.cate_id=p.cate_id) ";
	
	if (trim($SysCateID)!="" && trim($SysCateID)!="0"){
		$sql.=" inner join  ads_menu c on(c.ads_id=p.id and c.menu_code='".$SysCateID."') ";
	}
	
	$sql.= " WHERE p.menu_id='".$SysMenuID."'";
	
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}

	
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	//echo $sql;
	
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	
	
?>	



<form name="mySearch" id="mySearch" action="./index.php" method="post">
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden"  name="SysModURL" id="SysModURL" value="index-action.php"/>
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
<div style="float:left; margin-right:10px;">
<!--
<select id="search_cateid" name="search_cateid" onchange="sysListCateIDSearch();" >
<option value="0" data-level="0" >-</option>
<?=SystemArraySelect($sourceAdsMenu,$_REQUEST["SysCateID"]); ?>
</select> 
-->
</div>
<div class="input-append">
<input type="text" id="input_search" name="input_search" value="<?=$SysTextSearch?>" class="input-medium"  placeholder="search..">
<button class="btn" onclick="sysListTextSearch();"><i class="icon-search"></i></button>
</div>
</div>

</div>
<? if($SysPMS=="MANAGE"){ ?>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New</a>


<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=Sorting")?>" class="btn" ><i class="icon-list"></i> Sorting</a>
<? }else{ ?>
<div style=" height:28px;">&nbsp;</div>
<? } ?>
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
<th style="width:30px;" <?=SysGetTitleSort('p.id',$SysFSort,$SysSort)?>  >#</th>
<th  style="width:220px;">&nbsp;</th>
<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   >Subject</th>
<? 	if($SysMenuID!="SADST04" && $SysMenuID!="SADST05" && $SysMenuID!="SADSE04" && $SysMenuID!="SADSE05" ){ ?>
<th style="width:180px;" >Category</th>
<? } ?>

<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 100px;" >Enable/Disable</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,200,200);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/bg/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	if($SysMenuID=="SADST05"){
		$resize[0]="107";
		
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td align="center" style="text-align:center;">
<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid">
</td>
<td class="" valign="top"  >
<?=SystemSubString($Row["name"],65,'..')?>

</td>
<td class="" valign="top"  >
<?=$sourceBGMenu[$Row["cate_key"]]?>
</td>


<td class="span2" style="text-align:center;" ><a href="#" class="btn-status <? if($Row["flag_display"]!="Y"){?> dis <? } ?>" _did="<?=$Row["id"]?>" style=""><?=$source_status[$Row["flag_display"]]?></a> </td>
<td class="span1 text-center ">
<div class="btn-group">

<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" class="btn btn-mini btn-success" title="Edit"><i class="icon-pencil"></i></a>
<a  _id="<?=$Row["id"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>
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

	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];

	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/bg';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	
		$input_name_th = SystemCheckInputToDB($_REQUEST["input_name"]);
		
		
		$insert="";
		$insert["site_code"] 			= "'S0001'";		
		$insert["cate_key"] 			= "'".trim($_REQUEST['cate_key'])."'";
		$insert["menu_id"] 				= "'".trim($_REQUEST['SysMenuID'])."'";
		$insert["flag_display"] 		= "'".trim($_REQUEST['product_display'])."'";	
		
		$insert["name"] 				= "".$input_name_th."";
	
		
		if($input_fileIDOnePic!=""){
			$insert["filepic"] 			= "'".$store_physical_name."'";	
		}
	
		
		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		$insert["createdate"] 			= "sysdate()";		
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		
		$_order_by = SystemGetMaxOrder("bg_main","")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		$sql = "insert into bg_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		$StoreID=$Conn->getInsertID();
		
	
	echo SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);		
		
		
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];
	
	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/bg';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}

	$input_name_th = SystemCheckInputToDB($_REQUEST["input_name"]);
		
		

	
	$update="";
	$update[] = "cate_key		= '".trim($_REQUEST['cate_key'])."'";
	$update[] = "menu_id 		= '".trim($_REQUEST['SysMenuID'])."'";	
	$update[] = "name 		= ".$input_name_th."";

	if($input_fileIDOnePic!=""){
		$update[] = "filepic 		= '".$store_physical_name."'";
	}
	
	$update[] = "flag_display 		= '".trim($_REQUEST['product_display'])."'";
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	$sql = "update  bg_main set ".implode(",",array_values($update)) ;
	$sql.=" where id = '".$_REQUEST['ModuleDataID']."'";	
	
	
	$Conn->execute($sql);
	

	
?>



<? 
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "SELECT f.filepic FROM bg_main f";
$sql.= " WHERE f.id='".$pid."'";

$Conn->query($sql);
$ContentList = $Conn->getResult();	
$Row = $ContentList[0];	
$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads'; 
$physical_name=$Row["filepic"];

@unlink($libraryFolder."/".$physical_name);


$sql = "delete from bg_main where id = '".$pid."'";
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
		$sql="UPDATE bg_main SET ".implode(",",$update)." WHERE id='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>



<?
}else if ($ModuleAction == "UpdateStatus") {
	
	$did=$_REQUEST["did"];
	$status=$_REQUEST["status"];	
	$update="";
	$update[]="flag_display='".$status."'";
	$sql="UPDATE bg_main SET ".implode(",",$update)." WHERE id='".$did."' ";
	$Conn->execute($sql);
	
	echo $source_status[$status];	
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