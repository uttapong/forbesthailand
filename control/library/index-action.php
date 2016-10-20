<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
}else{
	if($_REQUEST['ModuleAction']!=""){
		$ModuleAction = $_REQUEST['ModuleAction'];
		$SysMenuID=$_POST["SysMenuID"];
		$ModuleDataID = $_REQUEST['ModuleDataID'];
	}	
}
?>


<? function libraryGetShowPhoto($file_id,$file_list){ ?>
<?
	global $Conn;	
	
	
	$_group_file=substr($file_id,0,1);
	
	
	
	
	if($_group_file=="L"){
		
		$sql = " SELECT * FROM library_file ";
		$sql.= " WHERE  concat('L',id)='".$file_id."'";
		
		$pathPhoto=_SYSTEM_UPLOADS_FOLDER_."/library/";
	}
	
	if($_group_file=="P"){
		
		$sql = " SELECT * FROM store_file ";
		$sql.= " WHERE  concat('P',id)='".$file_id."'";
		$pathPhoto=_SYSTEM_UPLOADS_FOLDER_."/store/";
	}
	

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	
	
	$physical_name=$pathPhoto.$Row["physical_name"];
	
	$file_array=explode("-",$file_list);
	
	$max_file=count($file_array);
	
	$file_key=array_keys($file_array,$file_id);
	$file_key=$file_key[0];
	
	$id_left= $file_array[$file_key-1];
	$id_right= $file_array[$file_key+1];
	
	
	
?>

<div class="row-fluid">
<div class="span1"  style="height:55px;  margin-top:200px; ">
<? if($file_key>0){?>
<a  class="arow_photo_left" href="javascript:library_getphoto('<?=$id_left?>','<?=$file_list?>')" style="" ></a>
<? } ?>
</div>

<div class="span10" style="text-align:center;"> 
    <div id="s_<?=$file_id?>" style="width:600px; height:490px; margin:auto; padding:0; overflow:hidden;">
     <img  alt="<?=$Row["file_name"]?>" src="<?=$physical_name?>" >
    </div>
</div>

<div class="span1" style="height:55px; margin-top:200px;"> 
<? if(($max_file-1)>$file_key){?>
<a  class="arow_photo_right" href="javascript:library_getphoto('<?=$id_right?>','<?=$file_list?>')" style="" ></a>
<? } ?>
</div>
</div>
<span id="area_file_key" style="display:none;"><?=($file_key+1)?></span>

<? } ?>


<?
if ($ModuleAction == "Datalist") {
	if(!$Page){
		$Page=$_REQUEST["SysPage"];
	}
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["SysTextSearch"]);
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT l.*,c.cate_name FROM library_file l";
	$sql.=" left join library_folder c on(c.cate_id=l.cate_id) ";
	$sql.= " WHERE 1=1 ";
	$sql.= " ORDER BY l.id DESC";
	
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

<? echo $_REQUEST["SysCateID"]; ?>

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
<th class="span1 text-center hidden-phone " >#</th>
<th style="width:110px;">&nbsp;</th>
<th  > รายละเอียด</th>
<th class="span1 text-center sorting_disabled" style="width:30px;"><i class="icon-bolt"></i></th></tr>
</thead>

<tbody >

<?

	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$resize=SystemResizeImgAuto($Row["file_width"],$Row["file_height"],100,100);
	$physical_name=_SYSTEM_HOST_NAME_."/uploads/library/".$Row["physical_name"];
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td ><img src="<?=$physical_name?>" data-src="../js/holder.js/100x100" width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid"></td>
<td class="" valign="top" style="vertical-align:top" >

<div><i class="icon-picture"></i> <?=$Row["file_name"]?></div>
<div><i class="icon-folder-open"></i> <?=$Row["cate_name"]?></div>
<div><i class="icon-fullscreen"></i> กว้าง <?=$Row["file_width"]?>px สูง <?=$Row["file_height"]?>px </div>
<div><i class="icon-calendar"></i></div>
<div><i class="icon-random"></i> <input class="input_hilight" value="<?=$physical_name?>"  /></div>

</td>
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
}else if ($ModuleAction == "getLibraryList") {
	
	$Mod_Type=$_REQUEST["Mod_Type"];
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE 1=1 ";
	
	if($Mod_Type=="IMG"){
		$sql.=" AND (file_type='jpg' or file_type='jpeg' or file_type='png' or file_type='bmp' )";	
	}
	
	$sql.= " ORDER BY id ASC";
	 
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	
	$inputFileSelect=$_REQUEST["inputFileSelect"];
	
	$ObjUFileID=$_REQUEST["ObjUFileID"];
	
	?>
    <div style="height:360px; overflow:auto;">
    <form class="dropzone dz-started"> 
    <?
	
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		
		if(SystemCheckFileImage($Row["file_type"])){
			$physical_name=_SYSTEM_UPLOADS_FOLDER_."/library/".$Row["physical_name"];
		}else{
			$physical_name='../images/icon-file.png';
		}
		
		$filesize=SystemSizeFilter($Row["file_size"]);
		
		 if(@in_array($Row["id"],$inputFileSelect)){
			 $_dz_success="dz-success";
		 }else{
			  $_dz_success="";
		 }	
		?>
        <div class="dz-preview dz-image-preview <?=$_dz_success?>" onclick="SelectLibralyImg<?=$ObjUFileID?>(this)" id="t_<?=$Row["id"]?>">   
        <div class="dz-details"><div class="dz-filename"><span ><?=$Row["file_name"]?></span></div>    
        <div class="dz-size" data-dz-size=""><?=$filesize?></div> <img data-dz-thumbnail="" alt="<?=$Row["file_name"]?>" src="<?=$physical_name?>">  </div>    
        <div class="dz-success-mark"><span>✔</span></div>    </div>
        <?
	}
?>
</form>
</div>

<? 
}else if ($ModuleAction == "getFileUploadEditor") {
	
	$file_id=$_REQUEST["file_id"];
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE  id='".$file_id."'";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	echo _SYSTEM_HOST_NAME_."/uploads/library/".$Row["physical_name"];
?>
<? 
}else if ($ModuleAction == "getFileUploadOne") {
	
	$file_id=$_REQUEST["file_id"];
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE  id='".$file_id."'";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	
	$returnArray[error] = "true";
	$returnArray[file_id] =  $file_id;
	$returnArray[physical_name] =  $Row["physical_name"];
	echo json_encode($returnArray);
	exit;

	
?>
<? 
}else if ($ModuleAction == "DeleteData") {

$file_id= $_REQUEST["id"];

$sql = "SELECT l.* FROM library_file l";
$sql.= " WHERE l.id='".$file_id."'";

//echo $sql

$Conn->query($sql,$Page,$PageSize);
$ContentList = $Conn->getResult();
$physical_name= $ContentList[0]["physical_name"];
$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/library'; 

//unlink($libraryFolder."/".$physical_name);
$sql = "delete from library_file where id = '".$file_id."'";
$Conn->execute($sql);

?>


<? 
}else if ($ModuleAction == "getFileUploadAll") {
	
	$file_id=$_REQUEST["file_id"];
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE  id='".$file_id."'";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	$physical_name=_SYSTEM_UPLOADS_FOLDER_."/library/".$Row["physical_name"];
?>

<div id="s_<?=$file_id?>" style="width:50px; height:50px; float:left; margin:4px; background-color:#404040; padding:2px; overflow:hidden;">
<input type="hidden" name="inputFileSelect[]" value="<?=$file_id?>" />
 <img  alt="<?=$Row["file_name"]?>" src="../images/icon-file.png" >
</div>

<? 
}else if ($ModuleAction == "getFileUpload") {
	
	$file_id=$_REQUEST["file_id"];
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE  id='".$file_id."'";

	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$Row=$ContentList[0];
	$physical_name=_SYSTEM_UPLOADS_FOLDER_."/library/".$Row["physical_name"];
?>

<div id="s_<?=$file_id?>" style="width:50px; height:50px; float:left; margin:4px; background-color:#404040; padding:2px; overflow:hidden;">
<input type="hidden" name="inputFileSelect[]" value="<?=$file_id?>" />
 <img  alt="<?=$Row["file_name"]?>" src="<?=$physical_name?>" >
</div>

<? 
}else if ($ModuleAction == "feedFileUpload") {

$inputFileSelect=$_REQUEST["inputFileSelect"];

if(is_array($inputFileSelect)){
	$filelist_id= "'".implode("','",$inputFileSelect)."'";
	
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE id in($filelist_id) ";
	$sql.= " ORDER BY id ASC";
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
		
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		$physical_name=_SYSTEM_UPLOADS_FOLDER_."/library/".$Row["physical_name"];
		$filesize=SystemSizeFilter($Row["file_size"]);
		?>
        <li class="boxli_file_photo" id="L<?=$Row["id"]?>" >
        <div class="file_photo_desc">
        <div class="delete" onclick="library_remove_photo(this);">นำออก</div>
          <div class="view ">
          <a  class="btn_photo_view"  data-toggle="modal" href="../library/index-action.php?<?=SystemEncryptURL("ModuleAction=showPhoto&file_id=L".$Row["id"])?>"> ดูภาพขยาย </a>
          </div>
        </div>
         <img  alt="<?=$Row["file_name"]?>" src="<?=$physical_name?>" >
        </li>
<?	
	}	
}
?>

<? 
}else if ($ModuleAction == "feedFileUploadAll") {

$inputFileSelect=$_REQUEST["inputFileSelect"];

if(is_array($inputFileSelect)){
	$filelist_id= "'".implode("','",$inputFileSelect)."'";
	
	$sql = "SELECT * FROM library_file ";
	$sql.= " WHERE id in($filelist_id) ";
	$sql.= " ORDER BY id ASC";
	#echo $sql;
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
		
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		$physical_name=_SYSTEM_UPLOADS_FOLDER_."/library/".$Row["physical_name"];
		$filesize=SystemSizeFilter($Row["file_size"]);
		?>
        <li class="boxli_file_all" id="L<?=$Row["id"]?>" >
        <div>
        <div class="file-name" >
		<input type="text" name="L<?=$Row["id"]?>_Fname" value="<?=$Row["file_name"]?>" />     
        </div>
        <div style="float:left; width:48px;"  class="btn btn-danger delete" onclick="library_remove_file(this);">นำออก</div>
      </div>
        </li>
<?	
	}	
}
?>


<? 
}else if ($ModuleAction == "getPhoto") { 
$file_id=$_REQUEST["file_id"];
$file_list=$_REQUEST["file_list"];

libraryGetShowPhoto($file_id,$file_list);

?>
<? 
}else if ($ModuleAction == "showPhoto") { 
?>

<style>
.modal_h{
	height:490px!important;
}

a.arow_photo_left{
	display:inline-block;
	background:url(../images/arrow_big_left.png) no-repeat; margin-left:10px; margin-top:10px; width:30px; height:50px;
}

a.arow_photo_right{
	display:inline-block;
	background:url(../images/arrow_big_right.png) no-repeat; margin-left:38px; margin-top:10px; width:30px; height:50px;
}

</style>
    <div class="modal-form">
<br />

<div class="modal_h" style="">
<div id="area_show_photo">
<?
$file_id;
$file_list= substr($_REQUEST["file_list"],0,strlen($_REQUEST["file_list"])-1);
libraryGetShowPhoto($file_id,$file_list);
$file_array=explode("-",$file_list);
$max_file=count($file_array);

$file_key=array_keys($file_array,$file_id);
$file_key=$file_key[0];

?>
</div>
</div>

<div class="modal-footer">
<div class="row-fluid">
<div class="span11" style="text-align:center;font-size:24px!important;">

<b>รูปที่ <span id="area_text_photo"><?=($file_key+1)?></span> </b>
( จากทั้งหมด <?=$max_file?> รูป )

</div>
<div class="span1"><a class="btn" onclick="sys_modal_close();">Close</a></div>
</div>
	
</div>
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