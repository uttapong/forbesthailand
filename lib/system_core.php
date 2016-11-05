<?
	mb_internal_encoding("UTF-8");	
	session_set_cookie_params(0);
	session_start();
		
	$docsRoot = getenv("DOCUMENT_ROOT");
	// $docsRoot = ereg_replace('\/$', '', $docsRoot) . "";
	$docsRoot = preg_replace('/\/$/', '', $docsRoot) . "";
	define('_DOCUMENT_ROOT_', $docsRoot);
	
		
	if($_REQUEST["language"]=="th"){
		$_SESSION['FRONT_LANG']="TH";	
		
	}else if($_REQUEST["language"]=="en"){
		$_SESSION['FRONT_LANG']="EN";	
	}else{	
		$_SESSION['FRONT_LANG']="TH";	
		//header('Location:./th/');
	}


	require_once(_DOCUMENT_ROOT_."/lib/system_config.php");
	require_once(_DOCUMENT_ROOT_."/lib/Class/SystemAccount.class.php");
	require_once(_DOCUMENT_ROOT_."/lib/system_function.php");

	
	SystemDecryptURL($_SERVER['QUERY_STRING']);
	if (empty($ModuleAction)) $ModuleAction = $_REQUEST['ModuleAction'];
	if (empty($SysMenuID)) $SysMenuID = $_REQUEST['SysMenuID'];
	

	require_once(_DOCUMENT_ROOT_."/lib/system_config.php");

	require_once(_DOCUMENT_ROOT_.'/lib/system_session.php');
	

	

	require_once(_DOCUMENT_ROOT_."/lang/".strtolower($_SESSION['FRONT_LANG']).".php");
	
	require_once(_DOCUMENT_ROOT_.'/lib/system_table.php');
	require_once(_DOCUMENT_ROOT_."/lib/Class/class.database.php");
	require_once(_DOCUMENT_ROOT_.'/lib/Class/class.phpmailer.php');
	require_once(_DOCUMENT_ROOT_.'/lib/Class/resize-image-class.php');
	
				
	$Conn = new QueryDatabase(_DATABASE_HOST_,_DATABASE_USERNAME_,_DATABASE_PASSWORD_,_DATABASE_NAME_);
	$SystemMenuInfo = SystemGetMenuInfo($SysMenuID);
	
	
	$_SESSION['FRONT_SITECODE']="S0001";	

	$mid=trim($_REQUEST["mid"]);
?>
