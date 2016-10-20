<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
	require("function.php");
	$SysPMS=SystemGetPermissionText($SysMenuID);
}else{
	if($_REQUEST['ModuleAction']!=""){
		$ModuleAction = $_REQUEST['ModuleAction'];
		$SysMenuID=$_POST["SysMenuID"];
		$ModuleDataID = $_REQUEST['ModuleDataID'];
	}	
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
	if($ModuleDataID==""){
		$ModuleDataID=$_REQUEST["ModuleDataID"];
	}
	
	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.createdate";
	if ($SysSort=="") $SysSort="asc";
	
	
	$SysCateID=$_REQUEST["SysCateID"];
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=30;
	
	
	$searchDate1=$_REQUEST["searchDate1"];
	$searchDate2=$_REQUEST["searchDate2"];
	
	
	
	
	
	$sql = "select *  from ads_main where id = '$ModuleDataID'";
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$RowHead=$Content[0];
	
	
	
	
	
	$sql = "SELECT p.* FROM  ads_state p";
	$sql.= " WHERE p.ads_id='".$ModuleDataID."' and type='V' ";
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	if($searchDate1 !="" && $searchDate2 !=""){
		$sql.=" and (DATE(p.createdate)>= DATE('".SystemDateFormatDB($searchDate1)."') and DATE(p.createdate)<= DATE('".SystemDateFormatDB($searchDate2)."')) ";
	}
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	
	
	
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	

	
?>	






<div class="clearfix">
<div class="btn-group pull-right">



</div>



<div style="padding:20px 0px; margin:0px 20px; text-align:center;" >

<div style="padding:10px 0px 40px; font-size:16px;">
<b>Display Stat :</b> <?=$RowHead["name_th"]?>
</div>
<form name="mySearch" id="mySearch" action="./index.php" method="post">
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden"  name="SysModURL" id="SysModURL" value="stat-action.php"/>
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemGetReturnURL()?>"/>
<input type="hidden" name="SysPage"  id="SysPage" value="<?=$Page?>">
<input type="hidden" name="SysPageSize"  id="SysPageSize" value="<?=$PageSize?>">
<input type="hidden" name="SysTotalPageCount"  id="SysTotalPageCount" value="<?=$TotalPageCount?>">
<input type="hidden"  name="SysTextSearch" id="SysTextSearch" value="<?=$SysTextSearch?>">
<input type="hidden"  name="SysFSort" id="SysFSort" value="<?=$SysFSort?>"/>
<input type="hidden" name="SysSort"  id="SysSort" value="<?=$SysSort?>"/>
<input type="hidden" name="SysCateID"  id="SysCateID" value="<?=$_REQUEST["SysCateID"]?>"/>
<input type="hidden" name="ModuleDataID"  id="ModuleDataID" value="<?=$ModuleDataID?>"/>


Form <input type="text" id="searchDate1" name="searchDate1"  class="calendar clsDatePicker" value="<?=$searchDate1?>"> 
 to 
<input type="text" id="searchDate2" name="searchDate2"  class="calendar" value="<?=$searchDate2?>">

<script>
  $(function() {
    $( "input.calendar" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  </script>
 
 <a style="margin-top:-10px;" href="javascript:sysListTextSearch()" data-toggle="tooltip"  target="_blank"  class="btn btn-mini" title="กรอง | Filter">กรอง | Filter</a> 
 
  <a style="margin-top:-10px;"  href="javascript:sysAllTextSearch()"  data-toggle="tooltip"  target="_blank"  class="btn btn-mini" title="ดูทั้งหมด | See all">ดูทั้งหมด | See all</a> 
  


<div style="font-size:18px; text-align:center; padding:20px 100px; padding-bottom:0px;">
<div >
Diplay Count : <?=number_format($RowHead["cread"],0)?>  &nbsp; | &nbsp;   Click Count : <?=number_format($RowHead["cstate"],0)?>
</div>
</div>

</form>
</div>


</div>

<div  class="dataTables_wrapper form-inline" role="grid" style="width:95%; margin:auto; margin-top:10px; border-top:1px solid #ddd;">
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
            
<table class="table table-bordered table-hover dataTable">
<thead>
<tr role="row">
<th style="width:20px;"  >#</th>
<th  >หน้าแสดงผล</th>
<th  style="text-align:center;width:120px;"  >IP</th>
<th style="width: 160px;" >วันที่</th>
</tr>
</thead>

<tbody >

<?

	$_index=(($Page-1)*$PageSize)+1;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 

?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td class="" valign="top"  >
<?=$Row["link"]?>
</td>
<td class="" valign="top"  >
<?=$Row["ipaddress"]?>
</td>

<td class="span1 text-center ">
<?=$Row["createdate"]?>
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
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "SELECT f.filepic FROM ads_main f";
$sql.= " WHERE f.id='".$pid."'";

$Conn->query($sql);
$ContentList = $Conn->getResult();	
$Row = $ContentList[0];	
$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads'; 
$physical_name=$Row["filepic"];

@unlink($libraryFolder."/".$physical_name);


$sql = "delete from ads_main where id = '".$pid."'";
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
		$sql="UPDATE ads_main SET ".implode(",",$update)." WHERE id='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>



<?
}else if ($ModuleAction == "UpdateStatus") {
	
	$did=$_REQUEST["did"];
	$status=$_REQUEST["status"];	
	$update="";
	$update[]="flag_display='".$status."'";
	$sql="UPDATE ads_main SET ".implode(",",$update)." WHERE id='".$did."' ";
	$Conn->execute($sql);
	
	echo $source_status[$status];	
?>


<? 
}
?>