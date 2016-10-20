function mod_verifySortableCategories(){
	//sys_ShowLoading();
	var ObjID = "";
	var ObjOrder = "";
	$('#sortable-area li').each(function(i){
			ObjID += $(this).attr('id')+'-';
			ObjOrder += $(this).attr('rel')+'-';
	});
	var data_set = { ModuleAction: "UpdateSortableCategories", DataID: ObjID, DataOrder: ObjOrder} ; 
	
	var url = "category-action.php";
	$.post( url , data_set , 
		function(resp){
			window.location='category.php?'+$('#SysModReturnURL').val();
		  }
	);
	
}



function mod_verifyDeleteCategories(){
	sys_ShowLoading();
	var MENUID = $('#MENUID').val();
	var data_set = { Sys_Action: "DeleteCategories",DataID: $('#DataID').val(),MENUID:MENUID} ;
	var url = "index-do.php";
	$.post( url , data_set , 
		function(resp){
			mod_getCategories($('#Sys_DataID').val());
			sys_HideLoading();
			sys_CloseDialog();
		}
	);
}

function mod_getCategories(ObjID){
	sys_ShowLoading();
	var data_set = { Sys_Action: "Categories",DataID: ObjID} ;
	var url = "index-do.php";
	$.post( url , data_set , 
		function(resp){
			$('.menuDiv').remove();
			$('.menu').remove();
			$('#categories-content').html(resp);
			sys_HideLoading();
		}
	);
}

function mod_getFormCat(){
	sys_OpenDialog('index-do.php?Sys_Action=FormNewCategories&Sys_DataID='+$('#Sys_DataID').val(), 520);
}
function mod_verifyCatFormSubmit(){
	if($("#inputCatParent option").length==0){
		alert("You need permission to perform this action");
		sys_CloseDialog();
	}else{
		sys_ShowLoading();
		var Error=0;
		Error +=sys_CheckFormEmpty('inputCatName');
		if(Error>0){
			sys_HideLoading();
		}else{
			mod_setParent();
			$('#myCatForm').submit();
		}
	}
}
function mod_getTabInfo(ObjID){
	sys_ShowLoading();
	$('#Sys_DataID').val(ObjID);
	mod_getCategories(ObjID);
	sys_HideLoading();
}
function mod_setParent(){
	var selected = $("#inputCatParent option:selected"); 
    if(selected.val() != 0 && selected.val() !="none"){
        $('#inputCatLevel').val(selected.attr('rel'));
    }else{
		$('#inputCatLevel').val('0');
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

function mod_activeSelectPic(Obj){
	$('#icon-set img').removeClass('_border-active').addClass('_border');
	$(Obj).addClass('_border-active');
	$('#inputModule').val($(Obj).attr('id'));
}



/* */
function mod_taskActionLabelMenu(el, id ){

	var status = $(el).attr("status");
	$('#actionlabel li').removeClass('list-checked');
	$('#actionlabel li#'+status).addClass('list-checked');
	
	var cmenu = new sys_mttMenu('actionlabel', id, {onclick:mod_ActionLabelMenuClick});
	cmenu.show(el);
}

















function mod_ActionLabelMenuClick(el, ObjID){

	if(el.id=="Edit"){
		sys_OpenDialog('index-do.php?Sys_Action=FormEditCategories&Sys_DataID='+$('#Sys_DataID').val()+'&DataID='+ObjID+'&PID='+$('#labelactionbtn-'+ObjID).attr('rel'), 520);
	}else if(el.id=="Enable" || el.id=="Disable"){
			
		var data_set = { Sys_Action: "UpdateCatStatus", Sys_DataID:ObjID, inputValue: el.id} ;
		var url = "index-do.php";
		$.post( url , data_set , 
			function(resp){
				resp=$.trim(resp);
				if(resp=="Enable"){
					$('#box-'+ObjID).removeClass('Disable').addClass('Enable');
				}else{
					$('#box-'+ObjID).removeClass('Enable').addClass('Disable');
				}
				$('#labelactionbtn-'+ObjID).attr("status",resp);
				sys_HideLoading();
			}
		);
	}else if(el.id=="Delete"){
		mod_DeletedCategories(ObjID);
	}
}

function mod_setTypeMenu(ObjVal){
	$('#TypeMenu li').removeClass('list-checked active-list');
	$('#TypeMenu li#'+ObjVal).addClass('list-checked active-list');
				
	$('.OptTypeModule').slideUp(200);
	if(ObjVal=="Group"){
		$('#inputTypeMenu').val('2');
	}else if(ObjVal=="Link"){
		$('#inputTypeMenu').val('1');
		$('#TypeLink').slideDown(500);
		$('#inputURL').focus();
	}else {
		$('#inputTypeMenu').val('0');
		$('#TypeModule').slideDown(500);
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
		_str_action+='<li><a href="#">Enable</a></li>';
		_str_action+='<li><a href="#">Disable</a></li>';
		_str_action+='<li class="divider"></li>';
		_str_action+='<li ><a class="btn_edit" data-toggle="modal" href="category-action.php?'+$(this).attr('data-url-edit')+'">Edit</a></li>';
		_str_action+='<li><a href="#">Delete</a></li>';
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
	$("#frmprompt .request").each(function() {
		Check += checkFormEmpty($(this).attr('id'));
	});
	
	

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
		
		$.ajax({
			url : "category-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			
			success : function(resp){
			
				
				window.location=window.location;
			
				
			}
		});
	
	}else{
		alert('Please enter information.');	
	}
}