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

if($ObjUFileType=="onepic"){
	include("../obj/objUploadPic/onepic.php");
	
}else if($ObjUFileType=="filedownload"){
	include("../obj/file-upload-all/index.php");
}else{
	include("../obj/file-upload/index.php");
}

?>
</body>

</html>