<?php
require("../../lib/system_core.php");


if (!empty($_FILES)) {
	
	$storeFolder = '../'._SYSTEM_UPLOADS_FOLDER_.'/library';  
	
	$tempFile 		= $_FILES['userfile']['tmp_name'];   
	$extension 		= strtolower(strrchr($_FILES['userfile']['name'], '.'));
	
	
	$targetPath		= $storeFolder."/";
	$physical_name 	= md5($_FILES['userfile']['name'].date("His").rand(1,1000)).$extension;
	$targetFile 	= $targetPath.$physical_name;
	
	
	copy($_FILES['userfile']["tmp_name"],$targetFile);
	
	
	$filesize= filesize($targetFile);
	
	$insert="";
	$insert["site_code"] 			= "'S0001'";
	$insert["cate_id"] 				= "'media'";
	$insert["file_name"] 			= "'".$_FILES['userfile']["name"]."'";
	$insert["physical_name"] 		= "'".$physical_name."'";
	$insert["file_type"] 			= "'".str_replace(".","",$extension)."'";
	$insert["file_size"] 			= "'".$filesize."'";
	/*
	$insert["file_width"] 			= "'".$size[0]."'";
	$insert["file_height"] 			= "'".$size[1]."'";
	*/
	
	$sql = "insert into library_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
	$Conn->execute($sql);
	
	$FileID=$Conn->getInsertID();
	
	
	
	
	$a="";
	$a["physical_name"]=$physical_name;
	$a["file_name"]=$_FILES['userfile']['name'];
	$a["file_size"]=SystemSizeFilter($filesize);
	$a["file_id"]=$FileID;
	echo  json_encode($a);
     
}
?>
