<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>

<? 
	if ($ModuleAction == "UpdateData") {
	
	$input_content = stripslashes( (string)$_REQUEST["input_content"] );
	
	$update="";
	$update[] = "site_content 		= '".$input_content."'";
	$sql = "update  site_setting set ".implode(",",array_values($update)) ;
	$sql.=" where site_code = '".$_SESSION["SITE_CODE"]."'  and module_code='home' ";		
	
	$Conn->execute($sql);

}

?>