<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
if ($ModuleAction=="") $ModuleAction="EditForm";

?>
<? require("../inc/inc-mainfile.php");?>
<body >
<div id="page-container">
<? require("../inc/inc-web-head.php");?>
<div id="inner-container"  >
<? require("../inc/inc-web-menu.php");?>
<div style="min-height: 726px;" id="page-content"  >
<? require("../inc/inc-web-navigator.php");?>

<? if ($ModuleAction == "EditForm") { ?>

<?

$ModuleAction_Current="UpdateData";
$sql = "select *  from site_setting where module_code = 'contactform'";

$Conn->query($sql);
$ContentList = $Conn->getResult();
$CntRecInPage = $Conn->getRowCount();
$SourceInfo="";
for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
	$SourceInfo[$Row["site_key"]]=$Row["site_content"];
	
}

?>


<form id="frm" name="frm"  method="post" class="form-horizontal" onSubmit="return false;">
<input type="hidden"   id="SysMenuID" name="SysMenuID" value="<?=$SysMenuID?>" />
<input type="hidden" name="ModuleAction" id="ModuleAction" value="<?=$ModuleAction_Current?>" />
<input type="hidden" name="ModuleDataID" id="ModuleDataID" value="<?=stripslashes($ModuleDataID)?>" />
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>"/>


<div class="clearfix">
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>
<div class="line-control-header"></div>
</div>

<div class="block block-themed block-last">
<div class="block-title">
<h4><?="ติดต่อเรา"?></h4>
</div>
<div class="block-content">


<h4 class="sub-header">Contact info:</h4>
<div class="control-group">
<label class="control-label" for="general-text">Intro</label>
<div class="controls">
<input type="hidden" name="inputKey[]" value="intro" >
<textarea  name="inputContent[]" class="textarea-medium" rows="2"><?=$SourceInfo["intro"]?></textarea>
</div>
</div>



<div class="control-group">
<label class="control-label" for="product_display">Address</label>
<div class="controls">
<input type="hidden" name="inputKey[]" value="address" >
<textarea name="inputContent[]" class="textarea-medium" rows="2"><?=$SourceInfo["address"]?></textarea>
</div>
</div>


<div class="control-group">
<label class="control-label" for="product_name">Phone number</label>
<div class="controls">
<input type="hidden" name="inputKey[]" value="phone" >
<input type="text" name="inputContent[]"  class="span5" value="<?=$SourceInfo["phone"]?>" >
</div>
</div>



<div class="control-group">
<label class="control-label" for="description">E-mail</label>
<div class="controls">
<input type="hidden" name="inputKey[]" value="email" >
<input type="text" name="inputContent[]" class="span5" value="<?=$SourceInfo["email"]?>" >
</div>
</div>

<div class="control-group">
<label class="control-label" for="description">We are open</label>
<div class="controls">
<input type="hidden" name="inputKey[]" value="weareopen" >
<input type="text"  name="inputContent[]" class="span5"   value="<?=$SourceInfo["weareopen"]?>" >
</div>
</div>


<h4 class="sub-header">Social links:</h4>
<div class="control-group">
    <label class="control-label" for="description">Facebook</label>
    <div class="controls">
    <input type="hidden" name="inputKey[]" value="facebook" >
    <input type="text"  name="inputContent[]" class="span5"  placeholder="http://"  value="<?=$SourceInfo["facebook"]?>" >
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="description">Twitter</label>
    <div class="controls">
    <input type="hidden" name="inputKey[]" value="twitter" >
    <input type="text"  name="inputContent[]" class="span5"  placeholder="http://"  value="<?=$SourceInfo["twitter"]?>" >
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="description">Google Plus</label>
    <div class="controls">
    <input type="hidden" name="inputKey[]" value="google_plus" >
    <input type="text"  name="inputContent[]" class="span5"  placeholder="http://"  value="<?=$SourceInfo["google_plus"]?>" >
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="description">Youtube</label>
    <div class="controls">
    <input type="hidden" name="inputKey[]" value="youtube" >
    <input type="text"  name="inputContent[]" class="span5"  placeholder="http://"  value="<?=$SourceInfo["youtube"]?>" >
    </div>
</div>




<?


$statusRecommend=$Row["flag_recommend"];
$statusBestseller=$Row["flag_bestseller"];
	
?>


<h4 class="sub-header">สถานะ</h4>


<div class="row-fluid" style="margin-left:40px;">
<div class="span3">
<label class="checkbox">
  <input class="icheckbox" id="statusRecommend" name="statusRecommend" type="checkbox" value="1" <? if($statusRecommend){?>checked<? } ?> > &nbsp; สินค้าแนะนำ
</label>
</div>
<div class="span6">
<label class="checkbox">
  <input class="icheckbox" id="statusBestseller" name="statusBestseller" type="checkbox" value="1" <? if($statusBestseller){?>checked<? } ?> > &nbsp; สินค้าขายดี
</label>
</div>




</div>

<br>

<div style="clear:both;">&nbsp;</div>


</div>
</div>

<div class="clearfix">
<div class="line-control-footer"></div>
<button type="submit" class="btn btn-success" onClick="submitFormContent();"><i class="icon-ok"></i> <?=_SAVE_?></button>

</div>
</form>

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