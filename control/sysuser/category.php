<?
require("../lib/system_core.php");
include_once("function.php");
$Sys_Title=_SYSTEM_TITLE_;
$Sys_MainFile[]=array(type=>'javascript',path=>'category.js');
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

<ul class="nav nav-tabs  menu-top-inner">
<li class=""><a href="index.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" >รายการบทความ</a></li>
<li class="active"><a href="category.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" >หมวดหมู่บทความ</a></li>
</ul>
<?  if($ModuleAction == "SortForm"){ ?>
<?
	function my_loadSortTreeCat($ParentID){
	global $Conn;	
	$sql = "SELECT * FROM article_category";
	$sql.= " WHERE parent_id='$ParentID'";
	$sql.= " ORDER BY order_by ASC";
	
	
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->var_totalRow;
	
	for ($i=0;$i<$CntRecInPage;$i++) {
			
		$Row = $ContentList[$i];
		$sql1 = "SELECT count(*) as CNT FROM article_category ";
		$sql1.=" WHERE parent_id ='".$Row["cate_id"]."' ";
		
		$sql1.=" ORDER BY order_by ASC";
		$Conn->query($sql1);
		$ContentList1 = $Conn->getResult();
		$RecordCount1= $ContentList1[0]["CNT"];
		
			?>
			<li id="<?=$Row["cate_id"]?>" rel="<?=$Row["order_by"]?>">
            	<div class="box">
                    <div class="ft-left" >
                   <?=$Row["name"]?>
                    </div>
                    <div class="clear"></div>
                </div>
			<?
			if($RecordCount1>0){
			?>
			<ul class="sortable-cat"><?=my_loadSortTreeCat($Row["cate_id"]); ?></ul></li>
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

<form id="frm" name="frm"  method="post" class="form-horizontal" onSubmit="return false;">
<input type="hidden"  name="SysModReturnURL" id="SysModReturnURL" value="<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>"/>
<div class="clearfix">
<a href="category.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="submit" class="btn btn-success" onClick="mod_verifySortableCategories();"><i class="icon-ok"></i> <?=_SAVE_?></button>
<div class="line-control-header"></div>
</div>

<div class="block block-themed block-last">
<div class="block-title">
<h4>Sort</h4>
</div>
<div class="block-content" style="min-height:300px;">

    <div id="sortable-area" >
    <ul class="sortable-cat">
    <?
    my_loadSortTreeCat(0);
    ?>
    </ul>
    <br>

    </div>
</div>

</div>

<div class="clearfix">
<div class="line-control-footer"></div>
<a href="category.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID")?>" class="btn" ><i class="icon-chevron-left"></i>Back</a>
<button type="submit" class="btn btn-success" onClick="mod_verifySortableCategories();"><i class="icon-ok"></i> <?=_SAVE_?></button>

</div>
    </form>




<? }else{ ?>

<div class="clearfix">

<a id="btn_add" class="btn btn-success" data-toggle="modal" href="category-action.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=AddForm")?>"><i class="icon-plus"></i> Add New Category</a>

<a  class="btn"  href="category.php?<?=SystemEncryptURL("SysMenuID=$SysMenuID&ModuleAction=SortForm")?>"><i class="icon-plus"></i><?=_Store_Cateory_Sorting_?></a>
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