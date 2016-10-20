<?php
require("../../lib/system_core.php");



if (!empty($_FILES)) {
	/*
	$sql = "SELECT filepath FROM library_folder";
	$sql.= " WHERE cate_id='".$_REQUEST['cate_id']."'";
	$Conn->query($sql);
	$ContentList = $Conn->getResult();
	$storeFolder= $ContentList[0]["filepath"];
	*/
	$storeFolder = '../'._SYSTEM_UPLOADS_FOLDER_.'/library';  
     
    $tempFile 	= 	$_FILES['file']['tmp_name'];   
	$targetPath	=	$storeFolder."/";
	
	
//copy($_FILES['file']["tmp_name"],$storeFolder.'/test.jpg');
	
	$extension 	= 	strtolower(strrchr($_FILES['file']['name'], '.'));	
	$physical_name 	= md5($_FILES['file']['name'].date("His").rand(1,1000)).$extension;
	$targetFile =  $targetPath.$physical_name;
	
	//copy($_FILES['file']["tmp_name"],$targetFile);
	move_uploaded_file($_FILES['file']["tmp_name"],$targetFile); 

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
			
	$a="";
	$a["file_size"]=SystemSizeFilter($filesize);
	$a["file_id"]=$Conn->getInsertID();
	echo  json_encode($a);
	
    //move_uploaded_file($tempFile,$targetFile); //6
     
}
?>
