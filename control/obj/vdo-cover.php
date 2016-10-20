<div class="control-group">
<label class="control-label" for="product_display"> Image or VDO Content</label>
<div class="controls">
<?
$flag_media= $Row["flag_media"];
if($flag_media==""){
	$flag_media="UPLOADPIC";
}
?>
<input type="hidden" id="input_flag_media" name="input_flag_media" value="<?=$flag_media?>" >
<ul class="nav nav-tabs" >
	<li class="active" ><a href="#piccontent" id="UPLOADPIC" data-toggle="tab">Upload Image</a></li>
	<li ><a href="#home" id="UPLOADFILE" data-toggle="tab">Upload FIle Video</a></li>
	<li><a href="#profile" id="EMBED"  data-toggle="tab">Url Youtube</a></li>
    <li><a href="#ndisplay" id="NODISPLAY"  data-toggle="tab">No display</a></li>
</ul>
<div class="tab-content">
	
    <div class="tab-pane" id="piccontent">
<?
          
			$ObjUFileID="OnePicContent";
			$ObjUFileType="onepic";
			$img="../../uploads/cover/".$Row["filepiccontent"];
			if ((is_file($img) && file_exists($img) )) {
				$ObjUFileOldPath=$img;
			}
			
			include('../obj/objUploadPic/index.php'); 
            ?>
  </div>

  <div class="tab-pane " id="home">
  <a href="#" class="btn btn-primary" style="display:<? if( $Row["filemedia_physical"] !="" ){ ?>none; <? } ?>" id="btnUPLOADFILE">Browes FIle Video</a>
  <div id="area_uploading" class="progress progress-striped active" style="width:200px; display:none;">
  <div class="bar" style="width: 80%;">Uploading</div> </div>
  
  <div id="area_box_file" style="display:<? if($Row["filemedia_physical"] =="" ){ ?>none;<? } ?>"><span class="label label-warning">
  <i class="icon-film"></i> <span id="area_filename"><?=$Row["filemedia_name"]?> (<?=SystemSizeFilter($Row["filemedia_size"])?>)</span>  <i></i> 
 
  </span>
   <a _id="15" href="javascript:removeFileMedia()" data-toggle="tooltip" title="" class="btn btn-mini btn-danger btn-del" data-original-title="Delete"><i class="icon-remove"></i></a>
  </div> 
  
  <input type="hidden" id="input_fileid_media" name="input_fileid_media" >
   <input type="hidden" id="input_file_media_old" name="input_file_media_old" value="<?=$Row["filemedia_physical"]?>" >
   <br> <br>
  </div>
  <div class="tab-pane" id="profile">
  	<textarea id="input_embed_code"  name="input_embed_code" class="input-xxlarge" rows="4" ><?=$Row["embed_code"]?></textarea>
  </div>
  
   <div class="tab-pane" id="ndisplay">
  	No display  Image and VDO.
    <br>
<br>

  </div>

</div>
<script>
$('a[data-toggle="tab"]').on('shown', function (e) {
  e.target // activated tab
  e.relatedTarget // previous tab
 $('#input_flag_media').val($(this).attr('id'));
})

function removeFileMedia(){	
	 if (confirm('Delete?')) { 
		 
	$('#btnUPLOADFILE').show();
	$('#area_box_file').hide();
	
	$('#input_fileid_media').val('');
	$('#input_file_media_old').val('');
		/* 
		var Vars="ModuleAction=DeleteData&id="+$(this).attr('_id');
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				window.location=window.location;
			}
		});
		*/
	 }	
	
}


</script>

  <script type="text/javascript">

	$(document).ready(function(){
	
		$('#<?=$flag_media?>').tab('show');	
		
		var id_tab_content=$('#<?=$flag_media?>').attr("href");
		$(id_tab_content).addClass('active');	
							   

		new AjaxUpload('btnUPLOADFILE', {
            action: '../obj/objUploadMedia/upload.php?mod=<?=$ObjAttachFileMod?>',
			onSubmit : function(file , ext){
			
				if(ext=="mp4"){
					
					$('#btnUPLOADFILE').hide();
					$('#area_uploading').show();
				}else{
					
					return false;	
				}
				
				
				},
			onComplete : function(file,data){
				
				
				var obj = jQuery.parseJSON(data);
				
				$('#area_uploading').hide();
				$('#area_box_file').show();
				$('#area_filename').html(obj.file_name+' ('+obj.file_size+')');
				
				$('#input_fileid_media').val(obj.file_id);
				
				//$('#input<?=$ObjAttachFile_ID?><?=$index?>').val(data);
				
				//$('#<?=$ObjAttachFile_ID?>_filename<?=$index?>').html(file);
				
			}		
		});
		
	  	  
	});
                                
   </script>
   

</div>
</div>