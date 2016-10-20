<?
if($_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"){
	require("../lib/system_core.php");
	require("function.php");
}
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}
?>

<?
if ($ModuleAction == "UpdateData") {
	
	$sql = "delete from site_setting where module_code = 'contactform'";
	$Conn->execute($sql);
	
	$inputKey = $_REQUEST["inputKey"];
	$inputContent=$_REQUEST["inputContent"];
	
	$i=-1;
	foreach($inputKey as $val){
		$i++;
		if($val!=""){
			
				$_content=$inputContent[$i];
				
				if($_content!=""){
			
					$insert="";
					$insert["site_code"] 			= "'S0001'";
					$insert["module_code"] 			= "'contactform'";
					$insert["site_key"] 			= "'".$val."'";
					$insert["site_content"] 		= "'".$_content."'";
					
					$sql = "insert into site_setting(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
				
					$Conn->execute($sql);
				}
		}
		
	}
	
	
	
?>

<? 
}

?>