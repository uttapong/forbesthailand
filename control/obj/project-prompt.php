<?
require("../lib/system_core.php");
$Sys_Title=_SYSTEM_TITLE_;
if ($ModuleAction=="") $ModuleAction="Datalist";


$file_list= substr($_REQUEST["project_list"],0,strlen($_REQUEST["project_list"])-1);
$file_list=str_replace("P","",$file_list);	
$file_list=str_replace("L","",$file_list);	

?>
<? require("../inc/inc-mainfile.php");?>
<body style="background-color:#fff;" >
<?
$ObjUFileID=$_REQUEST["ObjUFileID"];
$ObjUFileType=$_REQUEST["ObjUFileType"];

include("../obj/project_refer/index.php");
?>
</body>

</html>