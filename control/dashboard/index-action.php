<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>

<?
if ($ModuleAction == "Datalist") {
	
	$Page=$_REQUEST["SysPage"];
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["SysTextSearch"]);
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	$sql = "SELECT p.*,c.name as category_name FROM store_main p";
	$sql.=" left join store_category c on(c.cate_id=p.cate_id) ";
	$sql.= " WHERE 1=1 ";
	$sql.= " ORDER BY p.order_by ASC";
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
<input type="hidden" name="SysPage"  id="SysPage" value="<?=$Page?>">
<input type="hidden" name="SysPageSize"  id="SysPageSize" value="<?=$PageSize?>">
<input type="hidden" name="SysTotalPageCount"  id="SysTotalPageCount" value="<?=$TotalPageCount?>">
<input type="hidden"  name="SysTextSearch" id="SysTextSearch" value="<?=$SysTextSearch?>">
<input type="hidden"  name="SysFSort" id="SysFSort" value="<?=$Sys_FSort?>"/>
<input type="hidden" name="SysSort"  id="SysSort" value="<?=$Sys_Sort?>"/>
</form>
<div class="clearfix">
<div class="btn-group pull-right">

<div class="dataTables_filter" id="example-datatables_filter"><label>
<div class="input-append">
<input type="text" id="general-append5" name="general-append5" class="input-medium" placeholder="search..">
<button class="btn"><i class="icon-search"></i></button>
</div>

</label></div>

</div>
<a href="index.php?<?=SystemEncryptURL("ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New Product</a>

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

            
<table class="table table-bordered table-hover dataTable" >
<thead>
<tr role="row">
<th class="span1 text-center hidden-phone sorting" >#</th>
<th class="sorting"  style="width: 300px; cursor:pointer;" ><i class="icon-user"></i> Product name</th>
<th class="hidden-phone hidden-tablet sorting_asc" style="width: 508px;" >Category</th>
<th class="span2 hidden-phone sorting" style="width: 125px;" >Enable/Disable</th>
<th class="span1 text-center sorting_disabled" style="width: 46px;"><i class="icon-bolt"></i></th></tr>
</thead>

<tbody >

<?
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td class=""><a href="javascript:void(0)"><?=$Row["name"]?></a></td>
<td class="hidden-phone sorting_1"><?=$Row["category_name"]?></td>
<td class="span2"></td>
<td class="span1 text-center ">
<div class="btn-group">
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
<a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger" data-original-title="Delete"><i class="icon-trash"></i></a>


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
			

?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	
	$update="";
	$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
	$update[] = "name 		= '".trim($_REQUEST['product_name'])."'";
	
	$sql = "update  store_main set ".implode(",",array_values($update)) ;
	$sql.=" where id = '".$_REQUEST['ModuleDataID']."'";		
	
	$Conn->execute($sql);

}

?>