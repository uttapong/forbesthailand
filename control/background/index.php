<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ckeditor/ckeditor.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ajaxupload.js');
if ($ModuleAction=="") $ModuleAction="Datalist";


$SysPMS=SystemGetPermissionText($SysMenuID);


?>
<? require("../inc/inc-mainfile.php");?>
<body >
<div id="page-container">
<? require("../inc/inc-web-head.php");?>
<div id="inner-container"  >
<? require("../inc/inc-web-menu.php");?>
<div style="min-height: 726px;" id="page-content"  >
<? require("../inc/inc-web-navigator.php");?>



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
	
	$sql = "select *  from bg_main where id = '$ModuleDataID'";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];
	
	$showDate=SystemDateFormat($Row["createdate"]);
	
	
	$content_html=$Row["content"];
		$flag_submit=1;
}
?>

<?
$sourceBGMenu["COVER"]="COVER";
$sql = "SELECT  *  FROM article_category a ";
$sql.= "WHERE  a.menu_id='MNT13' and a.level='1' ";
$sql.= " ORDER BY a.order_by asc";	

$Conn->query($sql);
$BGCateList = $Conn->getResult();
$CntRecBG = $Conn->getRowCount();
for ($j=0;$j<$CntRecBG;$j++) {
	$RowCate = $BGCateList[$j];
	$sourceBGMenu["LIFE_TH_".$RowCate["cate_id"]]="FORBES LIFE THAILAND : ".$RowCate["name_".strtolower($_SESSION['FRONT_LANG'])];
}


?>



<form id="frm" name="frm"  method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return false;" >

<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
<input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>"/>


<div class="clearfix">
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&Page=$Page")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(<?=$flag_submit?>);"><i class="icon-ok"></i> <?=_SAVE_?></button>
<button type="submit" class="btn btn-success" onClick="submitFormContent(0);"><i class="icon-ok"></i> <?=_SAVE_?> & New</button>
<div class="line-control-header"></div>
</div>

<div class="block block-themed block-last">
<div class="block-title">
<h4>จัดการเนื้อหา : <?=$lbl_tab?></h4>
</div>
<div class="block-content">



<div class="tab-pane active" id="content-main">
  
  <div class="control-group">
<label class="control-label" for="product_display">เปิด/ปิดการแสดงผล</label>
<div class="controls">
<? if($_SESSION['UserGroupCode']=="ADMIN"){ ?>
<select id="product_display" name="product_display" class="input-xlarge">
<?=SystemArraySelect($source_status,$Row["flag_display"]); ?>
</select>
<? }else{ ?>
<?
if($Row["flag_display"]=="") $Row["flag_display"]="N"; 
?>
<input type="text" class="input-xlarge" value="<?=$source_status[$Row["flag_display"]]?>" disabled >

<?
if($_SESSION['UserGroupCode'] !="ADMIN"){ $Row["flag_display"]="N"; }
?>
<input type="hidden"  name="product_display" class="input-xlarge" value="<?=$Row["flag_display"]?>"  >

<? } ?>
</div>
</div>


<div class="control-group">
<label class="control-label request"  for="product_name">* NAME</label>
<div class="controls">
<input type="text" id="input_name" name="input_name"  class="input-xxlarge request" value="<?=$Row["name"]?>">
</div>
</div>



<div class="control-group">
<label class="control-label request"  for="product_name">CATEGORY</label>
<div class="controls">
<select id="cate_key" name="cate_key"  class="input-xxlarge request">
<option value="0" data-level="0" >-</option>
<?=SystemArraySelect($sourceBGMenu,$Row["cate_key"]); ?>
</select>
</div>
</div>




<div class="control-group">
<label class="control-label" for="product_name">รูปภาพ</label>
<div class="controls">
			<?
          
		 	$txt_size="1400x875";
			$ObjUFileWidth=400;
		  
			$ObjUFileID="OnePic";
			$ObjUFileType="onepic";
			
			$img="../../uploads/bg/".$Row["filepic"];
			if ((is_file($img) && file_exists($img) )) {
				$ObjUFileOldPath=$img;
			}
			
			include('../obj/objUploadPic/index.php'); 
            ?>
           
            <br>
            <?
			
			
			?>
            
			โดยขนาดรูปที่เหมาะสมคือขนาด <?=$txt_size?> px.

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
</div>
</form>


<? }else if ($ModuleAction == "Sorting"){ ?>

<?
	$sql = "SELECT p.* FROM bg_main p";
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
 	$physical_name="../../uploads/bg/".$Row["filepic"];
	
	if (!(is_file($physical_name) && file_exists($physical_name) )) {
		$physical_name="../img/photo_not_available.jpg";
	}
	?>
    
   <li id="<?=$Row["id"]?>" rel="<?=$Row["order_by"]?>">
            	<div class="box">
                    <div class="ft-left" >
                   <?=SystemSubString($Row["name"],65,'..')?>
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