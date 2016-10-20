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
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.*,c.name as category_name,f.physical_name FROM store_main p";
	$sql.=" left join store_category c on(c.cate_id=p.cate_id) ";
	$sql.=" left join store_file f on(f.store_id=p.id and f.order_by='1' )";
	$sql.= " WHERE 1=1 ";
	$sql.= " ORDER BY p.order_by ASC";
	
	
	$sql = " select * from contactus ";
	
	
	#echo $sql;
	
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
<input type="hidden"  name="SysFSort" id="SysFSort" value="<?=$Sys_FSort?>"/>
<input type="hidden" name="SysSort"  id="SysSort" value="<?=$Sys_Sort?>"/>

<input type="hidden" name="SysCateID"  id="SysCateID" value="<?=$_REQUEST["SysCateID"]?>"/>

</form>
<div class="clearfix">
<div class="btn-group pull-right">

<div class="dataTables_filter" ><label>


<div style="float:left; margin-right:10px;">
 
</div>
<div class="input-append">


<input type="text" id="general-append5" name="general-append5" class="input-medium" placeholder="search..">
<button class="btn"><i class="icon-search"></i></button>
</div>

</label></div>

</div>

<div style=" height:28px;">&nbsp;</div>

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
<th class="span1 text-center hidden-phone sorting" style="width:40px;" >#</th>
<th class="sorting"  style="width:150px; cursor:pointer;" ><i class="icon-user"></i> Name</th>
<th class="hidden-phone hidden-tablet sorting_asc" style="width: 150px;" >Email</th>

<th  style="width: 300px;"  >Comment</th>
<th class="span1 text-center sorting_disabled" style="width:36px;"><i class="icon-bolt"></i></th></tr>
</thead>

<tbody >

<?

	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$resize=SystemResizeImgAuto($Row["file_width"],$Row["file_height"],100,100);
	$physical_name=_SYSTEM_HOST_NAME_."/uploads/store/".$Row["physical_name"];
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>

<td class="" valign="top" style="vertical-align:text-top" >
<a href="javascript:void(0)"><?=$Row["name"]?></a>
<br />
Date : <?=SystemDateFormat($Row["createdate"],'d/m/Y h:i')?>

</td>
<td class="hidden-phone"  style="vertical-align:text-top" ><?=$Row["email"]?></td>


<td  style="vertical-align:text-top" ><?=$Row["message"]?></td> 
<td class="span1 text-center ">
<div class="btn-group">

<a _id="<?=$Row["id"]?>" href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>


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
			url : "list-action.php",
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
		
		$insert="";
		$insert["site_code"] 			= "'S0001'";
		$insert["cate_id"] 				= "'".trim($_REQUEST['cate_id'])."'";
		$insert["name"] 			= "'".trim($_REQUEST['product_name'])."'";
		$insert["description"] 			= "'".trim($_REQUEST['description'])."'";
		$sql = "insert into store_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		
		$StoreID=$Conn->getInsertID();
		
		/*       FILE PHOTO  UPLOAD    */
		$file_list= substr($_REQUEST["inputPhotoFileID"],0,strlen($_REQUEST["inputPhotoFileID"])-1);
		$file_array=explode("-",$file_list);
		if(is_array($file_array)){	
		$order_by=0;
		foreach($file_array as $val){	
			$order_by++;
			if(strpos(":".$val,"L")){
				$_file_val_id=str_replace("L","",$val);	
				$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$_file_val_id."'");	
				
				$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
				
				$insert="";
				$insert["store_id"] 			= "'".$StoreID."'";
				$insert["file_name"] 			= "'".$_source_library["file_name"]."'";
				$insert["physical_name"] 		= "'".$store_physical_name."'";
				$insert["file_type"] 			= "'".$_source_library["file_type"]."'";
				$insert["file_size"] 			= "'".$_source_library["file_size"]."'";
				$insert["file_width"] 			= "'".$_source_library["file_width"]."'";
				$insert["file_height"] 			= "'".$_source_library["file_height"]."'";
				
				$insert["order_by"] 			= "'".$order_by."'";	
				
		
				
				$sql = "insert into store_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/store';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
		
			}
		}	
	}
	###########################
		
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	
	$update="";
	$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
	$update[] = "name 		= '".trim($_REQUEST['product_name'])."'";
	$update[] = "description 		= '".trim($_REQUEST['description'])."'";
	$update[] = "flag_display 		= '".trim($_REQUEST['product_display'])."'";
	
	
	
	
	
	if($_REQUEST["statusRecommend"]>0){
		$update[] = "flag_recommend 		= '1'";
	}else{
		$update[] = "flag_recommend 		= '0'";
	}
	
	if($_REQUEST["statusBestseller"]>0){
		$update[] = "flag_bestseller 		= '1'";
	}else{
		$update[] = "flag_bestseller 		= '0'";
	}
	
	
	
	
	$sql = "update  store_main set ".implode(",",array_values($update)) ;
	$sql.=" where id = '".$_REQUEST['ModuleDataID']."'";	
	$Conn->execute($sql);

	/*       FILE PHOTO  UPLOAD    */
	$file_list= substr($_REQUEST["inputPhotoFileID"],0,strlen($_REQUEST["inputPhotoFileID"])-1);
	$file_old_list= substr($_REQUEST["inputPhotoOldFileID"],0,strlen($_REQUEST["inputPhotoOldFileID"])-1);
	
	$file_array=explode("-",$file_list);
	$file_old_array=explode("-",$file_old_list);
	
	$file_old_store=array();
	foreach($file_array as $val){
		if(strpos(":".$val,"P")) $file_old_store[]= str_replace("P","",$val);			
	}
	$file_delete = array_diff($file_old_array, $file_old_store);
	
	
	if(count($file_delete)){
		 foreach($file_delete as $val){
			$row_filestore=SystemGetMoreData("store_file",array('physical_name'),"id='".$val."'");	
			$file_path_delete = _SYSTEM_UPLOADS_FOLDER_.'/store/'.$row_filestore["physical_name"];
			if (file_exists($file_path_delete)) {
				@unlink($file_path_delete);
			}
			$sql = "delete from store_file where id = '".$val."'";
			$Conn->execute($sql);
		 }
	}
	
	if(is_array($file_array)){	
		$order_by=0;
		foreach($file_array as $val){	
			$order_by++;
			if(strpos(":".$val,"L")){
				$_file_val_id=str_replace("L","",$val);	
				$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$_file_val_id."'");	
				
				$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
				
				$insert="";
				$insert["store_id"] 			= "'".$_REQUEST['ModuleDataID']."'";
				$insert["file_name"] 			= "'".$_source_library["file_name"]."'";
				$insert["physical_name"] 		= "'".$store_physical_name."'";
				$insert["file_type"] 			= "'".$_source_library["file_type"]."'";
				$insert["file_size"] 			= "'".$_source_library["file_size"]."'";
				
				$insert["file_width"] 			= "'".$_source_library["file_width"]."'";
				$insert["file_height"] 			= "'".$_source_library["file_height"]."'";
				
				$insert["order_by"] 			= "'".$order_by."'";
				
				
				
				$sql = "insert into store_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/store';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
			}else{
				$_file_val_id=str_replace("P","",$val);	
				$update="";
				$update[] = "order_by 		= '".$order_by."'";
				$sql = "update  store_file set ".implode(",",array_values($update)) ;
				$sql.=" where id = '".$_file_val_id."'";	
				$Conn->execute($sql);

				
			}
		}	
	}
	
	/*  ########################################################## */
	
?>


<? 
}else if ($ModuleAction == "DeleteData") {

$file_id= $_REQUEST["id"];

$sql = "delete from contactus where id = '".$file_id."'";
$Conn->execute($sql);

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