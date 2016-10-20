<?

if($ObjUFileWidth==""){
	$ObjUFileWidth=200;
}


if($ObjUFileOldPath==""){
	$ObjUFileOldPath="../img/photo_not_available.jpg";	
}
?>

<a id="btn_add_photo"  style="border:1px solid #ccc; display:inline-block;-moz-border-radius: 4px;-webkit-border-radius: 4px;
border-radius: 4px;"  data-toggle="modal" href="../obj/objUploadPic-prompt.php?ObjUFileID=<?=$ObjUFileID?>&ObjUFileType=<?=$ObjUFileType?>&ObjUFileResizeType=<?=$ObjUFileResizeType?>&ObjUFileResizeWidth=<?=$ObjUFileResizeWidth?>&ObjUFileResizeHeight=<?=$ObjUFileResizeHeight?>">
<img id="img_area<?=$ObjUFileID?>" src="<?=$ObjUFileOldPath?>" width="<?=$ObjUFileWidth?>" >
</a>
<input type="hidden" id="input_fileID<?=$ObjUFileID?>" name="input_fileID<?=$ObjUFileID?>"  >

<?
	unset($ObjUFileID);
	unset($ObjUFileType);
	unset($ObjUFileOldPath);
	unset($ObjUFileWidth);

	
	unset($ObjUFileResizeType);
	unset($ObjUFileResizeWidth);
	unset($ObjUFileResizeHeight);


?>
