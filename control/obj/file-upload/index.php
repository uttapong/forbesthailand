<script src="../js/dropzone/dropzone.js"></script>
<link href="../js/dropzone/css/dropzone.css" rel="stylesheet">
<script>
function SelectImg(my){
	var _id=$(my).attr('id');
	_id=_id.replace('u_','');
	getSelectImg(_id,'u');
}
function SelectLibralyImg(my){
	var _id=$(my).attr('id');
	_id=_id.replace('t_','');

	getSelectImg(_id,'t');
}

function getSelectImg(_id,_type){
	
	var my=$('#'+_type+'_'+_id);
	
	var _class=$(my).attr('class');
	
	if(_type=='t'){
		//var _class_u=$('#u_'+id).attr('class');
		
		if(_class.indexOf("dz-success")=="-1"){
			$('#u_'+_id).addClass("dz-success");
		}else{
			$('#u_'+_id).removeClass("dz-success");
		}
	}
	
	if(_class.indexOf("dz-success")=="-1"){
		$(my).addClass("dz-success");
		
		$.ajax({
			url : "../library/index-action.php",
			data : "ModuleAction=getFileUpload&file_id="+_id,
			type : "post",
			cache : false ,
			
			success : function(resp){
				$('#area_pic_select').append(resp);
			}
		});	
	}else{
		$(my).removeClass("dz-success");
		$('#s_'+_id).remove();
	}
	
	
}

									  
$(document).ready(function() {
	$("#file-upload-photo").dropzone({ 
	   url: "../obj/file-upload/upload.php" ,
	   acceptedFiles: "image/*", /*is this correct?*/
	   success: function(file,serverFileID){ 
	   		
	   		serverFileID=jQuery.parseJSON(serverFileID);
			
		   	file.previewElement.classList.remove("dz-processing"); 
		 	var file1=file.previewElement;
		  	$(file1).attr('id',"u_"+serverFileID.file_id);
				
		
			file.previewElement.querySelector("[data-dz-size]").innerHTML =serverFileID.file_size;
			getSelectImg(serverFileID.file_id,'u');
		   },
	  });

 });

</script>
<div class="tabbable" >
    <ul class="nav nav-tabs" id="libraryTabs" style="font-size:20px;" >    
        <li class="active"><a href="#newupload"  data-toggle="tab"> &nbsp; อัพโหลด &nbsp;</a></li>
        <li><a href="#library" data-toggle="tab">เลือกจากคลังรูปภาพ</a></li>
    </ul>
 
    <div class="tab-content" >
        <div class="tab-pane active" id="newupload" style="height:400px;">
        <form action="../obj/file-upload/upload-one.php" target="up_iframe"  method="post" enctype="multipart/form-data" id="file-upload-photo"  class="dropzone" style="min-height:360px;">
        <input type="hidden" name="cate_id" value="store" >
       
        </form>
        	<iframe name="up_iframe" width="0" height="0" frameborder="0" style="height:0px; width:0px;"></iframe>
        
        </div>
        <div class="tab-pane" id="library" style="height:400px;">&nbsp;</div>
    </div>
</div>

<script>
    $(function() {
		$('#libraryTabs').bind('show', function(e) { 			
		   var pattern=/#.+/gi //use regex to get anchor(==selector)
		   var contentID = e.target.toString().match(pattern)[0]; //get anchor   
		   if(contentID=='#library'){
				var Vars=$('#file-select-photo').serialize();
				
				$(contentID).load('../library/index-action.php?ModuleAction=getLibraryList&Mod_Type=IMG&'+Vars, function(){
					$('#libraryTabs').tab(); //reinitialize tabs
				});
		   }
		  
		});
		
    });	
</script>

<form id="file-select-photo" style="margin:0" >
<div id="area_pic_select" class="row-fluid" style="background-color:#f8f8f8; min-height:70px; padding-top:8px;">
&nbsp;
</div>
</form>

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
<button type="submit" class="btn btn-success" onclick="library_ok_select();"><i class="icon-ok"></i> Insert Photo</button>

</div>