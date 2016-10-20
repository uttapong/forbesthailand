
function validateFormContent() {

	var Check=0;
	
	if(Check<1){
		return true;
	}else{
		return false;
	}	
}

function submitFormContent() {
	
	
	var ObjPhotoID = "";
	
	
	if (validateFormContent()) {	
		var Vars=$('#frm').serialize();	
	
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
			
				window.location='index.php?'+$('#SysModReturnURL').val();
			
			}
		});
	
	}else{
		alert('Please enter information.');	
	}
}


function setTestTab(){
	//$('#myTabs a[href="#home"]').tab('show');		
}

$(document).ready(function() {
	$('#btn_add_photo').live('click', function(e){						
				$(this).sys_modal({iframe:true,modal_size:'modal-iframe-full'});
			
	});	
	
	
	/*
$(document).ready(function() {
	library_getphoto('<?=$file_id?>')
});
	*/
	
	$('.btn_photo_view').live('click', function(e){	
		
		var _url=$(this).attr('href');
	
	
		var ObjPhotoID = "";
		$('#area_select_photo li').each(function(i){
			ObjPhotoID += $(this).attr('id')+'-';
		});
	
		_url+='&file_list='+ObjPhotoID;
									
		$(this).sys_modal({url:_url,modal_size:'modal-full'});		   
	 });
	
});


function sysListCateIDSearch(){ 
	$('#SysCateID').val($('#cate_id').val());
	alert($('#SysCateID').val());
	$('#SysPage').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}
