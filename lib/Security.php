<?
	
	if (empty($_SESSION['SessionUserID'])) {
		ob_clean();
		header("Location:../");
	}
?>