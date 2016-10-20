<link href="../js/dropzone/css/dropzone.css" rel="stylesheet">
<script>
function getSelectImg<?=$ObjUFileID?>(_id){
	$.ajax({
		url : "../library/index-action.php",
		data : "ModuleAction=getFileUploadOne&file_id="+_id,
		type : "post",
		cache : false ,
		dataType: 'json',
		success : function(data){
			window.parent.$('#img_area<?=$ObjUFileID?>').attr('src','<?=_SYSTEM_UPLOADS_FOLDER_?>/library/'+data.physical_name);
		
			window.parent.$('#input_fileID<?=$ObjUFileID?>').val(data.file_id);
			window.parent.sys_modal_close();
		}
	});	
}

function SelectLibralyImg<?=$ObjUFileID?>(my){

	var _id=$(my).attr('id');
	_id=_id.replace('t_','');
	getSelectImg<?=$ObjUFileID?>(_id);
}
</script>

<div class="tabbable" >
    <ul class="nav nav-tabs" id="libraryTabs" style="font-size:20px;" >    
        <li class="active"><a href="#newupload"  data-toggle="tab"> &nbsp; อัพโหลด &nbsp;</a></li>
        <li><a href="#library" data-toggle="tab">เลือกจากคลังรูปภาพ</a></li>
    </ul>
 
    <div class="tab-content" >
        <div class="tab-pane active" id="newupload" style="height:500px;">
        <form action="../obj/objUploadPic/upload-one.php" target="up_iframe"  method="post" class="form-horizontal" enctype="multipart/form-data" >
        <input type="hidden" name="cate_id" value="editor" >
         <input type="hidden" name="ObjUFileID" value="<?=$ObjUFileID?>" >
         
          <input type="hidden" name="ObjUFileResizeType" value="<?=$ObjUFileResizeType?>" >
           <input type="hidden" name="ObjUFileResizeWidth" value="<?=$ObjUFileResizeWidth?>" >
            <input type="hidden" name="ObjUFileResizeHeight" value="<?=$ObjUFileResizeHeight?>" >
        <br />
<br />
<br />
<br />

       
<div class="control-group" style="margin-left:100px;">
<label class="control-label" for="product_name" style="font-size:20px;">เลือกไฟล์รูปภาพ : </label>
<div class="controls">
<input type="file"  name="file" value="<?=$Row["name"]?>" >
</div>
</div>
<div class="control-group" style="margin-left:100px;">
<div class="controls">
<button type="submit" class="btn btn-success" ><i class="icon-ok"></i> Upload </button>
</div>
</div>
        </form>
        	<iframe name="up_iframe" width="0" height="0" frameborder="0" style="height:0px; width:0px;"></iframe>
        
        </div>
        <div class="tab-pane" id="library" style="height:500px;">&nbsp;</div>
    </div>
</div>

<script>
    $(function() {
		$('#libraryTabs').bind('show', function(e) { 			
		   var pattern=/#.+/gi //use regex to get anchor(==selector)
		   var contentID = e.target.toString().match(pattern)[0]; //get anchor   
		   if(contentID=='#library'){
				var Vars=$('#file-select-photo').serialize();
				$(contentID).load('../library/index-action.php?ModuleAction=getLibraryList&ObjUFileID=<?=$ObjUFileID?>&'+Vars, function(){
					$('#libraryTabs').tab(); //reinitialize tabs
				});
		   }
		  
		});
		
    });	
</script>



<div class="clearfix">
<div class="line-control-footer"></div>
&nbsp; &nbsp; 
<script>
function iframe_closeModal(){
	 window.parent.sys_modal_close();
}

function library_ok_select(){
	var Vars=$('#file-select-photo').serialize();
	 window.parent.library_feedFileUpload(Vars);
}
</script>
<a class="btn"  href="javascript:iframe_closeModal();">Close</a>
</div>