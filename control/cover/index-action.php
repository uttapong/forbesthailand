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
	if ($SysFSort=="") $SysFSort="p.id";
	if ($SysSort=="") $SysSort="desc";
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.*,c.name_".strtolower($_SESSION["LANG"])." as category_name,u.firstname,u.lastname FROM cover_main p";
	$sql.=" left join cover_category c on(c.cate_id=p.cate_id) ";
	$sql.=" left join sysuser u on(u.username=p.createby) ";
	$sql.= " WHERE 1=1 ";
	
	if($_SESSION['UserGroupCode']!='ADMIN'){		
		$sql.= " AND p.createby='".$_SESSION['UserID']."'";
	}
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name_th  like '%".$SysTextSearch."%' or p.name_en  like '%".$SysTextSearch."%' or  u.firstname  like '%".$SysTextSearch."%' ";
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

<select id="search_cateid" name="search_cateid" onchange="sysListCateIDSearch();" >
<option value="0" data-level="0" >-</option>
<? my_loadTreeCatSelect(0, $_REQUEST["SysCateID"]); ?>
</select> 

</div>
<div class="input-append">
<input type="text" id="input_search" name="input_search" value="<?=$SysTextSearch?>" class="input-medium"  placeholder="search..">
<button class="btn" onclick="sysListTextSearch();"><i class="icon-search"></i></button>
</div>
</div>

</div>
<? if($SysPMS=="MANAGE"){ ?>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>" class="btn btn-success" ><i class="icon-plus"></i> Add New Cover</a>
<!--
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=Sorting")?>" class="btn" ><i class="icon-list"></i> Sorting</a>
-->
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
<th <?=SysGetTitleSort('p.cate',$SysFSort,$SysSort)?> style="width: 200px; text-align:center;"    >Category</th>
<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 125px;" >Enable/Disable</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,200,200);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/cover/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td align="center" style="text-align:center;">
<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid">
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


<div>By : <?=$Row["firstname"]?> <?=$Row["lastname"]?> </div>
<div><i class="icon-eye-open"></i> : <?=$Row["cstate"]?></div>



</td>
<td align="center" style="text-align:center; ">
<?=$Row["category_name"]?>
</td>

<td class="span2" style="text-align:center;"> 
<? if($_SESSION['UserGroupCode']=="ADMIN" || $_SESSION['PUBLISH']=="Y"){ ?>
<a href="#" class="btn-status <? if($Row["flag_display"]!="Y"){?> dis <? } ?>" _did="<?=$Row["id"]?>" style=""><?=$source_status[$Row["flag_display"]]?></a>
<? }else{ ?>
<span class="lbl-approve  <? if($Row["flag_display"]!="Y"){?> dis <? } ?>"><?=$source_status[$Row["flag_display"]]?></span>
<? } ?>

<div style="padding-top:5px; margin-top:5px; border-top:1px solid #ddd;">
<? if($_SESSION['UserGroupCode']=="ADMIN"){ ?>
<a href="#" class="btn-approve <? if($Row["flag_approved"]!="Y"){?> dis <? } ?>" _did="<?=$Row["id"]?>" style=""><?=$source_approve[$Row["flag_approved"]]?></a>
<? }else{ ?>
<span class="lbl-approve  <? if($Row["flag_approved"]!="Y"){?> dis <? } ?>"><?=$source_approve[$Row["flag_approved"]]?></span>
<? } ?>
</div>

</td>
<td class="span1 text-center ">
<? if(SystemGetPermContent($Row["createby"])){ ?>
<div class="btn-group">
<a  class="btn btn-mini" target="_blank"  data-toggle="tooltip" title="Preview"  href="../../cover-preview.php?<?=SystemEncryptURL("ModuleDataID=".$Row["id"])?>"><i class="icon-eye-open"></i></a>
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>"  class="btn btn-mini btn-success"  data-toggle="tooltip" title="Edit" ><i class="icon-edit"></i></a>
<? if($_SESSION['UserGroupCode']=="ADMIN"){ ?>
<a  _id="<?=$Row["id"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="Delete" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-trash"></i></a>
<? } ?>
</div>
<? } ?>
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
			$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
			$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
			copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
			
			#Thumb
			$resizeObj 	= new ResizeImage($libraryFolder."/".$_source_library["physical_name"]);
			$resizeObj->resizeTo(290,290,'maxwidth');
			$resizeObj->saveImage(_SYSTEM_UPLOADS_FOLDER_."/cover_thumb/".$store_physical_name);
		
		}
		
		$input_fileIDOnePicContent=$_REQUEST["input_fileIDOnePicContent"];
		if($input_fileIDOnePicContent!=""){
			$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePicContent."'");	
			$store_physical_namecontent 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
			$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
			$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 	
			copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_namecontent);
		}
		
		
		$input_flag_media=$_REQUEST["input_flag_media"];
		$input_fileid_media=$_REQUEST["input_fileid_media"];
		if($input_flag_media=="UPLOADFILE" && $input_fileid_media!="" ){	
			$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type'),"id='".$input_fileid_media."'");	
			$media_file_name=$_source_library["file_name"];
			$media_file_size=$_source_library["file_size"];
			
			$media_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
			$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/media';  
			$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 	
			copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$media_physical_name);	
		}
	
			
	
		$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
		$input_name_th = SystemCheckInputToDB($_REQUEST["input_name_th"]);
		$input_keyword_th = SystemCheckInputToDB($_REQUEST["input_keyword_th"]);
		$input_issue_th = SystemCheckInputToDB($_REQUEST["input_issue_th"]);
			
		$input_name_en = SystemCheckInputToDB($_REQUEST["input_name_en"]);
		$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);
		$input_keyword_en = SystemCheckInputToDB($_REQUEST["input_keyword_en"]);
		$input_issue_en = SystemCheckInputToDB($_REQUEST["input_issue_en"]);
		
		$insert="";
		$insert["cate_id"] 				= "'".trim($_REQUEST['cate_id'])."'";
		
		$cid=$_REQUEST['cate_id'];
		$arrCate1=SystemGetMoreData("cover_category",array('name','name_th','level','parent_id'),"cate_id='$cid'");
		if($arrCate1['level']==1){	
			$cate_lel1=$cid;
		}else if($arrCate1['level']==2){
			$cate_lel1=$arrCate1['parent_id'];	
			$cate_lel2=$cid;		
		}else if($arrCate1['level']==3){
			$cate_lel3=$cid;
			$cate_lel2=$arrCate1['parent_id'];	
			$arrCate2=SystemGetMoreData("cover_category",array('name','level','parent_id'),"cate_id='".$arrCate1['parent_id']."'");	
			$cate_lel1=$arrCate2['parent_id'];		
		}
		$insert["cate1_id"] 				= "'".$cate_lel1."'";
		$insert["cate2_id"] 				= "'".$cate_lel2."'";
		$insert["cate3_id"] 				= "'".$cate_lel3."'";
		
		//$insert["menu_id"] 				= "'".trim($_REQUEST['SysMenuID'])."'";
		
		$insert["flag_display"] 				= "'".trim($_REQUEST['product_display'])."'";	
		$insert["flag_approved"] 				= "'N'";	
		
			
		$insert["flag_media"] 		= "'".$input_flag_media."'";
		$insert["embed_code"] 	= "'".trim($_REQUEST['input_embed_code'])."'";		
		$insert["filemedia_name"] 	= "'".$media_file_name."'";	
		$insert["filemedia_physical"] 	= "'".$media_physical_name."'";	
		$insert["filemedia_size"] 	= "'".$media_file_size."'";	
		
		$insert["issue_th"] 				= "".$input_issue_th."";
		$insert["name_th"] 				= "".$input_name_th."";
		$insert["content_th"] 			= "".$input_content_th."";
		$insert["keyword_th"] 			= "".$input_keyword_th."";
		
		$insert["issue_en"] 				= "".$input_issue_en."";
		$insert["name_en"] 				= "".$input_name_en."";
		$insert["content_en"] 			= "".$input_content_en."";
		$insert["keyword_en"] 			= "".$input_keyword_en."";
	
		if($input_fileIDOnePic!=""){
			$insert["filepic"] 			= "'".$store_physical_name."'";	
		}
		
		if($input_fileIDOnePicContent!=""){
			$insert["filepiccontent"] 			= "'".$store_physical_namecontent."'";	
		}
		
		
		$insert["dateshow1"] 			= "'".SystemDateFormatDB(trim($_REQUEST['input_date1']))."'";
		$insert["dateshow2"] 			= "'".SystemDateFormatDB(trim($_REQUEST['input_date2']))."'";
		
		
		//	$update[] = "approvedip 		= '".SystemGETIP()."'";
		
		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		$insert["createdate"] 			= "sysdate()";
		$insert["createip"] 			= "'".SystemGETIP()."'";
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		$insert["updateip"] 			= "'".SystemGETIP()."'";
		
		$_order_by = SystemGetMaxOrder("cover_main","menu_id='".$_REQUEST['SysMenuID']."'")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		$sql = "insert into cover_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		$StoreID=$Conn->getInsertID();	
		
		$_REQUEST['ModuleDataID']=$StoreID;
	
		
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
				
		
				
				$sql = "insert into cover_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
		
			}
		}	
		}
		
		if($_REQUEST["SysTypeSave"]=="3"){
			echo SystemEncryptURL("ModuleDataID=".$StoreID)."|X|".SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);
		}else{
			echo SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);
		}
		
		
		
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];
	
	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
		
				#Thumb
		$resizeObj 	= new ResizeImage($libraryFolder."/".$_source_library["physical_name"]);
		$resizeObj->resizeTo(290,290,'maxwidth');
		$resizeObj->saveImage(_SYSTEM_UPLOADS_FOLDER_."/cover_thumb/".$store_physical_name);
	}
	
	$input_fileIDOnePicContent=$_REQUEST["input_fileIDOnePicContent"];
	
	if($input_fileIDOnePicContent!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePicContent."'");	
		$store_physical_namecontent 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_namecontent);
	}
	
	
	$input_flag_media=$_REQUEST["input_flag_media"];
	$input_fileid_media=$_REQUEST["input_fileid_media"];	
	if($input_flag_media=="UPLOADFILE" && $input_fileid_media!="" ){
		
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type'),"id='".$input_fileid_media."'");	
		
		$media_file_name=$_source_library["file_name"];
		$media_file_size=$_source_library["file_size"];
		
		$media_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/media';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$media_physical_name);
		
	}
	
	

	$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
	$input_name_th = SystemCheckInputToDB($_REQUEST["input_name_th"]);
	$input_keyword_th = SystemCheckInputToDB($_REQUEST["input_keyword_th"]);
	$input_issue_th = SystemCheckInputToDB($_REQUEST["input_issue_th"]);
		
	$input_name_en = SystemCheckInputToDB($_REQUEST["input_name_en"]);
	$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);
	$input_keyword_en = SystemCheckInputToDB($_REQUEST["input_keyword_en"]);
	$input_issue_en = SystemCheckInputToDB($_REQUEST["input_issue_en"]);
	
	$update="";
	$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
		$cid=$_REQUEST['cate_id'];
	$arrCate1=SystemGetMoreData("cover_category",array('name','name_th','level','parent_id'),"cate_id='$cid'");
	if($arrCate1['level']==1){	
		$cate_lel1=$cid;
	}else if($arrCate1['level']==2){
		$cate_lel1=$arrCate1['parent_id'];	
		$cate_lel2=$cid;		
	}else if($arrCate1['level']==3){
		$cate_lel3=$cid;
		$cate_lel2=$arrCate1['parent_id'];	
		$arrCate2=SystemGetMoreData("cover_category",array('name','level','parent_id'),"cate_id='".$arrCate1['parent_id']."'");	
		$cate_lel1=$arrCate2['parent_id'];		
	}
	
	$update[] = "cate1_id 		= '".$cate_lel1."'";
	$update[] = "cate2_id 		= '".$cate_lel2."'";
	$update[] = "cate3_id 		= '".$cate_lel3."'";
	//$update[] = "menu_id 		= '".trim($_REQUEST['SysMenuID'])."'";
	$update[] = "embed_code 		= '".trim($_REQUEST['input_embed_code'])."'";
	
	$update[] = "issue_th 		= ".$input_issue_th."";
	$update[] = "name_th 		= ".$input_name_th."";
	$update[] = "content_th 		= ".$input_content_th."";
	$update[] = "keyword_th 		= ".$input_keyword_th."";
	
	$update[] = "issue_en 		= ".$input_issue_en."";
	$update[] = "name_en 		= ".$input_name_en."";
	$update[] = "content_en 		= ".$input_content_en."";
	$update[] = "keyword_en 		= ".$input_keyword_en."";
	
	

	if($input_fileIDOnePic!=""){
		$update[] = "filepic 		= '".$store_physical_name."'";
	}
	
	if($input_fileIDOnePicContent!=""){
		$update[] = "filepiccontent 		= '".$store_physical_namecontent."'";
	}
	
	$update[] = "flag_media 		= '".$input_flag_media."'";		
	if($input_flag_media=="UPLOADFILE" && $input_fileid_media!="" ){
		$update[] = "filemedia_name 		= '".$media_file_name."'";
		$update[] = "filemedia_physical 	= '".$media_physical_name."'";
		$update[] = "filemedia_size 		= '".$media_file_size."'";		
	}else if($input_flag_media=="EMBED"){
		$update[] = "embed_code 		= '".trim($_REQUEST['input_embed_code'])."'";	
	}
		
	
	$update[] = "dateshow1 	= '".SystemDateFormatDB(trim($_REQUEST['input_date1']))."'";
	$update[] = "dateshow2 	= '".SystemDateFormatDB(trim($_REQUEST['input_date2']))."'";
	
	
	$update[] = "flag_display 		= '".trim($_REQUEST['product_display'])."'";
	
	if($_REQUEST["flag_approved"]=="N"){
		$update[] = "flag_approved 		= 'N'";
		$update[] = "approvedby 		= ''";
		$update[] = "approveddate 		= ''";
		$update[] = "approvedip 		= ''";	
	}
	
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	$update[] = "updateip 		= '".SystemGETIP()."'";
	
	$sql = "update  cover_main set ".implode(",",array_values($update)) ;
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
			$file_path_delete = _SYSTEM_UPLOADS_FOLDER_.'/cover/'.$row_filestore["physical_name"];
			if (file_exists($file_path_delete)) {
				@unlink($file_path_delete);
			}
			$sql = "delete from cover_file where id = '".$val."'";
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
				
				
				
				$sql = "insert into cover_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
			}else{
				$_file_val_id=str_replace("P","",$val);	
				$update="";
				$update[] = "order_by 		= '".$order_by."'";
				$sql = "update  cover_file set ".implode(",",array_values($update)) ;
				$sql.=" where id = '".$_file_val_id."'";	
				$Conn->execute($sql);

				
			}
		}	
	}
	
	/*  ########################################################## */
	
		
	$StoreID=$_REQUEST['ModuleDataID'];
	if($_REQUEST["SysTypeSave"]=="3"){
			echo SystemEncryptURL("ModuleDataID=".$StoreID)."|X|".SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);
	}else{
		echo SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);
	}
	
	
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
		$sql="UPDATE cover_main SET ".implode(",",$update)." WHERE id='".$TmpArrID[$i]."' ";
	
		
		$Conn->execute($sql);
	
	}
?>



<? 
}else if ($ModuleAction == "DeleteData") {

$pid= $_REQUEST["id"];

$sql = "SELECT f.filepic FROM cover_main f";
$sql.= " WHERE f.id='".$pid."'";

$Conn->query($sql);
$ContentList = $Conn->getResult();	
$Row = $ContentList[0];	
$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/cover'; 
$physical_name=$Row["filepic"];

@unlink($libraryFolder."/".$physical_name);


$sql = "delete from cover_main where id = '".$pid."'";
$Conn->execute($sql);

?>


<?
}else if ($ModuleAction == "UpdateStatus") {
	
	$did=$_REQUEST["did"];
	$status=$_REQUEST["status"];	
	$update="";
	$update[]="flag_display='".$status."'";
	$sql="UPDATE cover_main SET ".implode(",",$update)." WHERE id='".$did."' ";
	$Conn->execute($sql);
	
	echo $source_status[$status];	
?>

<?
}else if ($ModuleAction == "UpdateApprove") {
	
	$did=$_REQUEST["did"];
	$status=$_REQUEST["status"];
	$update="";
	
	if($status=='Y'){	
		$update[]="flag_approved='".$status."'";
		$update[] = "approvedby 		= '".$_SESSION['UserID']."'";
		$update[] = "approveddate 		= sysdate()";
		$update[] = "approvedip 		= '".SystemGETIP()."'";
	}else{
		$update[]="flag_approved='".$status."'";
		$update[] = "approvedby 		= ''";
		$update[] = "approveddate 		= ''";
		$update[] = "approvedip 		= ''";	
	}
	

	$sql="UPDATE cover_main SET ".implode(",",$update)." WHERE id='".$did."' ";
	$Conn->execute($sql);
	
	echo $source_approve[$status];	
?>



<? 
}

?>