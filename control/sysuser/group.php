<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'group.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ckeditor/ckeditor.js');
$Sys_MainFile[]=array(type=>'javascript',path=>'../js/ajaxupload.js');
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





<? if ($ModuleAction == "AddForm" || $ModuleAction == "EditForm") { ?>

<?
if($ModuleAction == "AddForm"){
	$lbl_tab=_Add_." ".$_sourceMaster["name"];
	$ModuleAction_Current="InsertNewData";
	$v_status=1;	
	$Row="";
	
	$Row["site_code"]=$_SESSION["SITE_CODE"];
	$PermissionSource=array();
	
}else{
	$lbl_tab=_Edit_." ".$_sourceMaster["name"];;
	$ModuleAction_Current="UpdateData";
	
	
		
	$sql = "select *  from sysusergroupaccess where usergroupcode = '$ModuleDataID'";
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	
	$PermissionSource=array();
	
	for ($i=0;$i<$CntRecInPage;$i++) {
		$Row=$ContentList[$i];
		$PermissionSource[$Row["menuid"]]=$Row["controlaccess"];
	}
	

	$sql = "select *  from sysusergroup where usergroupcode = '$ModuleDataID'";
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$Row=$Content[0];
	$showDate=SystemDateFormat($Row["date_display"]);	
	$content_html=$Row["content"];
	
}
?>




<form id="frm" name="frm"  method="post" class="form-horizontal" enctype="multipart/form-data" onSubmit="return false;" >

<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
<input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>"/>


<div class="clearfix">
<a href="group.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&Page=$Page")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>
<div class="line-control-header"></div>
</div>

<div class="block block-themed block-last">
<div class="block-title">
<h4>จัดการเนื้อหา</h4>
</div>
<div class="block-content">



<h4 class="sub-header">ข้อมูลระบบ</h4>

<div class="control-group">
<label class="control-label request"  for="input_username">* Group Code</label>
<div class="controls">
<input type="text" id="input_groupcode" name="input_groupcode" <? if($ModuleAction == "EditForm"){?>readonly<? } ?> class="input-large" value="<?=$Row["usergroupcode"]?>" >  <span class="request"></span>
</div>
</div>
<div class="control-group">
<label class="control-label request"  for="product_name">* Group Name</label>
<div class="controls">
<input type="text" id="input_fname" name="input_fname" class="input-large request " value="<?=$Row["usergroupname"]?>" >
</div>
</div>



<div class="control-group">
<label class="control-label request"  for="input_publish">* Publish Permissions </label>
<div class="controls">
<select id="input_publish" name="input_publish" class="input-xlarge">
<?=SystemArraySelect($source_permiss,$Row["publish"]); ?>
</select>
</div>
</div>


<h4 class="sub-header">จัดการสิทธิการใช้งาน</h4>

<style>
#groupmenu-content div.row{ border-bottom:1px solid #e9e9e9; margin-left:1px; }
#groupmenu-content .box-categories{ background-color:#fff; color:#000; border:0px;}
#groupmenu-content #box-cat-inner{}
#groupmenu-content .box-hide{ width:85px; float:left; }
#groupmenu-content input[type="radio"],#groupmenu-content input[type="checkbox"]{ margin-top:0px; }
#groupmenu-content .box-action{ float:right; display:inline-block; margin-top:10px;}

#groupmenu-content radio, #groupmenu-content .checkbox {
min-height: 20px;
padding-left: 5px;
}
#groupmenu-content .show-less{ cursor:default }
#groupmenu-content .box-action a{ font-weight:bold; }


.nav-permiss {
margin-bottom: 0px; margin-left:15px; font-weight:bold;

}

</style>


<ul class="nav nav-tabs nav-permiss" id="myTab">
  <li class="active"><a href="#menu_system">Menu System</a></li>
  <li><a href="#menu_general">Menu General</a></li>

</ul>
 

 
<script>
  $(function () {
   // $('#myTab111 a:last').tab('show');
	
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})
	
  })
</script>
<script>

function selectAllPermiss(id_tab,type){
	var elm=id_tab+" .permiss_"+type;
	$("#"+elm).attr('checked', true);
}

</script>

<div class="tab-content">
  <div class="tab-pane active" id="menu_system">
<div id="groupmenu-content">
    <div class="row" style="background-color:#f5f5f5;">
        <div id="box-cat-inner" class="ft-left ">
        <div class="txt-head" style=" padding-left:15px;">
        <h4 >Menu list</h4></div>     
        </div>
           <span class="box-action">
            <label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_system','hide')">Select All</a> </label>
            <label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_system','view')">Select All</a> </label>
            <label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_system','manage')">Select All</a> </label>   
            </span>      
        <div class="clear"></div>
    </div>
<?
  my_loadTreeCat(0,'system','top');
?>
</div>
</div>



 <div class="tab-pane" id="menu_general">
 <div id="groupmenu-content">
    <div class="row" style="background-color:#f5f5f5;">
        <div id="box-cat-inner" class="ft-left ">
        <div class="txt-head" style=" padding-left:15px;">
        <h4 >Menu list</h4></div>     
        </div>
           <span class="box-action">
          	<label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_general','hide')">Select All</a> </label>
            <label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_general','view')">Select All</a> </label>
            <label class="box-hide checkbox">  <a href="javascript:selectAllPermiss('menu_general','manage')">Select All</a> </label>   

            </span>      
        <div class="clear"></div>
    </div>
<?
  my_loadTreeCat(0,'web','top');
?>
</div>
 </div>
</div>


<div style="clear:both;">&nbsp;</div>
</div>
</div>

<div class="clearfix">
<div class="line-control-footer"></div>
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>

</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	//$('#flagChangePW')	
	
	$('#flagChangePW').on('ifChanged', function(event){
 		if($(this).is(':checked')){	
			$("#input_pw").prop('disabled', false);
			$("#input_pwconfirm").prop('disabled', false);	
		}else{
			$('#control-groupgroup-pw .control-group').removeClass('error');
			$("#input_pw").prop('disabled', true);
			$("#input_pwconfirm").prop('disabled', true);	
		}
	});
	
	
});

</script>


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
<a href="group.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
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
<a href="index.php" class="btn" ><i class="icon-chevron-left"></i>Back</a>
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
include('group-action.php');
?>
</div>
<? } ?>

</div><!-- page-content -->
<? require("../inc/inc-web-footer.php");?>
</div><!-- inner-container -->
</div>
</body></html>