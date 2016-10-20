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

<? if ($ModuleAction == "showState") { ?>


<div id="datalist-content" style="background:#fff; ">
<div class="modal-form">
<div class="modal_h" >

<div style="padding:20px 0px; margin:0px 20px;" >

<div style="padding:10px 0px 20px;">
<b>Display Stat :</b> STEP INTO THE SEVENTH DECADE TANAWATCHAI VILAILUK.SAMART EXPAND T..
</div>


Form <input type="text" id="input_date1" name="input_date1"  class="calendar clsDatePicker" value="<?=$showDate1?>"> 
 to 
<input type="text" id="input_date2" name="input_date2"  class="calendar" value="<?=$showDate2?>">

<script>

  $(function() {
    $( "input.calendar" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });

  </script>
  &nbsp; 
  
  
  
 
 <a style="margin-top:-10px;" href="export.php?<?=SystemEncryptURL("ModuleAction=EditForm&ModuleDataID=".$ModuleDataID)?>" data-toggle="tooltip"  target="_blank"  class="btn btn-mini" title="Export statistic to excel.">กรอง | Filter</a> 
 
  <a style="margin-top:-10px;" href="export.php?<?=SystemEncryptURL("ModuleAction=EditForm&ModuleDataID=".$ModuleDataID)?>" data-toggle="tooltip"  target="_blank"  class="btn btn-mini" title="Export statistic to excel.">ดูทั้งหมด | See all</a> 
  
<a style="margin-top:-10px;" href="export.php?<?=SystemEncryptURL("ModuleAction=EditForm&ModuleDataID=".$ModuleDataID)?>" data-toggle="tooltip"  target="_blank"  class="btn btn-mini" title="Export statistic to excel.">Export</a>
</div>


<div  class="dataTables_wrapper form-inline" role="grid" style="text-align:center; margin:auto;">

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
<th style="width:20px;"  >#</th>
<th  >หน้าแสดงผล</th>

<th  style="text-align:center;width:100px;"  >IP</th>

<th style="width: 100px;" >วันที่</th>
</tr>
</thead>

<tbody >

<?

	$_index=(($Page-1)*$PageSize)+1;
	$CntRecInPage=20;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
 

?>

<tr >
<td class="span1 text-center"><?=($_index+$i)?></td>

<td class="" valign="top"  >
x
</td>

<td class="" valign="top"  >
x
</td>

<td class="span1 text-center ">
x
</td>
</tr>
<? } ?>
</tbody>
</table>

<?
/*
$v_paging["Page"]=$Page;
$v_paging["Type"]="FOOTER";
$v_paging["PageSize"]=$PageSize;
$v_paging["TotalRec"]=$TotalRec;
$v_paging["CntRecInPage"]=$RowCountInPage;
SystemPaging($v_paging);
*/
?>

</div>

</div>


</div>
</div>
<? } ?>
</div>
</body></html>