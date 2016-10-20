<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ckeditor/ckeditor.js');
if ($ModuleAction=="") $ModuleAction="Datalist";

?>
<? require("../inc/inc-mainfile.php");?>
<body >
<div id="page-container">
<? require("../inc/inc-web-head.php");?>
<div id="inner-container"  >
<? require("../inc/inc-web-menu.php");?>
<div style="min-height: 726px;" id="page-content"  >
<? require("../inc/inc-web-navigator.php");?>

<?
$ModuleAction = "EditForm";
?>

<? if ($ModuleAction == "AddForm" || $ModuleAction == "EditForm") { ?>

<?
if($ModuleAction == "AddForm"){
	$lbl_tab=_Add_." ".$_sourceMaster["name"];
	$ModuleAction_Current="InsertNewData";
	$v_status=1;
	
	$Row["site_code"]=$_SESSION["SITE_CODE"];
	
}else{
	
	
}
?>

<form id="frm" name="frm"  method="post" class="form-horizontal" onSubmit="return false;">
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
<input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemGetReturnURL()?>"/>
<div class="clearfix">
<!--
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
-->
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>
<div class="line-control-header"></div>
</div>


<?


$editor_id[1]="Suthasinee_j"; // สุทธาสินี จิตรกรรมไทย 
$editor_id[2]="bamrung_a"; // บำรุง
$editor_id[3]="chayanit_d"; // ชญานิจฉ์
$editor_id[4]="nakrarin_p"; // นครินทร์
$editor_id[5]="nopporn_w"; // นพพร
$editor_id[6]="pronpan_p"; // พรพรรณ
$editor_id[7]="thai_staff"; // FORBES THAILAND STAFF 
$editor_id[8]="editor01"; // เสาวรส
$editor_id[10]="guest_f"; // นักเขียนรับเชิญ
$editor_id[11]="thai_staff"; // FORBES THAILAND STAFF 
$editor_id[12]="niti_t"; // นิธิ ท้วมประถม
$editor_id[13]="editor02"; // วีระศักดิ์ โควสุรัตน์
$editor_id[14]="editor03"; // BUSEM (School of Entrepreneurship and Management, Bangkok University)
$editor_id[15]="kampanath_k"; // กัมปนาท กาญจนาคาร
$editor_id[16]="sriwipa_s"; // ศรีวิภา สิริปัญญาวิทย์
$editor_id[17]="banjarong_s"; // ดร.เบญจรงค์ สุวรรณคีรี
$editor_id[18]="kritiya_w"; // กฤติยา วงศ์เทววิมาน
$editor_id[19]="editor04"; // กิติชัย เตชะงามเลิศ
?>


<?

	if(!$Page){
		$Page=$_REQUEST["SysPage"];
	}
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["SysTextSearch"]);
	$SysCateID=$_REQUEST["SysCateID"];
	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.article_id";
	if ($SysSort=="") $SysSort="desc";
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=20;
	
	//$flag_import="UPDATE";
	$flag_import="NEW";
	//$flag_import="UPDATE_ALL";
	
	//$cid_old=8; // NEWS
	$SysMenuID="MNT03";// NEW
	$cid=3; // NEWS => THAILAND
	$cid_old=8;
	
	
	/*
	// ENTREPRENEURS 
	$SysMenuID="MNT05";
	$cid_old=3;
	
	//COMMENTARIES
	$SysMenuID="MNT10";
	$cid_old=7;
	
	//TECHNOLOGY
	$SysMenuID="MNT09";
	$cid_old=5;
	
	
	//LIFE
	$SysMenuID="MNT08";
	$cid_old=4;
	
	
	//ASIAN BIZ
	$SysMenuID="MNT06";
	$cid_old=6;
	$subcid_old=13;
	
	//WORLD
	$SysMenuID="MNT07";
	$cid_old=6;
	$subcid_old="";
	
	//PEOPLE
	$SysMenuID="MNT04";
	$cid_old=1;
	*/
	
	
	
	if($flag_import=="NEW"){
	

	$sql = "SELECT p.* FROM  event_image p";
	$sql.= " WHERE 1=1 ";
	

	
	//$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	
	//$Conn->query($sql,$Page,$PageSize);
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	
	$Event_ID[3]=973;
	$Event_ID[4]=974;
	$Event_ID[5]=975;
	$Event_ID[6]=976;
	$Event_ID[7]=977;
	$Event_ID[8]=978;
	$Event_ID[9]=979;
	$Event_ID[10]=980;
	$Event_ID[11]=981;
	$Event_ID[12]=982;
	
	exit();
	
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		$physical_name="../../uploads/images/".$Row["article_image"];
		
		if (!(is_file($physical_name) && file_exists($physical_name) )) {
			$physical_name="../img/photo_not_available.jpg";
		}
		
		
		$insert="";
		//$insert["id"] 				= "'".$Row["article_image_id"]."'";
	
		
		
		$insert["article_id"] 		= "'".$Event_ID[$Row["event_id"]]."'";
		
		$insert["file_name"] 		= "'".$Row["event_image_large"]."'";
		$insert["physical_name"] 	= "'".$Row["event_image_large"]."'";
		$extension 	= 	strtolower(strrchr($Row["event_image_large"], '.'));
		$insert["file_type"] 		= "'".str_replace(".","",$extension)."'";
		
	
	
		$storeFolder = _SYSTEM_UPLOADS_FOLDER_.'/article';  
		$libraryFolder = _SYSTEM_UPLOADS_FOLDER_.'/images'; 
	
	 
		@copy($libraryFolder."/".$Row['event_image_large'],$storeFolder."/".$Row['event_image_large']);
		
		$physical_name=$libraryFolder."/".$Row['event_image_large'];
		
		if ((is_file($physical_name) && file_exists($physical_name) && trim($Row['event_image_large'])!=''  )) {
			$resizeObj 	= new ResizeImage($libraryFolder."/".$Row['event_image_large']);
			$resizeObj->resizeTo(290,290,'maxwidth');
			$resizeObj->saveImage(_SYSTEM_UPLOADS_FOLDER_."/article_thumb/".$Row['event_image_large']);
			
		}
 /*	*/
		
		
		$sql = "insert into article_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
		
		//echo $sql;
		echo $Row["event_image_id"]."<br>";
		
		$Conn->execute($sql);
	
	
	
	}
	
	}else if($flag_import=="UPDATE"){
		
	$sql = "SELECT p.* FROM article_main p";
	$sql.= " WHERE p.menu_id='".$SysMenuID."'";
	

	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row = $ContentList[$i];
		$update="";
		$update[] = "cate_id 		= '".$cid."'";
		$update[] = "cate1_id 		= '".$cid."'";
		$sql = "update  article_main set ".implode(",",array_values($update)) ;
		$sql.=" where id = '".$Row['id']."'";	
		
		//$Conn->execute($sql);
	
	}
	
	
	}else if($flag_import=="UPDATE_ALL"){
	
		$update="";
		$update[] = "approvedby 		= 'Suthasinee_j' ";
		$sql = "update  article_main set ".implode(",",array_values($update)) ;
		$sql.=" where approvedby = 'Suthasinee_ j'";	
	
		//$Conn->execute($sql);
		
		//echo $sql;
	}
	
	
	
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


</div>

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
<th  style="width:150px;">&nbsp;</th>
<th <?=SysGetTitleSort('p.name',$SysFSort,$SysSort)?>   >Subject</th>

<th <?=SysGetTitleSort('p.flag_display',$SysFSort,$SysSort)?> style="width: 125px;" >Editor ID </th>
<th  style="width: 46px; text-align:center;"><i class="icon-fire" ></i></th></tr>
</thead>

<tbody >

<?

	if(!$Page){
		$Page=$_REQUEST["SysPage"];
	}
	$PageSize=$_REQUEST["SysPageSize"];
	$SysTextSearch=trim($_REQUEST["SysTextSearch"]);
	$SysCateID=$_REQUEST["SysCateID"];
	
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.article_id";
	if ($SysSort=="") $SysSort="desc";
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=20;
	
	
	$sql = "SELECT p.* FROM article p";
	$sql.= " WHERE p.category_id='8'";
	
	
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

$CntRecInPage=0;
 	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/images/".$Row["article_image"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	
	
?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td>
<!--
<img src=<?=$physical_name?>  width="<?=$resize[0]?>" height="<?=$resize[1]?>" class="img-polaroid">
-->

</td>
<td class="" valign="top" >
<?=$Row["article_title"]?>
</td>
<td class="span2" style="text-align:center;" ><?=$Row["editor_id"]?></td>
<td class="span1 text-center ">
<div class="btn-group">


<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini" data-original-title="Edit"><i class="icon-eye-open"></i></a>

<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID&Page=$Page&ModuleDataID=".$Row["id"])?>" data-toggle="tooltip" title="" class="btn btn-mini btn-success" data-original-title="Edit"><i class="icon-pencil"></i></a>
<a  _id="<?=$Row["id"]?>"  href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-remove"></i></a>
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




<div class="clearfix">
<div class="line-control-footer"></div>
<!--
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
-->
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>

</div>

</form>

<? }else{ ?>

<div class="clearfix">
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID")?>" class="btn btn-success" ><i class="icon-plus"></i> Edit</a>
<div class="line-control-header"></div>
</div>
<div id="content_html" style="min-height:300px; margin-top:10px; display:none;">

</div>
<iframe id="iframe" src="content.php?SysMenuID=<?=$SysMenuID?>" width="920" height="600" scrolling="yes" frameborder="0"></iframe>


<script>





$(document).ready(function () {
  
     //   $('#content_html').append('<link rel="stylesheet" href="../../css/main.css" type="text/css" />');
		//$("#content_html").loadCSS( "../../css/main.css" );
		
	
  
});
</script>
<div style="clear:both"></div>
<div class="clearfix">
<div class="line-control-footer"></div>
<a href="index.php?<?=SystemEncryptURL("ModuleAction=EditForm&SysMenuID=$SysMenuID")?>" class="btn btn-success" ><i class="icon-plus"></i> Edit</a>

</div>

<? } ?>

</div><!-- page-content -->
<script type="text/javascript">


</script>
<? require("../inc/inc-web-footer.php");?>
</div><!-- inner-container -->
</div>
</body></html>