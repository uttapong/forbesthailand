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
	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.order_by";
	if ($SysSort=="") $SysSort="asc";
	
	
	$SysCateID=$_REQUEST["SysCateID"];
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.* FROM ads_main p";
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
<? if($SysMenuID!="SADST05"){ ?>
<select id="search_cateid" name="search_cateid" onchange="sysListCateIDSearch();" >
<option value="0" data-level="0" >-</option>
<?=SystemArraySelect($sourceAdsMenu,$_REQUEST["SysCateID"]); ?>
</select> 
<? } ?>
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

<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   >Subject</th>
<? 	if($SysMenuID!="SADST04" && $SysMenuID!="SADST05" && $SysMenuID!="SADSE04" && $SysMenuID!="SADSE05" ){ ?>
<th style="width:200px;" >Menu ads</th>
<? } ?>
<th  style="text-align:center;width:80px;"  >Stat</th>

<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 80px; text-align:center;" >Enable/<br />Disable</th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,200,200);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/ads/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	if($SysMenuID=="SADST05"){
		$resize[0]="107";
		
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>

<td class="" valign="top" >

<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" style="width:97%" class="img-polaroid">
<br />
<br />



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
<? 	if($SysMenuID!="SADST04" && $SysMenuID!="SADST05" && $SysMenuID!="SADSE04" && $SysMenuID!="SADSE05" ){ ?>
<td class="" valign="top" style="font-size:12px;" >
<?
	$sql = "SELECT  *  FROM ads_menu a ";
	$sql.= "WHERE  a.ads_id='".$Row["id"]."'";
	$sql.= " ORDER BY a.order_by asc";		
	$Conn->query($sql);
	$AdsList = $Conn->getResult();
	$CntRecAds = $Conn->getRowCount();
	$checkAdsMenu="";
	for ($j=0;$j<$CntRecAds;$j++) {
		$RowAds = $AdsList[$j];
		echo $sourceAdsMenu[$RowAds["menu_code"]]."<br>";
	}
?>
</td>
<? } ?>
<td class="" style="text-align:center"   valign="top"  >
<a target="_blank" href="stat.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" class="btn btn-mini btn-success" title="Stat">
<span style="font-weight:bold; color:#; font-size:18px;"><?=$Row["cread"]?></span>
</a>
</td>
<td class="span2" style="text-align:center;" ><a href="#" class="btn-status <? if($Row["flag_display"]!="Y"){?> dis <? } ?>" _did="<?=$Row["id"]?>" style=""><?=$source_status[$Row["flag_display"]]?></a> </td>
<td class="span1 text-center ">
<div class="btn-group">
<a href="export.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip"  target="_blank"  class="btn btn-mini btn-success" title="Export statistic to excel.">Export</a>

<!--
<a class="btn_view_stat btn btn-mini btn-success" data-toggle="modal" iframe="true" href="../ads/stat.php?<?=trim("ModuleAction=showState&ModuleDataID=".$Row["id"])?>"> View </a>
-->
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
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	$input_fileIDOnePicContent=$_REQUEST["input_fileIDOnePicContent"];
		if($input_fileIDOnePicContent!=""){
			$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePicContent."'");	
			$store_physical_namecontent 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
			$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/article';  
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
		
		$input_flashid_media=$_REQUEST["input_flashid_media"];
		if($input_flashid_media!=""){
			$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_flashid_media."'");
			
			$flash_file_name=$_source_library["file_name"];
			$flash_file_size=$_source_library["file_size"];
			
			$store_physical_flashname 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
			$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
			$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 	
			copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_flashname);	
		}
	
		$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
		$input_name_th = SystemCheckInputToDB($_REQUEST["input_name_th"]);
		$input_keyword_th = SystemCheckInputToDB($_REQUEST["input_keyword_th"]);
		
		$input_name_en = SystemCheckInputToDB($_REQUEST["input_name_en"]);
		$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);
		$input_keyword_en = SystemCheckInputToDB($_REQUEST["input_keyword_en"]);
	
		
		$insert="";
		$insert["site_code"] 			= "'S0001'";	
		
		$insert["cate_id"] 				= "'".trim($_REQUEST['cate_id'])."'";
		$insert["menu_id"] 				= "'".trim($_REQUEST['SysMenuID'])."'";
		
		$insert["url"] 				= "'".trim($_REQUEST['input_url'])."'";
		$insert["flag_display"] 				= "'".trim($_REQUEST['product_display'])."'";	
		
		$insert["name_th"] 				= "".$input_name_th."";
		$insert["content_th"] 			= "".$input_content_th."";
		$insert["keyword_th"] 			= "".$input_keyword_th."";
		
		$insert["name_en"] 				= "".$input_name_en."";
		$insert["content_en"] 			= "".$input_content_en."";
		$insert["keyword_en"] 			= "".$input_keyword_en."";
		
		
		$insert["flag_media"] 		= "'".$input_flag_media."'";
		$insert["embed_code"] 	= "'".trim($_REQUEST['input_embed_code'])."'";		
		$insert["filemedia_name"] 	= "'".$media_file_name."'";	
		$insert["filemedia_physical"] 	= "'".$media_physical_name."'";	
		$insert["filemedia_size"] 	= "'".$media_file_size."'";	
	

		
		if($input_fileIDOnePic!=""){
			$insert["filepic"] 			= "'".$store_physical_name."'";	
		}
		if($input_fileIDOnePicContent!=""){
			$insert["filepiccontent"] 			= "'".$store_physical_namecontent."'";	
		}
		
		
		$insert["flag_flash"] 	= "'".trim($_REQUEST['input_flash_banner'])."'";	
		if($input_flashid_media!=""){
			$insert["flashmedia_name"] 	= "'".$flash_file_name."'";	
			$insert["flashmedia_physical"] 	= "'".$store_physical_flashname."'";	
			$insert["flashmedia_size"] 	= "'".$flash_file_size."'";	
		}
		
		
		$insert["dateshow1"] 			= "'".SystemDateFormatDB(trim($_REQUEST['input_date1']))."'";
		$insert["dateshow2"] 			= "'".SystemDateFormatDB(trim($_REQUEST['input_date2']))."'";
		
		
		$insert["createby"] 			= "'".$_SESSION['UserID']."'";
		$insert["createdate"] 			= "sysdate()";		
		$insert["updateby"] 			= "'".$_SESSION['UserID']."'";
		$insert["updatedate"] 			= "sysdate()";
		
		$_order_by = SystemGetMaxOrder("ads_main","menu_id='".$_REQUEST['SysMenuID']."'")+1;
		$insert["order_by"] 			= "'".$_order_by."'";
		
		
		$sql = "insert into ads_main(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		$Conn->execute($sql);
		$StoreID=$Conn->getInsertID();
		
		
		$inputAdsMenu=$_REQUEST["inputAdsMenu"];	
		if(is_array($inputAdsMenu)){
			$order_by=0;
			foreach($inputAdsMenu as $val){
				$order_by++;
				$insert="";
				$insert["ads_id"] 		= "'".$StoreID."'";
				$insert["menu_code"] 			= "'".$val."'";
				$insert["order_by"] 			= "'".$order_by."'";
				$sql = "insert into ads_menu(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
			}
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
				
		
				
				$sql = "insert into ads_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
		
			}
		}	
		}
	echo SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&ModuleDataID=".$StoreID);		
		
		
?>

<? 
}else if ($ModuleAction == "UpdateData") {
	
	$input_fileIDOnePic=$_REQUEST["input_fileIDOnePic"];
	
	if($input_fileIDOnePic!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePic."'");	
		$store_physical_name 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
		
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
	
	}
	
	$input_fileIDOnePicContent=$_REQUEST["input_fileIDOnePicContent"];
	if($input_fileIDOnePicContent!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_fileIDOnePicContent."'");	
		$store_physical_namecontent 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
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
			
	
	
	$input_flashid_media=$_REQUEST["input_flashid_media"];
	if($input_flashid_media!=""){
		$_source_library=SystemGetMoreData("library_file",array('file_name','physical_name','file_type','file_size','file_type','file_width','file_height'),"id='".$input_flashid_media."'");
		
		$flash_file_name=$_source_library["file_name"];
		$flash_file_size=$_source_library["file_size"];
		
		$store_physical_flashname 	= md5($_source_library["file_name"].date("His").rand(1,1000)).".".$_source_library["file_type"];
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 	
		copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_flashname);	
	}

	
	$input_content = SystemCheckInputToDB($_REQUEST["input_content"]);
	$input_name = SystemCheckInputToDB($_REQUEST["product_name"]);
	
	$input_content_th = SystemCheckInputToDB($_REQUEST["input_content_th"]);
	$input_name_th = SystemCheckInputToDB($_REQUEST["input_name_th"]);
	$input_keyword_th = SystemCheckInputToDB($_REQUEST["input_keyword_th"]);
		
	$input_name_en = SystemCheckInputToDB($_REQUEST["input_name_en"]);
	$input_content_en = SystemCheckInputToDB($_REQUEST["input_content_en"]);
	$input_keyword_en = SystemCheckInputToDB($_REQUEST["input_keyword_en"]);
	
	
	$update="";
	$update[] = "cate_id 		= '".trim($_REQUEST['cate_id'])."'";
	$update[] = "menu_id 		= '".trim($_REQUEST['SysMenuID'])."'";	
	$update[] = "name 		= ".$input_name."";
	$update[] = "url 		= ".SystemCheckInputToDB($_REQUEST['input_url'])."";
	

	$update[] = "name_th 		= ".$input_name_th."";
	$update[] = "content_th 		= ".$input_content_th."";
	$update[] = "keyword_th 		= ".$input_keyword_th."";
	
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
	
	$update[] = "flag_flash 		= '".trim($_REQUEST['input_flash_banner'])."'";	
	if($input_flashid_media!=""){
		$update[] = "flashmedia_name 		= '".$flash_file_name."'";
		$update[] = "flashmedia_physical 		= '".$store_physical_flashname."'";
		$update[] = "flashmedia_size 		= '".$flash_file_size."'";	
	}
	
	
	$update[] = "dateshow1 	= '".SystemDateFormatDB(trim($_REQUEST['input_date1']))."'";
	$update[] = "dateshow2 	= '".SystemDateFormatDB(trim($_REQUEST['input_date2']))."'";
	
	$update[] = "flag_display 		= '".trim($_REQUEST['product_display'])."'";
	
	$update[] = "createdate 	= '".SystemDateFormatDB(trim($_REQUEST['input_showdate']))."'";
	
	$update[] = "updateby 		= '".$_SESSION['UserID']."'";
	$update[] = "updatedate 		= sysdate()";
	
	
	
	$sql = "update  ads_main set ".implode(",",array_values($update)) ;
	$sql.=" where id = '".$_REQUEST['ModuleDataID']."'";	
	
	
	$Conn->execute($sql);
	
	
	
	
	
	$inputAdsMenu=$_REQUEST["inputAdsMenu"];	
	$sql = "delete from ads_menu where ads_id = '".$_REQUEST['ModuleDataID']."'";
	$Conn->execute($sql);		
	if(is_array($inputAdsMenu)){
		$order_by=0;
		foreach($inputAdsMenu as $val){
			$order_by++;
			$insert="";
			$insert["ads_id"] 		= "'".$_REQUEST['ModuleDataID']."'";
			$insert["menu_code"] 			= "'".$val."'";
			$insert["order_by"] 			= "'".$order_by."'";
			$sql = "insert into ads_menu(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
			$Conn->execute($sql);
		}
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
			$file_path_delete = _SYSTEM_UPLOADS_FOLDER_.'/ads/'.$row_filestore["physical_name"];
			if (file_exists($file_path_delete)) {
				@unlink($file_path_delete);
			}
			$sql = "delete from ads_file where id = '".$val."'";
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
				
				
				
				$sql = "insert into ads_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				$Conn->execute($sql);
				$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/ads';  
				$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 
				
				copy($libraryFolder."/".$_source_library["physical_name"],$storeFolder."/".$store_physical_name);
			}else{
				$_file_val_id=str_replace("P","",$val);	
				$update="";
				$update[] = "order_by 		= '".$order_by."'";
				$sql = "update  ads_file set ".implode(",",array_values($update)) ;
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