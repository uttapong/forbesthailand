<?
	session_start();
	if (empty($_SESSION['SystemAccount']))	{
		$Acc = new SystemAccount();
		$Acc->AccountType = "Guest";
		$Acc->IP = $_SERVER['REMOTE_ADDR'];
		$_SESSION['SystemAccount'] = $Acc;
	}
	$SystemAccount = $_SESSION['SystemAccount'];
	
	$_SESSION["SITE_CODE"]="S0001";

?>