<?php
require("../../lib/system_core.php");



if (!empty($_FILES)) {
	
}

$file_name= 	$_FILES['file']['tmp_name'];  

	$storeFolder = '../'._SYSTEM_UPLOADS_FOLDER_.'/library';  
     
    $tempFile 	= 	$_FILES['file']['tmp_name'];   
	$targetPath	=	$storeFolder."/";
	$resizeObj 	= 	new ResizeImage($_FILES['file']["tmp_name"]);
	$extension 	= 	strtolower(strrchr($_FILES['file']['name'], '.'));
	
	$physical_name 	= md5($_FILES['file']['name'].date("His").rand(1,1000)).$extension;
	$targetFile =  $targetPath.$physical_name;
	//$resizeObj->resizeTo(200, 200, 'crop');
	//$resizeObj->resizeTo(1000,1460);
		$resizeObj->resizeTo(3000,3000);
	//$resizeObj->resizeTo(960,960);
	//$resizeObj->resizeTo(1024,1024,'maxwidth');
	$resizeObj->saveImage($targetFile);
	$filesize= filesize($targetFile);
	$size = getimagesize($targetFile);

	$insert="";
	$insert["site_code"] 			= "'S0001'";
	$insert["cate_id"] 				= "'".trim($_REQUEST['cate_id'])."'";
	$insert["file_name"] 			= "'".$_FILES['file']["name"]."'";
	$insert["physical_name"] 		= "'".$physical_name."'";
	$insert["file_type"] 			= "'".str_replace(".","",$extension)."'";
	$insert["file_size"] 			= "'".$filesize."'";
	$insert["file_width"] 			= "'".$size[0]."'";
	$insert["file_height"] 			= "'".$size[1]."'";
	
	$sql = "insert into library_file(".implode(",",array_keys($insert)).") values (".implode(",",array_values($insert)).")";
	$Conn->execute($sql);
	
	$FileID=$Conn->getInsertID();
	

echo "<script>parent.getSelectImg('$FileID');</script>";
?>
