<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'index.js');
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


<?  if($ModuleAction == "SortForm"){ ?>

<?

	function my_loadSortTreeCat($ParentID){
	global $Conn,$SysGroup;	
	
	//echo $SysGroup;
	
	$sql = "SELECT * FROM sysmenu";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " AND type='web' ";
	$sql.= " AND menu_group='$SysGroup'";
	$sql.= " AND lang_code ='".$_SESSION["LANG"]."'";
	$sql.= " ORDER BY order_by ASC";
	
	
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
		$sql1 = "SELECT count(*) as CNT FROM sysmenu ";
		$sql1.=" WHERE parent_id ='".$Row["menu_id"]."' ";
		
		$sql1.=" ORDER BY order_by ASC";
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		$RecordCount1= $ContentList1[0]["CNT"];
		
			?>
			<li id="<?=$Row["menu_id"]?>" rel="<?=$Row["order_by"]?>">
            	<div class="box">
                    <div class="ft-left" >
                   <?=$Row["name"]?>
                    </div>
                    <div class="clear"></div>
                </div>
			<?
			if($RecordCount1>0){
			?>
			<ul class="sortable-cat"><?=my_loadSortTreeCat($Row["menu_id"]); ?></ul></li>
			<?
			}
	
		}
	}
?>

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
	height:35px;
	width:100%;
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

<form id="frm" name="frm"  method="post" class="form-horizontal" onSubmit="return false;">
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID&SysGroup=$SysGroup")?>"/>
<div class="clearfix">
<a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&SysGroup=$SysGroup")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
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
    my_loadSortTreeCat(0);
    ?>
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



<? }else{ ?>

          
<div class="clearfix">

<a id="btn_add" class="btn btn-success" data-toggle="modal" href="index-action.php?<?=SystemEncryptURL("ModuleAction=AddForm&SysGroup=$SysGroup")?>"><i class="icon-plus"></i> Add New Menu </a>

<a  class="btn"  href="index.php?<?=SystemEncryptURL("ModuleAction=SortForm&SysMenuID=$SysMenuID&SysGroup=$SysGroup")?>"><i class="icon-plus"></i> Sortable</a>
<div class="line-control-header"></div>
</div>

<br>

 <div id="categories-content">
<?
  my_loadTreeCat(0);
?>

</div>
<? } ?>



</div><!-- page-content -->
<? require("../inc/inc-web-footer.php");?>
</div><!-- inner-container -->
</div>

</body></html>