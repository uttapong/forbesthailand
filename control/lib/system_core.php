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
	
	if($_SESSION['LANG']==""){
		$_SESSION['LANG']="TH";	
	}
	require_once(_DOCUMENT_ROOT_."/lang/th.php");
	require_once(_DOCUMENT_ROOT_.'/lib/system_table.php');
	require_once(_DOCUMENT_ROOT_."/lib/Class/class.database.php");
	require_once(_DOCUMENT_ROOT_.'/lib/Class/class.phpmailer.php');
	require_once(_DOCUMENT_ROOT_.'/lib/Class/resize-image-class.php');			
	$Conn = new QueryDatabase(_DATABASE_HOST_,_DATABASE_USERNAME_,_DATABASE_PASSWORD_,_DATABASE_NAME_);
	if (!SystemCheckLogin())	{
			header('Location:../authen/');
	}
?>