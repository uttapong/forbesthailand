
function validateFormContent() {

	var Check=0;
	
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
	
	if (validateFormContent()) {	
	
		var Vars=$('#frm').serialize();	
		
		$.ajax({
			url : "index-action.php",
			data : Vars,
			type : "post",
			cache : false ,
			
			success : function(resp){
				window.location='index.php';
			}
		});
	
	}else{
		alert('Please enter information.');	
	}
}