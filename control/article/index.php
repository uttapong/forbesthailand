<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ckeditor/ckeditor.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ajaxupload.js');
if ($ModuleAction=="") $ModuleAction="Datalist";
$SysPMS=SystemGetPermissionText($SysMenuID);
if($SysPMS!="MANAGE"){ 
	header('Location:../dashboard/');
}else if($ModuleAction == "EditForm" && $_SESSION['UserGroupCode'] !="ADMIN"){
	$sql = "select count(*) as C  from article_main where id = '$ModuleDataID' and createby='".$_SESSION['UserID']."'";

	$Conn->query($sql);
	$Content = $Conn->getResult();
	if($Content[0]['C']<1){
		header('Location:../dashboard/');
	}
}
?>
<? require("../inc/inc-mainfile.php");?>
<body >
<div id="page-container">
<? require("../inc/inc-web-head.php");?>
<div id="inner-container"  >
<? require("../inc/inc-web-menu.php");?>
<div style="min-height: 726px;" id="page-content"  >
<? require("../inc/inc-web-navigator.php");?>

<? if($SysMenuID!='MNT06' && $SysMenuID!='MNT08' && $SysMenuID!='MNT16'  ){  ?>

<ul class="nav nav-tabs  menu-top-inner">
<li class="active"><a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" >รายการบทความ</a></li>
<? if($_SESSION['UserGroupCode']=="ADMIN"){ ?>
<li ><a href="category.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" >หมวดหมู่บทความ</a></li>
<? } ?>
</ul>

<? } ?>

<? if ($ModuleAction == "AddForm" || $ModuleAction == "EditForm") { ?>
<?
if($ModuleAction == "AddForm"){
	$lbl_tab=_Add_." ".$_sourceMaster["name"];
	$ModuleAction_Current="InsertNewData";
	$v_status=1;
	$Row="";
	$Row["site_code"]=$_SESSION["SITE_CODE"];
	$showDate=date("d/m/Y");
	$flag_submit=2;
}else{
	$lbl_tab=_Edit_." ".$_sourceMaster["name"];;
	$ModuleAction_Current="UpdateData";
	$sql = "select *  from article_main where id = '$ModuleDataID'";
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];
	$showDate=SystemDateFormat($Row["createdate"]);
	$showDate1=SystemDateFormat($Row["dateshow1"]);
	$showDate2=SystemDateFormat($Row["dateshow2"]);
	$content_html=$Row["content"];
	$flag_submit=1;
}
?>
<form id="frm" name="frm"  method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return false;" >
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
<input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
<input type="hidden" name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>"/>
<input type="hidden"  name="SysTypeSave" id="SysTypeSave" />
<div class="clearfix">
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&Page=$Page")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(<?=$flag_submit?>);"><i class="icon-ok"></i> <?=_SAVE_?></button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(0);"><i class="icon-ok"></i> <?=_SAVE_?> & New</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(3);"><i class="icon-ok"></i> <?=_SAVE_?> & Preview</button>
<div class="line-control-header"></div>
</div>
<div class="block block-themed block-last">
<div class="block-title">
<h4>จัดการเนื้อหา : <?=$lbl_tab?></h4>
</div>
<div class="block-content">
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#content-main">ข้อมูลหลัก</a></li>
  <li><a href="#content-th"><img src="../img/lang/flag-th.gif" style="width:20px!important; height:13px!important"> Thai</a></li>
  <li><a href="#content-en"><img src="../img/lang/flag-en.gif" style="width:20px!important; height:13px!important">  English</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="content-main">
  <div class="control-group">
<label class="control-label" for="product_display">เปิด/ปิดการแสดงผล</label>
<div class="controls">
<? if($_SESSION['PUBLISH']=="Y"){ ?>
<select id="product_display" name="product_display" class="input-xlarge">
<?=SystemArraySelect($source_status,$Row["flag_display"]); ?>
</select>
<? }else{ ?>
<? if($Row["flag_display"]==""){ $Row["flag_display"]="Y"; } ?>
<input type="text" class="input-xlarge" value="<?=$source_status[$Row["flag_display"]]?>" disabled >
<input type="hidden"  name="product_display" class="input-xlarge" value="<?=$Row["flag_display"]?>"  >
<? } ?>
</div>
</div>
<?
if($_SESSION['UserGroupCode'] !="ADMIN"){ 
?>
<input type="hidden"  name="flag_approved" class="input-xlarge" value="N"  >
<?
}
?>

<? if($SysMenuID!='MNT14'){ ?>
<div class="control-group">
<label class="control-label" for="cate_id">หมวดหมู่หลัก</label>
<div class="controls">
<select  id="input_menuid"  name="input_menuid" class="input-xlarge" required>
<?=SystemArraySelect($sourceCateMenu,$SysMenuID); ?>
</select>
</div>
</div>
<? }else{ ?>
<input type="hidden"  name="input_menuid" class="input-xlarge" value="MNT14"  >
<? } ?>

<div id="area_select_cate1">
<? if($SysMenuID!='MNT06' && $SysMenuID!='MNT08' && $SysMenuID!='MNT16'  ){  ?>
<div class="control-group"  >
<label class="control-label" for="cate_id">หมวดหมู่</label>
<div class="controls"  >
<select  id="cate_id"  name="cate_id" class="input-xlarge" required>
<option value="0" data-level="0" >-</option>
<? my_loadTreeCatSelect(0,$Row["cate_id"]); ?>
</select>
</div>
</div>
<? } ?>
</div>

<div class="control-group">
<label class="control-label" for="cover_id">Cover</label>
<div class="controls">
<select  id="cover_id"  name="cover_id" class="input-xlarge" >
<option value=""  >-</option>
<?=SystemGetSqlSelect('cover_main','id','name_'.strtolower($_SESSION['LANG']),$Row["cover_id"],'id desc',""); ?>
</select>
</div>
</div>



<div class="control-group">
<label class="control-label" for="product_name">รูปภาพตัวอย่าง</label>
<div class="controls">
			<?    
			$ObjUFileID="OnePic";
			$ObjUFileType="onepic";
			$img="../../uploads/article/".$Row["filepic"];
			if ((is_file($img) && file_exists($img) )) {
				$ObjUFileOldPath=$img;
			}
			include('../obj/objUploadPic/index.php'); 
            ?>
            <br>
               <!--
			โดยขนาดรูปที่เหมาะสมคือขนาด 667x490  px.
            -->
</div>
</div>


<?
	if($SysMenuID=="MNT14"){
		include('../obj/vdo-main.php'); 
	}else{

	include('../obj/vdo.php'); 
	}
?>




<div class="control-group">
<label class="control-label" for="product_display">วันที่แสดงผล</label>
<div class="controls">
<input type="text" id="input_date1" name="input_date1"  class="calendar" value="<?=$showDate1?>"> 
<a href="javascript:goClearText('input_date1')" class="btn" style="padding:2px 6px;"><span class="icon-refresh"> </span></a>
 - 
<input type="text" id="input_date2" name="input_date2"  class="calendar" value="<?=$showDate2?>">
<a href="javascript:goClearText('input_date2')" class="btn" style="padding:2px 6px;"><span class="icon-refresh"> </span></a>
</div>
</div>


<script>
  $(function() {
    $( "input.calendar" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  </script>
  


  <div class="control-group">
<label class="control-label" for="statusHilight">HILIGHT CONTENT</label>
<div class="controls">
<?
$hilight= SystemGetOneData('hilight_main','content_id',"content_id='".$ModuleDataID."'");
?>
<input class="icheckbox" id="statusHilight" name="statusHilight" type="checkbox" value="Y" <? if($hilight){?>checked<? } ?> > &nbsp;

</div>
</div>
  <br>
<?

$sql = "SELECT * from article_file ";
$sql.= " WHERE article_id='".$ModuleDataID."'";
$sql.= " ORDER BY order_by ASC";
#echo $sql;

$Conn->query($sql);
$FileList = $Conn->getResult();
$CntRecFile = $Conn->getRowCount();

?>

<h4 class="sub-header">Photo Gallery</h4>
<div class="row-fluid">
<div class="span4">
<a id="btn_add_photo"  class="btn btn-primary"  data-toggle="modal" href="../obj/file-upload-prompt.php"><i class="icon-plus"></i> เพิ่มรูปภาพ</a>
</div>
<div class="span8">จำนวนภาพ <span id="area_num_photo"><?=$CntRecFile?></span> ภาพ</div>
</div>
<br>

<script>
$(document).ready(function(){					 
$("#area_select_photo").sortable({'placeholder':'sortable-cat-highlight'});
$("#area_select_photo").disableSelection();
});
</script>
<div class="row-fluid">
<ul id="area_select_photo">
<?
	$_file_old_id="";

	for ($i=0;$i<$CntRecFile;$i++) {
		$RowFile = $FileList[$i];
		
		$physical_name=_SYSTEM_UPLOADS_FOLDER_."/article/".$RowFile["physical_name"];
		$filesize=SystemSizeFilter($RowFile["file_size"]);
		$_file_old_id.=$RowFile["id"]."-";
		?>
        
        <li class="boxli_file_photo" id="P<?=$RowFile["id"]?>" >
        <div class="file_photo_desc">
        <div class="delete" onClick="library_remove_photo(this);">นำออก</div>
          <div class="view ">
          <a  class="btn_photo_view"  data-toggle="modal" href="../library/index-action.php?<?=SystemEncryptURL("ModuleAction=showPhoto&file_id=P".$RowFile["id"])?>"> ดูภาพขยาย </a>
          </div>
        </div>
         <img  alt="<?=$Row["file_name"]?>" src="<?=$physical_name?>" >
        </li>
        
        <?
	}
?>

</ul>
</div>
<input type="hidden" name="inputPhotoFileID" id="inputPhotoFileID" >
<input type="hidden" name="inputPhotoOldFileID" id="inputPhotoOldFileID" value="<?=$_file_old_id?>" >
 
<br>


  
  </div>
  <div class="tab-pane" id="content-th">
        <div class="control-group">
        <label class="control-label request"  for="product_name">* NAME</label>
        <div class="controls">
        <textarea id="input_name_th" name="input_name_th"  class="input-xxlarge request" rows="4"><?=$Row["name_th"]?></textarea>
        </div>
        </div>
        <div class="control-group">
        <label class="control-label request"  for="product_name">เนื้อหา</label>
        <div class="controls">
        <textarea cols="80" id="input_content_th" name="input_content_th" rows="10"><?=$Row["content_th"]?></textarea>
        <script>
        var editor=CKEDITOR.replace( 'input_content_th');
        </script>
        </div>
        </div>
        <div class="control-group">
        <label class="control-label "  for="input_keyword">Keywords </label>
        <div class="controls">
        <input type="text" id="input_keyword_th" name="input_keyword_th" class="input-xxlarge  " value="<?=$Row["keyword_th"]?>" >
        <label class="des"> คีย์เวิร์ดคำค้นหา คั่นแต่ละรายการด้วย ลูกน้ำ (,) 4 - 8 คำ </label>
        </div>
        </div>
  </div>
  <div class="tab-pane" id="content-en">
  
          <div class="control-group">
        <label class="control-label request"  for="product_name">* NAME</label>
        <div class="controls">
        <textarea id="input_name_en" name="input_name_en"  class="input-xxlarge" rows="4"><?=$Row["name_en"]?></textarea>
        </div>
        </div>
        <div class="control-group">
        <label class="control-label request"  for="product_name">เนื้อหา</label>
        <div class="controls">
        <textarea cols="80" id="input_content_en" name="input_content_en" rows="10"><?=$Row["content_en"]?></textarea>
        <script>
        var editor=CKEDITOR.replace( 'input_content_en');
        </script>
        </div>
        </div>
        <div class="control-group">
        <label class="control-label "  for="input_keyword">Keywords </label>
        <div class="controls">
        <input type="text" id="input_keyword_en" name="input_keyword_en" class="input-xxlarge  " value="<?=$Row["keyword_en"]?>" >
        <label class="des"> คีย์เวิร์ดคำค้นหา คั่นแต่ละรายการด้วย ลูกน้ำ (,) 4 - 8 คำ </label>
        </div>
        </div>
  
  </div>
</div>
 
<script>
  $(function () {
    //$('#myTab a:last').tab('show');
  })
  $('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
  
</script>









<div style="clear:both;">&nbsp;</div>
</div>
</div>

<div class="clearfix">
<div class="line-control-footer"></div>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(<?=$flag_submit?>);"><i class="icon-ok"></i> <?=_SAVE_?></button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(0);"><i class="icon-ok"></i> <?=_SAVE_?> & New</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(3);"><i class="icon-ok"></i> <?=_SAVE_?> & Preview</button>
</div>
</form>


<? }else if ($ModuleAction == "Sorting"){ ?>

<?

	$sql = "SELECT p.*,c.name as category_name FROM article_main p";
	$sql.=" left join article_category c on(c.cate_id=p.cate_id) ";
	$sql.= " WHERE p.menu_id='".$SysMenuID."'";
	
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	if (trim($SysCateID)>0){
		$sql.=" AND (p.cate_id  = '".$SysCateID."' ";
		$sql.=")";
	}
	
	
	$sql.= " ORDER BY order_by asc ";
	
//	echo $sql;
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();

	?>
    
  
<form id="frm" name="frm"  method="post" class="form-horizontal" onSubmit="return false;">
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>"/>



<div class="clearfix">
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="submit" class="btn btn-success" onClick="mod_verifySortableCategories();"><i class="icon-ok"></i> <?=_SAVE_?></button>

<div class="line-control-header"></div>
</div>
        
        
        <div class="block block-themed block-last">
<div class="block-title">
<h4>Sort</h4>
</div>
<div class="block-content">

    <div id="sortable-area" >
    <ul class="sortable-cat">
      <?
		for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 	$physical_name="../../uploads/news/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	?>
    
   <li id="<?=$Row["id"]?>" rel="<?=$Row["order_by"]?>">
            	<div class="box">
                    <div class="ft-left" >
                   <?=$Row["name"]?>
                    </div>
                    <div class="clear"></div>
                </div>
			
			</li>
   
   <? } ?>
        
    </ul>
    </div>
    <br>

    
    

</div>
</div>
   <div class="clearfix">
<div class="line-control-footer"></div>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>"  class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="submit" class="btn btn-success" onClick="mod_verifySortableCategories();"><i class="icon-ok"></i> <?=_SAVE_?></button>

</div>     
       </form>
        
        
        
        
        
        <style type="text/css">
ul.sortable-cat {
  list-style:none;
  padding: 0;
  margin: 0 0 0 25px;
}
ul.sortable-cat li{
	margin: 7px 0 0 0;
}
.sortable-cat li div.box {
	color: #484848;
	border: 1px solid #ebebeb;
	padding:5px 10px;
	cursor: move;
}
.sortable-cat-highlight {
	background-color: #fbf9ee;
	border:1px #fcefa1  dashed;
	display:inline-block;
	width:100%;
	height:30px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
						   
	 $(".sortable-cat").sortable({
		 'placeholder':'sortable-cat-highlight',
		  opacity: 0.7,
		  forcePlaceholderSize: true,
		  helper:'clone',
		  cursor: 'move',
		  maxLevels: 5,
		  tolerance: 'pointer'
		});
	  $(".sortable-cat").disableSelection();
	});
</script>


<? }else{ ?>


<div id="datalist-content">
<?
include('index-action.php');
?>
</div>
<? } ?>

</div><!-- page-content -->
<? require("../inc/inc-web-footer.php");?>
</div><!-- inner-container -->
</div>
</body></html>