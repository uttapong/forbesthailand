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


if ($ModuleAction == "loadDataProjectRefer") {
	if(!$Page){
		$Page=$_REQUEST["SysPage"];
	}
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["input_search"]);


	$project_list=$_REQUEST["project_list"];
	
	$project_array=explode("-",$project_list);

	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.id";
	if ($SysSort=="") $SysSort="desc";
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.* FROM project_main p";
	$sql.= " WHERE 1=1 ";
	
	if(trim($project_list)!=""){
		$sql.="  and p.id not in(0,".implode(',',$project_array).")";
	}
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=" or p.project_owner like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	
	
?>	
<div  class="dataTables_wrapper form-inline" role="grid"  style="overflow:hidden; height:360px;">       
<table class="table  table-striped" >
<thead>
<tr role="row">
<th  style="width:30px;" >#&nbsp;</th>
<th >Subject</th>
<th style="width:300px;" >Project Owner
</th>
</tr>
</thead>

<tbody >

<?
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 
?>

<tr >
<td valign="top" style="padding-top:0px; margin-top:0px;" >
<input class="chkproject" type="checkbox" name="inputSelectProject[]" id="input<?=$Row["id"]?>" value="<?=$Row["id"]?>"/>
</td>
<td class="" valign="top" >
<?=$Row["name"]?>
</td>
<td ><?=$Row["project_owner"]?></td>


</tr>
<? } ?>


</tbody>
</table>

<? if($TotalRec<1){ ?>
<div style="height:130px; padding-top:100px; text-align:center; vertical-align:middle;">
Data not found.
</div>

<? } ?>

<style>
.table-striped tbody tr{ cursor:pointer }
.bg{background-color:#5bb75b !important; color:#fff;}
</style>
<script>

$(document).ready(function(){
						   
$('.chkproject').on('click', function () {	
	$(this).parent('td').parent('tr').click();								   
});						   
										   
 $('table.table-striped tbody tr').on('click', function () {
	   if($(this).find('td').find('input').prop('checked')==true){
			     $(this).find('td').removeClass('bg'); 
				 $(this).find('td').find('input').prop('checked',false);
	   }else{
		      $(this).find('td').addClass('bg');
			   $(this).find('td').find('input').prop('checked',true);
	   }     
    });
});

</script>




</div>

<? }else if ($ModuleAction == "selectListProject") { 

$inputSelectProject=$_REQUEST["inputSelectProject"];

if(is_array($inputSelectProject)){
	$filelist_id= "'".implode("','",$inputSelectProject)."'";
	
	$sql = "SELECT * FROM project_main ";
	$sql.= " WHERE id in($filelist_id) ";
	$sql.= " ORDER BY id ASC";
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
		
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		
		?>
        <li class="boxli_project_refer" id="L<?=$Row["id"]?>" >
        <div>
        <div class="file-name" ><?=$Row["name"]?></div>
        <div style="float:left; width:48px;"  class="btn btn-danger delete" onclick="library_remove_project(this);">นำออก</div>
      </div>
        </li>
<?	
	}	
}
?>
<?
} 
?>