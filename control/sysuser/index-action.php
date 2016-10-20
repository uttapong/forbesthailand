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
	if($PageSize<1) $PageSize=20;
	
	
	$sql = "SELECT p.*,c.usergroupname as usergroupname FROM sysuser p";
	$sql.=" left join sysusergroup c on(c.usergroupcode=p.usergroupcode) ";
	
	
	$sql.= " WHERE 1=1 ";
	
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.firstname  like '%".$SysTextSearch."%' or p.username  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	if (trim($SysCateID)!="" && trim($SysCateID)!="0"){
		$sql.=" AND (p.usergroupcode  = '".$SysCateID."' ";
		$sql.=")";
	}
	
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	
	
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

<select id="search_cateid" name="search_cateid" onchange="sysListCateIDSearch();" >
<option value="0" data-level="0" >-</option>
<?=SystemGetSqlSelect('sysusergroup','usergroupcode','usergroupname',$_REQUEST["SysCateID"],'order_by',""); ?>
</select> 

</div>
<div class="input-append">
<input type="text" id="input_search" name="input_search" value="<?=$SysTextSearch?>" class="input-medium"  placeholder="search..">
<button class="btn" onclick="sysListTextSearch();"><i class="icon-search"></i></button>
</div>
</div>

</div>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New User</a>

<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=Sorting")?>" class="btn" ><i class="icon-list"></i> Sorting</a>

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
<th <?=SysGetTitleSort('p.id',$SysFSort,$SysSort)?>  >#</th>
<th  style="width:115px;">&nbsp;</th>
<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   ><i class="icon-user"></i> Name </th>
<th <?=SysGetTitleSort('p.username',$SysFSort,$SysSort)?>   ></i> Username </th>

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
<td>

<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid">


</td>
<td class="" valign="top" style="vertical-align:text-top;"  >
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["userid"])?>"><h4><?=$Row["firstname"]?> <?=$Row["lastname"]?></h4></a>

กลุ่มสิทธิการใช้งาน : <?=$Row["usergroupname"]?>

</td>
<td class="" valign="top" style="vertical-align:text-top;" >
<?=$Row["username"]?>
</td>
<td class="span1 text-center ">
<div class="btn-group">
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["userid"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
<? if($Row["username"]!="admin"){?>
<a  _id="<?=$Row["userid"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>
<? } ?>
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

	
	$sql = "select userid  from sysuser where username = '".trim($_REQUEST['input_username'])."'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	
	if($Content[0]["userid"]!=""){
		$returnArray[error] = "duplicate";
		$returnArray[text] = "Duplicate the username";		
		echo json_encode($returnArray);
		exit;	
	}


	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];

	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/users';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
		$UserID=SystemAutoNumber('sysuser','U',3,'GET');
		
		$insert="";		
		$insert["userid"] 			= "'".$UserID."'";
		$insert["firstname"] 			= "'".trim($_REQUEST['input_fname'])."'";
		$insert["lastname"] 			= "'".trim($_REQUEST['input_lastname'])."'";
		
		$insert["firstname_th"] 		= "'".trim($_REQUEST['input_fname'])."'";
		$insert["lastname_th"] 			= "'".trim($_REQUEST['input_lastname'])."'";	
		$insert["firstname_en"] 			= "'".trim($_REQUEST['input_fname_en'])."'";
		$insert["lastname_en"] 			= "'".trim($_REQUEST['input_lastname_en'])."'";
		
		$insert["position_th"] 			= "'".trim($_REQUEST['input_position_th'])."'";
		$insert["position_en"] 			= "'".trim($_REQUEST['input_position_en'])."'";
		
		
		
		$insert["username"] 			= "'".trim($_REQUEST['input_username'])."'";
		$insert["usergroupcode"] 			= "'".trim($_REQUEST['usergroupcode'])."'";
		
		//usergroupcode
		
		
		$insert["password"] 			= "'".md5(trim($_REQUEST['input_pw']))."'";
		$insert["password_tmp"] 		= "'".trim($_REQUEST['input_pw'])."'";
		
		if($input_fileIDOnePic!=""){
			$insert["filepic"] 			= "'".$store_physical_name."'";	
		}
		
		
		$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
		$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);

		$insert["content_th"] 			= "".$input_content_th."";
		$insert["content_en"] 			= "".$input_content_en."";
		


		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		$insert["createdate"] 			= "sysdate()";
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		
		$_order_by = SystemGetMaxOrder("sysuser","1=1")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		
		$sql = "insert into sysuser(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		$StoreID=$Conn->getInsertID();	
		
		$Uid=SystemAutoNumber('sysuser','U',3,'ADD');
		
		$returnArray[error] = "true";
		$returnArray[text] = "Insert complete";		
		echo json_encode($returnArray);
		exit;
			
	
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	
		
	$sql = "select userid  from sysuser where username = '".trim($_REQUEST['input_username'])."'  and userid<>'".$_REQUEST['ModuleDataID']."'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	
	if($Content[0]["userid"]!=""){
		$returnArray[error] = "duplicate";
		$returnArray[text] = "Duplicate the username";		
		echo json_encode($returnArray);
		exit;	
	}

	
	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];
	
	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/users';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	
	$input_content = stripslashes( (string)$_REQUEST["input_content"] );


	
	$update="";
	//$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
	
	//$update[] = "date_display 	= '".SystemDateFormatDB(trim($_REQUEST['input_showdate']))."'";
	
	if($_REQUEST["flagChangePW"]=="Y"){
		$update[] = "password 		= '".md5(trim($_REQUEST['input_pw']))."'";
		$update[] = "password_tmp 	= '".trim($_REQUEST['input_pw'])."'";
	}
	
	
	$update[] = "firstname 		= '".trim($_REQUEST['input_fname'])."'";
	$update[] = "lastname 		= '".trim($_REQUEST['input_lastname'])."'";
	$update[] = "firstname_th 		= '".trim($_REQUEST['input_fname'])."'";
	$update[] = "lastname_th		= '".trim($_REQUEST['input_lastname'])."'";
	$update[] = "firstname_en 		= '".trim($_REQUEST['input_fname_en'])."'";
	$update[] = "lastname_en		= '".trim($_REQUEST['input_lastname_en'])."'";
	
	$update[] = "position_th 		= '".trim($_REQUEST['input_position_th'])."'";
	$update[] = "position_en		= '".trim($_REQUEST['input_position_en'])."'";
	
	
	$update[] = "usergroupcode 		= '".trim($_REQUEST['usergroupcode'])."'";


	if($input_fileIDOnePic!=""){
		$update[] = "filepic 		= '".$store_physical_name."'";
	}
	
		
	$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
	$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);
	
	$update[] = "content_th 		= ".$input_content_th."";
	$update[] = "content_en 		= ".$input_content_en."";

	
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	
	$sql = "update  sysuser set ".implode(",",array_values($update)) ;
	$sql.=" where userid = '".$_REQUEST['ModuleDataID']."'";	
	
	
	$Conn->execute($sql);

	
		$returnArray[error] = "true";
		$returnArray[text] = "Insert complete";		
		echo json_encode($returnArray);
		exit;
	
?>



<? 
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "delete from sysuser where userid = '".$pid."'";
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
		$sql="UPDATE sysuser SET ".implode(",",$update)." WHERE userid='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>







<? 
}

?>