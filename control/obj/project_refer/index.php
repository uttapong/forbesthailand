<div class="modal-form" >
    <form id="frm-project"  style="margin:0; padding:0;" method="post" class="form-horizontal" onsubmit="return false;"> 
    
<div class="modal-header">
	<a class="close"  href="javascript:iframe_closeModal();">&times;</a>
	<h3>Select Project references</h3>
</div>
<div class="modal-body"  style="min-height:476px;">
<div class="clearfix">
<div class="input-prepend">
<span class="add-on"><i class="icon-search"></i></span>
<input type="text" id="input_search" name="input_search"  class="input-xlarge"  placeholder="search.." >
</div>

<div class="line-control-header"></div>
</div>
<div id="data_project_area"></div>

<script>

function loadDataProject(txt){
	
	var Vars='ModuleAction=loadDataProjectRefer&project_list=<?=$file_list?>&input_search='+txt;

		$.ajax({
			url : "../obj/project_refer/index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
				//alert(resp);
				$('#data_project_area').html(resp);
			}
		});
}


	
</script>


</div>
<script>
function iframe_closeModal(){
	 window.parent.sys_modal_close();
}

function project_select(){
	var Vars=$('#frm-project').serialize();
	 window.parent.project_selectList(Vars);
}

$(document).ready(function(){
	loadDataProject('');	
	$("#input_search").keyup(function( event ) {							
		loadDataProject($(this).val());						 
 });

 });
</script>
<div class="modal-footer">
	<a class="btn btn-primary" onclick="project_select();">Select Project</a>
	<a class="btn"  href="javascript:iframe_closeModal();">Close</a>
</div>
</form>
</div>