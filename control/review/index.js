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

function submitFormContent(t) {
	CKupdate();
	var ObjPhotoID = "";
	$('#area_select_photo li').each(function(i){
			ObjPhotoID += $(this).attr('id')+'-';
	});
	$('#inputPhotoFileID').val(ObjPhotoID);
	
	if (validateFormContent()) {	
		var Vars=$('#frm').serialize();	
		$('#myModalLoading').modal('show');
		
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				if(t==1){
					window.location=window.location;
				}else if(t==2){
					window.location='index.php?'+$.trim(resp);
				}else{
					window.location='index.php?'+$('#SysModReturnURL').val();
				}	
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
	
	
	$('.btn_photo_view').live('click', function(e){	
		
		var _url=$(this).attr('href');
	
	
		var ObjPhotoID = "";
		$('#area_select_photo li').each(function(i){
			ObjPhotoID += $(this).attr('id')+'-';
		});
	
		_url+='&file_list='+ObjPhotoID;
									
		$(this).sys_modal({url:_url,modal_size:'modal-full'});		   
	 });
	
	$('.btn-status').live('click', function(e){	
				var element_link = $(this);
				var element = $(this).hasClass("dis");	
				var status="";
				if(element){	
					status="Y";
					$(this).removeClass("dis");
				}else{
					status="N";
					$(this).addClass("dis");
				}
				var Vars="ModuleAction=UpdateStatus";
				Vars+="&did="+$(this).attr('_did');
				Vars+="&status="+status;
				$.ajax({
					url : "index-action.php",
					data : Vars,
					type : "post",
					cache : false ,
					success : function(resp){	
					 	element_link.html($.trim(resp));		
					}
				});			
				 e.preventDefault();
	});
	
	
});


function sysListCateIDSearch(){ 
	$('#SysCateID').val($('#search_cateid').val());

	$('#SysPage').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}
