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
	
	if($_SESSION['LANG']=="TH"){	
		$menu_list= "'SRWT01','MNT01','MNT02','MNT03','MNT04','SKMT01' ";
	}else{
		$menu_list= "'SRWE01','MNE01','MNE02','MNE03','MNE04','SKME01'";
	}
	
	
	$sql = "SELECT c.*,p.content_id,f.physical_name  FROM  hilight_main p";
	$sql.=" inner join article_main c on(c.id=p.content_id) ";
		$sql.=" left join article_file f on(f.article_id=c.id and f.order_by='1' )";
	
	//$sql.= " WHERE p.menu_id in(".$menu_list.") ";
	
	
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
<!-- SELECT --> 
</div>
<div class="input-append">
<input type="text" id="input_search" name="input_search" value="<?=$SysTextSearch?>" class="input-medium"  placeholder="search..">
<button class="btn" onclick="sysListTextSearch();"><i class="icon-search"></i></button>
</div>
</div>

</div>
<? if($SysPMS=="MANAGE"){ ?>
<!--
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New Article</a>
-->

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
<th <?=SysGetTitleSort('p.id',$SysFSort,$SysSort)?>  >#</th>
<th  style="width:220px;">&nbsp;</th>
<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   >Subject</th>

<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 165px; text-align:center;" >Module</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/article/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td align="center" style="text-align:center;">
<img src=<?=$physical_name?>  width="200" class="img-polaroid" >
</td>
<td class="" valign="top" style="vertical-align:top;"  >
<div style="min-height:90px; max-width:500px; display:inline-block;overflow: hidden;text-overflow: ellipsis;">
<img src="../img/lang/flag-th.gif" > <?=SystemSubString($Row["name_th"],65,'..')?><br />
<img src="../img/lang/flag-en.gif" > <?=SystemSubString($Row["name_en"],65,'..')?><br />
</div>

<? if($Row["dateshow1"]!="0000-00-00 00:00:00" && $Row["dateshow1"]!="0000-00-00 00:00:00"){ ?>
<div>
<?=_ContentShowDate_?> :  
<?=SystemDateFormat($Row["dateshow1"])?> - <?=SystemDateFormat($Row["dateshow2"])?>
</div>
<?
$d1=strtotime(date($Row["dateshow1"]));
$d2=strtotime(date($Row["dateshow2"]));
$dc= strtotime(date("Y-m-d"));

?>
<? if( !($d1<=$dc && $d2>=$dc) ){ ?>
<div class="lbl_notshow"><?=_ContentNotShow_?></div>
<? } ?>

<? } ?>

</td>
<td class="span2" style="text-align:center;" >
<?
	 if($Row["menu_id"]=="MNT01" ){	
		echo "LIST'S RICH";
	}else if($Row["menu_id"]=="MNT02" ){
			echo "COVER";
	}else if($Row["menu_id"]=="MNT03"){ 
		echo "NEWS";	
	}else if($Row["menu_id"]=="MNT04"){
		echo "PEOPLE  ";	
	}else if($Row["menu_id"]=="MNT05"){
		echo "ENTREPRENEURS  ";
	}else if($Row["menu_id"]=="MNT06"){
		echo "ASIAN BIZ  ";
	}else if($Row["menu_id"]=="MNT07"){
		echo "WORLD";	
	}else if($Row["menu_id"]=="MNT08"){
		echo "FORBES LIFE";	
	}else if($Row["menu_id"]=="MNT09"){
		echo "TECHNOLOGY";	
	}else if($Row["menu_id"]=="MNT10"){
		echo "COMMENTARIES";	
	}else if($Row["menu_id"]=="MNT11"){
		echo "LEADERBOARD";
	}else if($Row["menu_id"]=="MNT12"){
		echo "FORBES EVENT & CONFERENCE";
	}else if($Row["menu_id"]=="MNT13"){
		echo "FORBES LIFE THAILAND";
	}else if($Row["menu_id"]=="MNT14"){
		echo "VDOs";
	}else if($Row["menu_id"]=="MNT15"){
		echo "PR NEWS";
	}else if($Row["menu_id"]=="MNT16"){
		echo "TOP LIST";
}
?>	


 </td>
<td class="span1 text-center ">
<div class="btn-group">

<!--
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini" data-original-title="Edit"><i class="icon-eye-open"></i></a>

<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
-->

<a  _id="<?=$Row["content_id"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>
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
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/news';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	

		$input_content = SystemCheckInputToDB($_REQUEST["input_content"]);
		$input_name = SystemCheckInputToDB($_REQUEST["product_name"]);
	
		
		$insert="";
		$insert["site_code"] 			= "'S0001'";	
		
		$insert["cate_id"] 				= "'".trim($_REQUEST['cate_id'])."'";
		$insert["menu_id"] 				= "'".trim($_REQUEST['SysMenuID'])."'";
		
		
		$insert["name"] 			= "".$input_name."";
		
		$insert["content"] 			= "".$input_content."";
		
		
		
		
		
		if($input_fileIDOnePic!=""){
			$insert["filepic"] 			= "'".$store_physical_name."'";	
		}
		
		
		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		//$insert["createdate"] 			= "sysdate()";
		
		$insert["createdate"] 			= "'".SystemDateFormatDB(trim($_REQUEST['input_showdate']))."'";
		
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		
		$_order_by = SystemGetMaxOrder("article_main","menu_id='".$_REQUEST['SysMenuID']."'")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		$sql = "insert into article_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		$StoreID=$Conn->getInsertID();	
		
		$_REQUEST['ModuleDataID']=$StoreID;
		$statusHilight=$_REQUEST["statusHilight"];
		
		if($statusHilight=="Y"){
			$insert="";
			$insert["menu_id"] 			= "'".trim($_REQUEST['SysMenuID'])."'";
			$insert["content_id"] 		= "'".$_REQUEST['ModuleDataID']."'";
			$_order_by = SystemGetMaxOrder("hilight_main","")+1;
			$insert["order_by"] 			= "'".$_order_by."'";
			$sql = "insert into hilight_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);	
		}else{
			$sql = "delete from hilight_main where id = '".$_REQUEST['ModuleDataID']."'";
			$Conn->execute($sql);	
		}
		
		
		
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
				$insert["article_id"] 			= "'".$StoreID."'";
				$insert["file_name"] 			= "'".$_source_library["file_name"]."'";
				$insert["physical_name"] 		= "'".$store_physical_name."'";
				$insert["file_type"] 			= "'".$_source_library["file_type"]."'";
				$insert["file_size"] 			= "'".$_source_library["file_size"]."'";
				$insert["file_width"] 			= "'".$_source_library["file_width"]."'";
				$insert["file_height"] 			= "'".$_source_library["file_height"]."'";
				
				$insert["order_by"] 			= "'".$order_by."'";	
				
		
				
				$sql = "insert into article_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/news';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
		
			}
		}	
		}
		
		
		
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];
	
	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/news';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	$input_fileIDOnePicHome=$_REQUEST["input_fileIDOnePicHome"];
	
	if($input_fileIDOnePicHome!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePicHome."'");	
		$store_physical_namehome 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/news';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_namehome);
	
	}
	
	$input_content = SystemCheckInputToDB($_REQUEST["input_content"]);
	$input_name = SystemCheckInputToDB($_REQUEST["product_name"]);
	
	$update="";
	$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
	$update[] = "menu_id 		= '".trim($_REQUEST['SysMenuID'])."'";
	
	$update[] = "name 		= ".$input_name."";
	
	$update[] = "content 		= ".$input_content."";
	

	if($input_fileIDOnePic!=""){
		$update[] = "filepic 		= '".$store_physical_name."'";
	}
		
	
	
	$update[] = "flag_display 		= '".trim($_REQUEST['product_display'])."'";
	
	$update[] = "createdate 	= '".SystemDateFormatDB(trim($_REQUEST['input_showdate']))."'";
	
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	
	
	
	$sql = "update  article_main set ".implode(",",array_values($update)) ;
	$sql.=" where id = '".$_REQUEST['ModuleDataID']."'";	
	
	
	$Conn->execute($sql);
	
	
	
	
	$statusHilight=$_REQUEST["statusHilight"];
	
	if($statusHilight=="Y"){
		$insert="";
		$insert["menu_id"] 			= "'".trim($_REQUEST['SysMenuID'])."'";
		$insert["content_id"] 		= "'".$_REQUEST['ModuleDataID']."'";
		$_order_by = SystemGetMaxOrder("hilight_main","")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		$sql = "insert into hilight_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);	
	}else{
		$sql = "delete from hilight_main where id = '".$_REQUEST['ModuleDataID']."'";
		$Conn->execute($sql);	
	}
	
	

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
			$file_path_delete = _SYSTEM_UPLOADS_FOLDER_.'/news/'.$row_filestore["physical_name"];
			if (file_exists($file_path_delete)) {
				@unlink($file_path_delete);
			}
			$sql = "delete from article_file where id = '".$val."'";
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
				$insert["article_id"] 			= "'".$_REQUEST['ModuleDataID']."'";
				$insert["file_name"] 			= "'".$_source_library["file_name"]."'";
				$insert["physical_name"] 		= "'".$store_physical_name."'";
				$insert["file_type"] 			= "'".$_source_library["file_type"]."'";
				$insert["file_size"] 			= "'".$_source_library["file_size"]."'";
				
				$insert["file_width"] 			= "'".$_source_library["file_width"]."'";
				$insert["file_height"] 			= "'".$_source_library["file_height"]."'";
				
				$insert["order_by"] 			= "'".$order_by."'";
				
				
				
				$sql = "insert into article_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/news';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
			}else{
				$_file_val_id=str_replace("P","",$val);	
				$update="";
				$update[] = "order_by 		= '".$order_by."'";
				$sql = "update  article_file set ".implode(",",array_values($update)) ;
				$sql.=" where id = '".$_file_val_id."'";	
				$Conn->execute($sql);

				
			}
		}	
	}
	
	/*  ########################################################## */
	
	
	
	
?>



<? 
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "delete from hilight_main where content_id = '".$pid."'";
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
		$sql="UPDATE hilight_main SET ".implode(",",$update)." WHERE content_id='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>




<? 
}

?>