function mod_verifySortableCategories(){
	//sys_ShowLoading();
	var ObjID = "";
	var ObjOrder = "";
	$('#sortable-area li').each(function(i){
			ObjID += $(this).attr('id')+'-';
			ObjOrder += $(this).attr('rel')+'-';
	});
	
	var data_set = { ModuleAction: "UpdateSortable", DataID: ObjID, DataOrder: ObjOrder} ; 

	var url = "index-action.php";
	$.post( url , data_set , 
		function(resp){	
	
			window.location='index.php?'+$('#SysModReturnURL').val();
		  }
	);
}



function sysValidate(elm){
	
	if(elm.val()==""){	
		elm.parent().parent().addClass('error');
		return 1;
	}else{
		elm.parent().parent().removeClass('error');
		return 0;
	}
	
	
}


function validateFormContent() {

	var Check=0;
	
	$("#frm input.request").each(function(  ) {
		Check+=sysValidate($(this));
	})
	

	
	if(Check<1){
		return true;
	}else{
		return false;
	}	
}

function CKupdate(){
    for ( instance in CKEDITOR.instances ){
		  CKEDITOR.instances[instance].updateElement();
	}      
}

function submitFormContent() {
	CKupdate();
	var ObjPhotoID = "";
	$('#area_select_photo li').each(function(i){
			ObjPhotoID += $(this).attr('id')+'-';
	});
	$('#inputPhotoFileID').val(ObjPhotoID);
	
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
	$('#SysCateID').val($('#search_cateid').val());

	$('#SysPage').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}
