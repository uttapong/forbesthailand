<?
include("../lib/session.php");
include("../lib/config.php");
include("../lib/function.php");
include("../lib/connect.php");
header('Content-Type: text/html; charset=utf-8');
Sys_decodeURL($_SERVER["QUERY_STRING"]);
if($action=="updateDowload"){
	$sql = "UPDATE "._TABLE_DOWNLOAD_." SET "._TABLE_DOWNLOAD_."_COUNT = ("._TABLE_DOWNLOAD_."_COUNT + 1) WHERE "._TABLE_DOWNLOAD_."_ID = '" .$did. "'";
	$result = Sys_QueryExecute($sql);
	exit;
}else if($action=="OneFiles"){
	

	
	
	$sql = "SELECT * FROM "._TABLE_DOWNLOAD_;
	$sql.= " WHERE 1=1 ";
	$sql.= " AND "._TABLE_DOWNLOAD_."_ID='".$did."'  AND "._TABLE_DOWNLOAD_."_STATUS='Enable' ";

	$dataObject = Sys_QuerySelect($sql);
	$QueryArray = Sys_getQueryArray($dataObject);
	$Row = $QueryArray[0];
	
	
		
	if($Row[_TABLE_DOWNLOAD_."_DATAID"]>0){
				
		$sql = "SELECT menu_MODULEKEY FROM menu ";
		$sql.= " WHERE 1=1 ";
		$sql.= " AND menu_ID='".$Row[_TABLE_DOWNLOAD_."_MENUID"]."'  AND menu_STATUS='Enable' ";
	
		$dataObject = Sys_QuerySelect($sql);
		$QueryArray = Sys_getQueryArray($dataObject);
	
		if($QueryArray[0]["menu_MODULEKEY"]==""){
			$_check_disable=1;
		}

		if($QueryArray[0]["menu_MODULEKEY"]=="cms"){
		
			$sql = "SELECT count(*) as CNT FROM cms ";
			$sql.= " WHERE 1=1 ";
			$sql.= " AND cms_ID='".$Row[_TABLE_DOWNLOAD_."_DATAID"]."'  AND cms_Status='Enable' ";
		
			$dataObject = Sys_QuerySelect($sql);
			$QueryArray = Sys_getQueryArray($dataObject);
	
			
			if($QueryArray[0]["CNT"]<1){
				$_check_disable=1;
			}	
		}	
		
		
	}
	
	if($_check_disable>0){
		$Row[_TABLE_DOWNLOAD_."_FILETYPE"]="";
		$Row[_TABLE_DOWNLOAD_."_FILENAME"]="";
		$Row[_TABLE_DOWNLOAD_."_NAME"]="";
	}

	$targetFile= _STRUCTURE_DOWNLOAD_.$Row[_TABLE_DOWNLOAD_."_FILENAME"]; 
	$fileNameArr = explode(".",$Row[_TABLE_DOWNLOAD_."_NAME"]);
	$Fname = str_replace(" ","-",$fileNameArr[0]).".".$Row[_TABLE_DOWNLOAD_."_FILETYPE"];
	
	$sql_count = "UPDATE "._TABLE_DOWNLOAD_." SET "._TABLE_DOWNLOAD_."_COUNT = ("._TABLE_DOWNLOAD_."_COUNT + 1) WHERE "._TABLE_DOWNLOAD_."_ID = '" .$did. "' ";
	
	
	$result = Sys_QueryExecute($sql_count);

	
	if(strtolower($Row[_TABLE_DOWNLOAD_."_FILETYPE"])=="pdf"){ 
            header('Cache-Control: public'); // needed for i.e.
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.basename($Fname).'"');
			//header('Content-Length: ' . filesize($targetFile)); 
            readfile($targetFile);
            die(); // stop execution of further script because we are only outputting the pdf
	}else{
	
	
	if(strtolower($Row[_TABLE_DOWNLOAD_."_FILETYPE"])=="zip")
	{ 	
			/*require "zip.class.php";
			$zipfile = new zipfile; // Create an object
			$zipfile->create_dir(""); // Add a subdirectory - must be done.  If a subdirectory is not wanted, just simply add one named "." as shown here
			
			$zipfile->create_file(file_get_contents($targetFile),$Fname); // Add the data of the file that is wanted, and the full path to it in the zip.
	
			// Allow user to download file
			header("Content-type: application/zip");
			header("Content-disposition: attachment;filename=\"".$Fname."\"");
			echo $zipfile->zipped_file();*/
			//$targetFile =$Fname;
			$filename=$Fname;
			@header("Content-type: application/zip");
			@header("Content-Disposition: attachment; filename=$filename");
			echo file_get_contents($targetFile);		
			
			exit;
			
	}
	if(strtolower($Row[_TABLE_DOWNLOAD_."_FILETYPE"])=="rar")
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
	
}else if($action=="AllFiles"){
	$sql = "SELECT * FROM "._TABLE_DOC_;
	$sql.= " INNER JOIN "._TABLE_FILES_." ON("._TABLE_DOC_."_ID="._TABLE_FILES_."_DOCID) ";
	$sql.= " WHERE 1=1 ";
	$sql.= " AND "._TABLE_DOC_."_ID='".$DocID."' ";
	$sql.= " AND "._TABLE_DOC_."_STATUS='Enable' ";
	$sql.= " AND "._TABLE_FILES_."_STATUS='show' ";
	$sql.= " ORDER BY "._TABLE_FILES_."_ORDER DESC";

	$dataObject = Sys_QuerySelect($sql);
	$RecordCount = Sys_getRecordCount($dataObject);
	$QueryArray = Sys_getQueryArray($dataObject);
	
	$Topic="";
	
	if($RecordCount>0){
		include("../object/archiveExtractor/zip_file.php");
		$zipfile = new zipfile();
		$zipName=_STRUCTURE_DOWNLOAD_TEMP_."Allfile-".date("d-m-Y-H-s-i").".zip";
		 
		foreach($QueryArray as $Row) { 
			$Topic=$Row[_TABLE_DOC_."_NAME"];
			$file_size = filesize($Row[_TABLE_FILES_."_PATH"]);
			$fp = fopen($Row[_TABLE_FILES_."_PATH"],"r");
			$content = fread($fp,$file_size);
			fclose($fp);
			$zipfile -> add_file($content,$Row[_TABLE_FILES_."_ORINAME"]);
		}
		
		$fp = fopen($zipName, "wb");
		$out = fwrite($fp, $zipfile -> file());
		fclose($fp);



		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename(str_replace(" ","-",$Topic).".zip"));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
        header("Content-Transfer-Encoding: binary ");
		header('Content-Length: ' . filesize($zipName));
		ob_clean();
		flush();
		readfile($zipName);
		unlink($zipName);
		exit;
	}

}
?>