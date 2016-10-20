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
if ($ModuleAction == "Login") {

	$UserID = $_REQUEST['inputLoginUsername'];
	$UserPassword = trim($_REQUEST['inputLoginPassword']);
	
	
	$sql = "SELECT u.*,g.usergroupname,g.publish FROM sysuser u";
	$sql.= " left join sysusergroup g on(g.usergroupcode=u.usergroupcode) ";
	$sql.= " WHERE u.username='".$UserID."'";
	//$sql.= " ORDER BY order_by ASC";
	
	$Conn->query($sql);
	$Content = $Conn->getResult();
	$CntRecInPage = $Conn->getRowCount();
	
	$ChkLogin=0;
	
	if($CntRecInPage){
		
		if(md5($UserPassword)==trim($Content[0]["password"])){
			$ChkLogin=1;
		}
	}
	
	if($ChkLogin){	
		$_SESSION["SysSess_ID"] = session_id();
		$_SESSION['UserID']=$UserID;
		$_SESSION['UserFname']=$Content[0]["firstname"];
		$_SESSION['UserLname']=$Content[0]["lastname"];
		
		$_SESSION['UserGroupCode']=$Content[0]["usergroupcode"];
		$_SESSION['UserGroupName']=$Content[0]["usergroupname"];
		
		$_SESSION['FIEEPIC']=$Content[0]["filepic"];
		$_SESSION['PUBLISH']=$Content[0]["publish"];
		$_SESSION['LANG']="TH";
		
		$returnArray[error] = "true";
		$returnArray[text] = "Login complete";		
		echo json_encode($returnArray);
		exit;
	
	} else {
		$returnArray[error] = "not_found";
		$returnArray[text] = "Not Found";		
		echo json_encode($returnArray);
		exit;
	}

}else if($ModuleAction == "ChangeLang"){
	
	$Lang = $_REQUEST['Lang'];
	$_SESSION['LANG']=$Lang;
	
}

?>