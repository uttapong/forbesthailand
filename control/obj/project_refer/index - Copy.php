<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../../lib/system_core.php");
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

	
	?>
    <div class="modal-form" >
    <form id="frmprompt"  style="margin:0; padding:0;" method="post" class="form-horizontal" onsubmit="return false;"> 
        <input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
        <input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
        <input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
        <input type="hidden" name="SysGroup" id="SysGroup" value="<?=$SysGroup?>" />
        
     
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h3>Select Project references</h3>
</div>
<div class="modal-body">

<div id="data_project_area">

</div>


<script>
var Vars=$('#frmprompt').serialize();	
		$.ajax({
			url : "../obj/project_refer/index.php?ModuleAction=loadDataProjectRefer",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				//alert(resp);
				$('#data_project_area').html(resp);
			}
		});
	
</script>


</div>
<div class="modal-footer">
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
	<a class="btn btn-primary" onclick="submitFormContent();">Save Changes</a>
	<a class="btn" data-dismiss="modal">Close</a>
</div>
</form>
</div>
<? 

}else if($ModuleAction=="loadDataProjectRefer"){
	

?>
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
<th <?=SysGetTitleSort('p.id',$SysFSort,$SysSort)?>  >#</th>
<th  style="width:150px;">&nbsp;</th>
<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   >Subject</th>

<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 125px;" >Enable/Disable</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,100,100);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/project_refer/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td>

<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid">


</td>
<td class="" valign="top" >


<a href="javascript:void(0)"><?=$Row["name"]?></a>

</td>
<td class="span2" style="text-align:center;" ><?=$source_status[$Row["flag_display"]]?> </td>
<td class="span1 text-center ">
<div class="btn-group">


<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini" data-original-title="Edit"><i class="icon-eye-open"></i></a>

<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
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

<?
	
//	sleep(1);
	
}

?>