<?
require("../lib/system_core.php");
header('Content-Type: text/html; charset=utf-8');
if($_REQUEST['ModuleAction']!=""){
	$ModuleAction = $_REQUEST['ModuleAction'];
	$SysMenuID=$_POST["SysMenuID"];
	$ModuleDataID = $_REQUEST['ModuleDataID'];
}

if($ModuleAction=="updateDowload"){
	
}else if($ModuleAction=="OneFiles"){
	
	
	if($SysModType=="PRODUCT"){
		$sql = "SELECT * from products_file ";
		$sql.= " WHERE id='".$DID."'";
	
		$Conn->query($sql);
		$FileList = $Conn->getResult();
		$RowFile=$FileList[0];
	
		$targetFile=_SYSTEM_UPLOADS_FOLDER_."/products/".$RowFile["physical_name"];
		$fileNameArr = explode(".",$RowFile["file_name"]);
		$Fname = str_replace(" ","-",$fileNameArr[0]).".".$RowFile["file_type"];
	
	}


	if(strtolower($RowFile["file_type"])=="pdf"){ 
            header('Cache-Control: public'); // needed for i.e.
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.basename($Fname).'"');
			//header('Content-Length: ' . filesize($targetFile)); 
            readfile($targetFile);
            die(); // stop execution of further script because we are only outputting the pdf
	}else{
	
	
	if(strtolower($RowFile["file_type"])=="zip")
	{ 			
			$filename=$Fname;
			@header("Content-type: application/zip");
			@header("Content-Disposition: attachment; filename=$filename");
			echo file_get_contents($targetFile);		
			
			exit;
			
	}
	if(strtolower($RowFile["file_type"])=="rar")
	{ 	?>
	
			<script type="text/javascript">
		window.location = '<?php echo $targetFile;?>';
		</script>	
			
	<?php
			exit();
	}
	
	else{
		header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: ".$ctype.";");
               // header("Content-Disposition: attachment; filename=".basename($Fname).";");
				header("Content-Disposition: attachment; filename=\"$Fname\"");
                header("Content-Transfer-Encoding: binary ");
                header("Content-Length: ".filesize($targetFile));
                readfile($targetFile);
		exit;
	}
	
	}
	exit;
	
}else if($ModuleAction=="AllFiles"){
	

}
?>