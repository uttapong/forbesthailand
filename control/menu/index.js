function mod_verifySortableCategories(){
	//sys_ShowLoading();
	var ObjID = "";
	var ObjOrder = "";
	$('#sortable-area li').each(function(i){
			ObjID += $(this).attr('id')+'-';
			ObjOrder += $(this).attr('rel')+'-';
	});
	
	var data_set = { ModuleAction: "UpdateSortableCategories", DataID: ObjID, DataOrder: ObjOrder} ; 

	var url = "index-action.php";
	$.post( url , data_set , 
		function(resp){
			window.location='index.php?'+$('#SysModReturnURL').val();
		  }
	);
	
	
}



function mod_changeMouduleCode(val){
	if(val=="link"){
		$('#area_weblink').show();
	}else{
		$('#area_weblink').hide();
	}
}

function mod_showMoreAndLess(action, Obj, Parent){
	if(action=="show-more"){
		$(Obj).removeClass('show-less').addClass('show-more');
		$('.parent-'+Parent).each(function(i){
			mod_showMoreAndLess(action, Obj, $(this).attr('rel'));
		});
		$('.parent-'+Parent).slideUp(300);
	}else{
		$(Obj).removeClass('show-more').addClass('show-less');
		$('.parent-'+Parent).each(function(i){
			mod_showMoreAndLess(action, Obj, $(this).attr('rel'));
		});
		$('.parent-'+Parent).slideDown(300);
	}
}


function sysDeleteCategory(id){	
	if(confirm("Delete?")){	
		var Vars='ModuleAction=DeleteData';
		Vars+="&id="+id;
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){	
		
				if($.trim(resp)=="Parent"){
					alert('Delete menu parent!');
					return false;
				}else{
					
					window.location=window.location;	
				}		
			}
		});
	}
}
$(document).ready(function() {
						   
						   
	$('.show-less').live('click', function(){									  
		var Obj = $(this).parents("div:eq(1)");	
		mod_showMoreAndLess('show-more', this, $(Obj).attr('rel'));
	});
	
	$('.show-more').live('click', function(){
		var Obj = $(this).parents("div:eq(1)");
		mod_showMoreAndLess('show-less', this, $(Obj).attr('rel'));
	});
	
	$('[data-toggle="dropdown"]').click(function(e) {
		var id = $(this).attr('id').replace('labelactionbtn-','');	
	
		var _str_action='';
		/*
		_str_action+='<li><a href="#">Enable</a></li>';
		_str_action+='<li><a href="#">Disable</a></li>';
		_str_action+='<li class="divider"></li>';
		*/
		_str_action+='<li ><a class="btn_edit" data-toggle="modal" href="index-action.php?'+$(this).attr('data-url-edit')+'">Edit</a></li>';
		_str_action+="<li><a href=\"javascript:sysDeleteCategory('"+id+"')\">Delete</a></li>";
		$('.dropdown-menu').html(_str_action);	
	});
	
	$('.btn_edit').live('click', function(e){
				$(this).sys_modal({});
	});
	$('#btn_add').live('click', function(e){						
				$(this).sys_modal({});
	});	
});



function validateFormContent() {

	var Check=0;
	/*
	$("#frmprompt .request").each(function() {
		Check += checkFormEmpty($(this).attr('id'));
	});
	*/

	if(Check<1){
		return true;
	}else{
		return false;
	}	
}

function submitFormContent() {

	if (validateFormContent()) {	
	
	
		var Vars=$('#frmprompt').serialize();
	
		Vars+="&level="+$('#parent_id option:selected').attr('data-level');
			
	
		//MyGlassBox.show();
		//MyGlassBox.setText(400,200,getHTML("index-prompt.php?PromptAction=PleaseWait"));	
		/* dataType: 'json', */
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			
			success : function(resp){
			
				window.location=window.location;
				
				/*
				if ( resp.error== "true") {
					MyGlassBox.setText(400,200,getHTML("index-prompt.php?PromptAction=InsertComplete&SysMenuID="+SysMenuID));	
				}else{
					MyGlassBox.close();
					if ( resp.error== "check_duplicate") {
						alert(resp.text);
						return false;
					}
				}
				*/
				
			}
		});
	
	}else{
		alert('Please enter information.');	
	}
}

$(document).ready(function() {
	
	/*
	$('#btn_add').live('click', function(e){						
				$(this).sys_modal({});
	});	
	*/
	
	$('#btn_photo_view').live('click', function(e){	
		$(this).sys_modal({modal_size:'modal-full'});		   
	 });
	
});
