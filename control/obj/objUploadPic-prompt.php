<?
require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;
if ($ModuleAction=="") $ModuleAction="Datalist";

?>
<? require("../inc/inc-mainfile.php");?>
<body style="background-color:#fff;" >
<?
$ObjUFileID=$_REQUEST["ObjUFileID"];
$ObjUFileType=$_REQUEST["ObjUFileType"];

$ObjUFileResizeType=$_REQUEST["ObjUFileResizeType"];
$ObjUFileResizeWidth=$_REQUEST["ObjUFileResizeWidth"];
$ObjUFileResizeHeight=$_REQUEST["ObjUFileResizeHeight"];



if($ObjUFileType=="onepic"){
	include("../obj/objUploadPic/onepic.php");
}else{
	include("../obj/file-upload/index.php");
}

?>
</body>

</html>