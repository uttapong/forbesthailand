function sys_modal_close(){
	$(".modal").modal("hide");
}

function library_remove_photo(my){
$(my).parents("div").parents("li").remove();
$('#area_num_photo').html($('.boxli_file_photo').length);

}


function library_remove_file(my){
$(my).parents("div").parents("li").remove();
$('#area_num_photo').html($('.boxli_file_all').length);
}



function library_getphoto(file_id,file_list){
	
		$('#area_show_photo').html('');
		var Vars="ModuleAction=getPhoto";	
		Vars+="&file_id="+file_id+"&file_list="+file_list;
		
		
		$.ajax({
			url : "../library/index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				
				$('#area_show_photo').html(resp);
				$('#area_text_photo').html($('#area_file_key').html());
			}
		});
	
}

function library_feedFileUpload(Vars){	
		$.ajax({
			url : "../library/index-action.php",
			data : "ModuleAction=feedFileUpload&"+Vars,
			type : "post",
			cache : false ,	
			success : function(resp){	
				$('#area_select_photo').append(resp);
				sys_modal_close();
				$('#area_num_photo').html($('.boxli_file_photo').length);
				
				
			}
		});		
}

function library_feedFileUploadAll(Vars){	
		$.ajax({
			url : "../library/index-action.php",
			data : "ModuleAction=feedFileUploadAll&"+Vars,
			type : "post",
			cache : false ,	
			success : function(resp){	
				$('#area_select_file').append(resp);
				sys_modal_close();
				$('#area_num_file').html($('.boxli_file_all').length);
				
				
			}
		});		
}
						   

function goClearText(id){
	
	$('#'+id).val('');
}


$.fn.sys_modal = function (option) {  
    return this.each(function () {
	
		var url = $(this).attr('href');
		
		if (typeof(option.url) != "undefined") {
			url=option.url;
		}
		
		var _iframe=false;
		if (typeof(option.iframe) != "undefined") {
			_iframe=true;
		}
		
		var _modal_size='';
		if (typeof(option.modal_size) != "undefined") {
			_modal_size=option.modal_size;
		}
		
	
		$('.modal').html('');
	
		if (url.indexOf('#') == 0) {
			
			$(url).modal('open');
			
		} else {
			
			if(_iframe==true){
		
				$('<div id="iframeModal" class="modal modal-dialog fade '+_modal_size+'" ><iframe id="iframe_modal" style="margin-left:5px;"  src="'+url+'" style="zoom:0.60" width="99.0%" height="99.8%" frameborder="0"></iframe></div>').modal();	
				
			}else{
				$.get(url, function(data) {			
					$('<div class="modal modal-dialog fade '+_modal_size+'"  >'+data+'</div>').modal();	
				}).success(function() { 
					$('input:text:visible:first').focus(); 
					if(typeof(option.fn)=='function'){
						$(option.fn);	
					}		
				});
			}
			
		}
	
	});	
  }
  



  
  