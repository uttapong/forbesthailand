<?
require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;


$SysMenuID= $_REQUEST["SysMenuID"];


if ($ModuleAction=="") $ModuleAction="Datalist";
?>
<? require("../inc/inc-mainfile.php");?>

<body style="background-color:#fff;" >

<script>
function SelectToEditor(url_photo) {
	var CKEditorFuncNum = <?php echo $_GET['CKEditorFuncNum']; ?>;
	window.parent.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url_photo, '' );
	self.close();
}

</script>

<div class="tabbable" >
    <ul class="nav nav-tabs" id="libraryTabs" style="font-size:20px;" >    
        <li class="active"><a href="#newupload"  data-toggle="tab"> &nbsp; เลือกลิ้งจากระบบ CMS &nbsp;</a></li>     
    </ul>
    <div class="tab-content" >
        <div class="tab-pane active"  style="height:380px; padding:0px 15px;">
       
         <?
	$SysFSort = $_POST["SysFSort"];
	$SysSort = $_POST["SysSort"];
	if ($SysFSort=="") $SysFSort="p.id";
	if ($SysSort=="") $SysSort="desc";
	
	
	
	if($Page<1) $Page=1;
	if($PageSize<1) $PageSize=10;
	
	
	$sql = "SELECT p.*,s.name as menu_name FROM webpage p";
	$sql.=" left join sysmenu s on(s.menu_id=p.menu_id) ";
	$sql.= " WHERE 1=1 ";
	
	
	if (trim($SysTextSearch)!=""){
		$sql.=" AND (p.name  like '%".$SysTextSearch."%' ";
		$sql.=")";
	}
	
	if (trim($SysCateID)>0){
		$sql.=" AND (p.cate_id  = '".$SysCateID."' ";
		$sql.=")";
	}
	
	
	$sql.= " ORDER BY ".$SysFSort." ".$SysSort;
	
	#echo $sql;
	
	$Conn->query($sql,$Page,$PageSize);
	$ContentList = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	$TotalRec= $Conn->getTotalRow();
	$TotalPageCount=ceil($TotalRec/$PageSize);
	
	?>
        
           <table class="table table-bordered table-hover dataTable" >
<thead>
<tr role="row">
<th   >#</th>

<th   style="width: 300px;" >Subject</th>
<th  style="width: 508px;" >Menu</th>
</tr>
</thead>

<tbody >

<?

 	$resize=SystemResizeImgAuto(960,960,100,100);
	
	$_index=(($Page-1)*$PageSize)+1;
	for ($i=0;$i<$CntRecInPage;$i++) {
	$Row = $ContentList[$i];
	
	
	if($Row["menu_id"]!=""){
		$subject= "Menu : ".$Row["menu_name"];	
		$menu_name=$Row["menu_name"];
		$link_edit="../webpage/index.php?".SystemEncryptURL("ModuleAction=EditForm&SysMenuID=".$Row["menu_id"]);
		$link_respon=_SYSTEM_HOST_NAME_."/content.php?mid=".$Row["menu_id"];
	}else{
		$subject= $Row["name"];
		$menu_name="-";
		$link_edit="index.php?".SystemEncryptURL("ModuleAction=EditForm&SysMenuID=".$SysMenuID."&ModuleDataID=".$Row["id"]);
		$link_respon=_SYSTEM_HOST_NAME_."/content.php?mid=".$SysMenuID."&id=".$Row["id"];
	}
	
   
	echo $_SESSION['SysMenuID'];
	
	
?>

<tr onClick="SelectToEditor('<?=$link_respon?>')" >
<td class="span1 text-center"><?=($_index+$i)?></td>
<td class="" valign="top" ><a href="javascript:void(0)"><?=$subject?></a></td>
<td class="hidden-phone sorting_1"><?=$menu_name?></td>

</tr>
<? } ?>
</tbody>
</table>
        	
        </div>
        <div class="tab-pane" id="library" style="height:400px;">&nbsp;</div>
    </div>
</div>

<script>
    $(function() {
		$('#libraryTabs').bind('show', function(e) { 			
		   var pattern=/#.+/gi //use regex to get anchor(==selector)
		   var contentID = e.target.toString().match(pattern)[0]; //get anchor   
		   if(contentID=='#library'){
				var Vars=$('#file-select-photo').serialize();
				$(contentID).load('../library/index-action.php?ModuleAction=getLibraryList&'+Vars, function(){
					$('#libraryTabs').tab(); //reinitialize tabs
				});
		   }
		  
		});
		
    });	
</script>



<div class="clearfix">
<div class="line-control-footer"></div>
&nbsp; &nbsp; 
<script>
function iframe_closeModal(){
	 window.parent.sys_modal_close();
}

function library_ok_select(){
	var Vars=$('#file-select-photo').serialize();
	 window.parent.library_feedFileUpload(Vars);
}


</script>
<a class="btn"  href="javascript:window.close();">Close</a>
</div>
</body>

</html>