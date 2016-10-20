// JavaScript Document

function SystemLogin(url) {
	//alert($('#inputLoginUsername').val());
	if (!validateEmptyValue('inputLoginUsername')) {
		$('#inputLoginUsername').attr("className","focusTextbox");
		
		alert('Please enter information.');	
		
		return false;
	} else $('#inputLoginUsername').attr("className","defaultTextbox");
	
	if (!validateEmptyValue('inputLoginPassword')) {
		$('#inputLoginPassword').attr("className","focusTextbox");
		alert('Please enter information.');	
		return false;
	} else $('#inputLoginPassword').attr("className","defaultTextbox");
	$.ajax({
			url : "../authen/authentication.php",
			data : $('#loginfrm').serialize(),
			type : "post",
			cache : false ,
			dataType: 'json',
			success : function(resp) {
			
			if ( resp.error== "true") {	
					window.location='../dashboard/index.php?P=PUVETUVOVlBFbFVkdVZXVHpsM1U_';
				} else {
					alert('Login Fail');	
				}
			}
   });
}


function SystemGetSiteMapping(url) {
		$.ajax({
			url : "../authen/authentication.php",
			data : $('#sitefrm').serialize(),
			type : "post",
			cache : false ,
			dataType: 'json',
			success : function(resp) {	
				if ( resp.error== "true") {
					setTimeout('window.location="../masterfile/index.php"',1000);
				} else {
					alert("Error");
				}
			}
   });
	
	
}


function SystemLogout() {	
	MyGlassBox.show();
	MyGlassBox.setText(400,200,getHTML('../authen/authentication-prompt.php?PromptAction=Logout'));
	
}

function SystemSerialize(V_Objfrm)	{
	
	var EncodeStr = "";
	var DataArray = $(V_Objfrm).serializeArray();
	
	jQuery.each(DataArray , function(i,obj) {
									 
									 	EncodeStr += obj.name + "=" + encodeURIComponent( obj.value );
										EncodeStr += "&";
										
									 });
	
	return EncodeStr;
	
}

function validateLengthValue(ObjID,minLength,maxLength) {
	var Flag = false;
	var obj;
	
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		obj = document.getElementById(ObjID);
	}

	if (obj.value.length >= minLength && obj.value.length <= maxLength) {
		Flag = true;
	} 

	return Flag;
}

function validateEmptyValue(ObjID) {

	var Flag = true;
	var obj;
	
	ObjID=$('#'+ObjID);
	
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		//obj = document.getElementById(ObjID);
		obj = $(ObjID);
	}	
	obj.value = jQuery.trim(obj.val());
	if (obj.value == "") {
		obj.focus();
		Flag = false;
	} 
		
	return Flag;
}

function validateFileImageValue(ObjID) {
	var Flag = false;
	var obj;
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		obj = document.getElementById(ObjID);
	}
	
	var FileName = obj.value;
	
	var AllowExtension = "gif,jpg,jpeq,png";
	
	var FlieExtension = FileName.split(".");
	FlieExtension = FlieExtension[FlieExtension.length-1].toLowerCase();

	if (AllowExtension.indexOf(FlieExtension) >= 0) {
		Flag = true;
	} 
		
	return Flag;
}

function validateFileValue(ObjID) {
	var Flag = true;
	
	var obj;
	
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		obj = document.getElementById(ObjID);
	}
		
	var FileName = obj.value;
	
	var DenyExtension = "php,exe";
	
	var FlieExtension = FileName.split(".");
	FlieExtension = FlieExtension[FlieExtension.length-1].toLowerCase();

	if (DenyExtension.indexOf(FlieExtension) >= 0) {
		Flag = false;
	} 
		
	return Flag;
}
function validateEmail(ObjID){
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

   var Flag = true;
	var obj;
	
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		obj = document.getElementById(ObjID);
	}
	
	obj.value = jQuery.trim(obj.value);

	if (!emailPattern.test(obj.value)) {
		Flag = false;
	} 
		
	return Flag;
 }

function validateNumberOnly(ObjID){
   var emailPattern = /^[0-9]+$/;
   
   var Flag = true;
	var obj;
	
	try {
		ObjID.focus();
		obj = ObjID;	
	}
	catch (e) {
		obj = document.getElementById(ObjID);
	}
	
	obj.value = jQuery.trim(obj.value);

	if (!emailPattern.test(obj.value)) {
		Flag = false;
	}
	return Flag;
 }
 
function getHTML(url) {
	var html 	=	$.ajax({ url: url,  async: false ,cache:false , eval:true }).responseText	;
	return html;
}

//   Key press number Only
   
function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
  	return true;
}
// numbers
else if ((("0123456789").indexOf(keychar) > -1)) {
   return true;
}
   

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

function getPricePattern(str) {
	
	var V_str = str.replace(/[\,]/g,'');

	
	var StrNotDec = "";
	var StrDec = ""
	
	if (str.indexOf(".") >= 0)  {
		StrNotDec = V_str.substring(0,str.indexOf("."));
		StrDec = V_str.substring(V_str.indexOf("."),V_str.length);
	} else  {
		StrNotDec = V_str;
	}
		

	
	var length = StrNotDec.length;
	var loop = Math.ceil(length/3);
	
	var TempStr = StrNotDec;
	var ResultArr = new Array();
	
	for (i=0;i<loop;i++) {
		ResultArr.push(TempStr.substr(TempStr.length-3,TempStr.length) );
		TempStr=TempStr.substr(0,TempStr.length-3);
	}
	
	var NewStr = "";
	
	for (i=0;i<ResultArr.length;i++) {
		
		if (i>0) { NewStr =  ","+NewStr; } 
		
		NewStr = ResultArr[i]+NewStr; 
		
	}
	
	NewStr+= StrDec;
	
	
	return NewStr ;
}


function goSorting(fsort,sorder){
	$("#Page").val(1);
	$("#Fsort").val(fsort);
	$("#Sorder").val(sorder);
	$("#frmSearch").submit();
}


function goPage(my_page){
	$('#Page').val(my_page);
	$('#frmSearch').submit();	
}


function goSearch(){
	$('#Page').val(1);
	$('#frmSearch').submit();	
}

function goAjaxPage(my_page){
	goLoadAjaxPage(my_page);
}


function sys_popUpCal(v) {
    popUpCalendar(v, v, "dd/mm/yyyy",0);
}

function sys_popUpCalEvent(v,flag) {
    popUpCalendar(v, v, "dd/mm/yyyy",flag);
}

function checkFormEmpty(myValue){	

	var err=0;

	if (!validateEmptyValue(myValue)) {		
		$('#'+myValue).removeClass('defaultTextbox').addClass('focusTextbox');
		err=1;
	} else {
		$('#'+myValue).removeClass('focusTextbox').addClass('defaultTextbox');
		
	}

	return err;
}

function checkFormSelEmpty(myValue,mySelect){	

	var err=0;

	if (!validateEmptyValue(myValue)) {	
		$('#'+mySelect).attr("className","inputSelPopup_Err");
		err=1;
	} else {
		
		$('#'+mySelect).attr("className","inputSelPopup");
		
	}

	return err;
}


function checkFormCalendarEmpty(myValue){	

	var err=0;

	if (!validateEmptyValue(myValue)) {	
		$('#'+myValue).attr("className","focusCalendar");
		err=1;
	} else {
		$('#'+myValue).attr("className","Calendar");
		
	}

	return err;
}


	function number_format(id){
	
		$('#'+id).formatCurrency({ roundToDecimalPlace: 2, eventOnDecimalsEntered: true });
		
	}
	
	function price_format(id){
		if($('#'+id).val()=="NaN") $('#'+id).val(0);
		$('#'+id).formatCurrency();	
	}
	
	
	function price_format_2(id){
		if($('#'+id).val()=="NaN") $('#'+id).val(0);
		$('#'+id).formatCurrency({ roundToDecimalPlace: 5, eventOnDecimalsEntered: true });
		
		var tmp = $('#'+id).val();
		
		
		
		var tmp_arr=tmp.split(".");
		var tmp1=tmp_arr[1].substr(2,3);
		var tmp_price_2=tmp_arr[1].substr(0,2);
		var i;
		var tmp_price_3="";
		for (i=2;i>-1;i--){
			if(tmp1.substr(i,1)=="0"){
				tmp_price_3 = tmp1.substr(0,i);	
			}else{
				if(i==2) tmp_price_3=tmp1;
				break;	
			}	
		}
	
		var price =tmp_arr[0]+"."+tmp_price_2+tmp_price_3 ;
		
		if(tmp.indexOf('(') >-1){
					price+=")";		 
		}	
		$('#'+id).val(price);		
	}
	
	function clear_comma(val){	
		//val=val.toString();
		
		/*
			if (typeof val == "undefined") {
		val="0";
	}
	
	if(val==""  ) val="0";
	
	val=val.replace(/\,/g,"");
	try{ val = parseFloat(val);}
	catch(err){ }
	val=parseFloat(val);
	if(val<0 || isNaN(val) ) val=0;
	
	return val ; 
	*/
		
		try{ 
			var valPosi=0;	
			if(val.indexOf('(') >-1){
				valPosi=1;	 
			 }
			val = val.replace(',','');
			val = val.replace('(','');
			val = val.replace(')','');		
			
			if(valPosi>0){
				val = parseFloat('-'+val);
			}else{
				val = parseFloat(val);
			}
		}
		catch(err){ val=0; }
		return val ; 
	}

	function onCompleteCalendar(){
		alert(555);	
	}

/*#########################################################################*/
function getTotalPrice(){

	var i=0;
	var total=0;
	var amount=0;
	var subtotal1=0; // suntotal1 = amount - discount1
	var subtotal2=0; // suntotal2 = amount - discount1 -discount
	
	var discount1 = 0;
	var discountfirst=clear_comma($('#inputDiscountFirstPercentage').val()); // User Disocunt First for discount all	
		
	var grand_total=0;

	var price = 0;
	var qty = 0;
	var vat = 0;

	var chkerr=0;
	
	var grossA=0;
	
	var sumAmount=0;
	var sumDiscount1=0;
	var sumDiscount=0;
	var sumDiscountAll=0;
	var sumAmountBfVat=0;
	var sumVat=0;
	var sumTotal=0;
	
	for(i=1;i<$('#attach_file_id').val();i++){
		
		chkerr=1;
		
		if(typeof $('#inputPriceProductID'+i).val() == 'undefined'){
			chkerr=0;price=0;
		}else{
			price=clear_comma($('#inputPriceProductID'+i).val()); 
			price_format_2('inputPriceProductID'+i);
		}
		
		//try{ price=clear_comma($('#inputPriceProductID'+i).val());  }
		//catch(err){ chkerr=0;price=0; 	}
		
	
		
		if(chkerr>0){
			
				qty=clear_comma($('#inputQtyProductID'+i).val());
				price_format('inputQtyProductID'+i);
				
				/*1# Cal Amount*/
				if (qty==0 ||price==0) {
				amount = 0;	
				} else {
				amount=qty * price; 
				}
				$('#inputAmountProductID'+i).val(amount);
				price_format('inputAmountProductID'+i);
				/*END Cal Amount*/
				
				/*2# Cal Discount First*/
				if (discountfirst!=0) discount1 = amount * (discountfirst/100);			
				$('#inputDiscountFirstProductID'+i).val(discount1);
				price_format('inputDiscountFirstProductID'+i);
				subtotal1 = amount-discount1;					
				/*END Cal Discount First*/

				/*3# Function % Before Cal Descount 2*/
				if($('#inputDiscountProductID'+i).val().indexOf('%')>-1){	
					var discount=0;	
					discount=$('#inputDiscountProductID'+i).val().substring(1,$('#inputDiscountProductID'+i).val().length);
					/*User Subtotal1 = amount - discount1*/
					discount=(discount/100)*subtotal1;						
					$('#inputDiscountProductID'+i).val(discount);	
				}else{
					var discount=$('#inputDiscountProductID'+i).val();	
					
					discount=clear_comma(discount);
				}
				
				price_format('inputDiscountProductID'+i);
				subtotal2 = amount - discount1 - discount;
		
/* Type Vat in list	##############################################################*/
		if($('#inputTypeVat').val()==1){	 
	/* Vat Option Include ################*/				
					if($('#inputVatOptionProductID'+i).val()=="1"){ 
						//total=(amount-discount);
						total = subtotal2;
						var total_tmp=clear_comma($('#inputTotalProductID'+i).val())*1;
						
						if(total_tmp!=total){
							vat=$('#inputTaxPercentTotal').val();
							var vat_div=(vat*1)+100;
							if (total == 0) {
								vat = 0;
							} else {
								vat=(vat/vat_div)*total;
							}
							$('#inputItemVatProductID'+i).val(vat);	
							price_format('inputItemVatProductID'+i);	
						}else{

							vat =clear_comma($('#inputItemVatProductID'+i).val());
								price_format('inputItemVatProductID'+i);
						}
						
						grossA+= total-vat;
						$('#inputGrossAProductID'+i).val(total-vat);
						
						$('#inputTotalProductID'+i).val(total);
						price_format('inputTotalProductID'+i);
						
						sumTotal+=total; // Product summary line total
					
					}else if($('#inputVatOptionProductID'+i).val()=="2"){
		/* Vat Option N/A ################*/						
						//total=(amount-discount);
						total = subtotal2;
						vat =clear_comma($('#inputItemVatProductID'+i).val());
						$('#inputTotalProductID'+i).val(total);
						price_format('inputTotalProductID'+i);
					
						grossA+= total-vat;
						
						sumTotal+=total; // Product summary line total
					}else{
		/* Vat Option Exclude ################*/		
		
						//var grossA_New = amount-discount-discount1;
						var grossA_New = subtotal2
						var grossA_Old = clear_comma($('#inputGrossAProductID'+i).val());
		
			
							if(grossA_New!=grossA_Old){
								vat=$('#inputTaxPercentTotal').val();
								vat=(vat/100)*grossA_New;
								$('#inputItemVatProductID'+i).val(vat);	
								price_format('inputItemVatProductID'+i);		
							}else{
								vat =clear_comma($('#inputItemVatProductID'+i).val());
								price_format('inputItemVatProductID'+i);
							}
							
						
						
						grossA+=grossA_New;
						$('#inputGrossAProductID'+i).val(amount-discount-discount1);
						
						total=(vat*1)+(grossA_New);
						$('#inputTotalProductID'+i).val(total);
						price_format('inputTotalProductID'+i);
						sumTotal+=total; // Product summary line total
					}	
/*All Case Summary*/					
					sumVat+= vat;	
					sumDiscount1+=discount1;
					sumDiscount+=discount;					
					sumAmount+=amount;


/*END All Case Summary*/					
/*End Type Vat in list ##############################################################*/
				}else{ // Type Vat End
					//total=(amount*1)-(discount*1);	
					total=subtotal2;
					grand_total+=(total*1);
					$('#inputTotalProductID'+i).val(total);
					price_format('inputTotalProductID'+i);
				}		
				
		}  // END chkerr
		
	}// END OF FOR
			
			grossA=grossA*1;
			sumVat=sumVat*1;
			sumDiscountAll= (sumDiscount1*1)+(sumDiscount*1);
/*=======================================================================*/					
/*Amount #########################################*/
		if($('#inputTypeVat').val()>0){ // TVat > 0 (inc,exc,n/a)
			//$('#inputSubTotal').val(grossA);
			$('#inputSubTotal').val(sumAmount);
		}else{
			$('#inputSubTotal').val(grand_total);
		}
		price_format('inputSubTotal');
	
		var sub_total=clear_comma($('#inputSubTotal').val());
		
/*END Amount #########################################*/			
//Subtotal Has a data		
		if(typeof sub_total != 'undefined'){

			if($('#inputTypeVat').val()>0){ // TVat
					
				$('#inputDiscountTotal').val(sumDiscountAll);	
				price_format('inputDiscountTotal');	
				
				sumAmountBfVat = sumTotal - sumVat;
				/*
				sumAmountBfVat = sumAmount - sumDiscountAll;
				*/
				$('#inputAfterTotal').val(sumAmountBfVat);
				price_format('inputAfterTotal');
					
				$('#inputTaxTotal').val(sumVat);
				price_format('inputTaxTotal');
				
				$('#inputGrandTotal').val(sumTotal);				
				price_format('inputGrandTotal');				
				
			}else{
			
		
				if(flag_discount==1){
					discount=clear_comma($('#inputDiscountPercentTotal').val());
					discount=grand_total*(discount/100);
					
					$('#inputDiscountTotal').val(discount);		
					discount=clear_comma($('#inputDiscountTotal').val());		
					
					price_format('inputDiscountTotal');
				
				}else if(flag_discount==2){
					discount=clear_comma($('#inputDiscountTotal').val());	
					var discount_percent=0;
					discount_percent=(discount/grand_total)*100;
					
					$('#inputDiscountPercentTotal').val(discount_percent);	
					price_format('inputDiscountPercentTotal');
					discount=clear_comma($('#inputDiscountTotal').val());
					price_format('inputDiscountTotal');
				
				}else{
					
					discount=clear_comma($('#inputDiscountTotal').val()); 
					price_format('inputDiscountTotal');
				
				}
				
				//discount=clear_comma(discount);	
				
				discount=grand_total-discount;
			
				$('#inputAfterTotal').val(discount);
				price_format('inputAfterTotal');
							
				discount=clear_comma($('#inputAfterTotal').val())*(clear_comma($('#inputTaxPercentTotal').val())/100);	
				//GGGG
				$('#inputTaxTotal').val(discount);	
				
				price_format('inputTaxTotal');
			
				discount=clear_comma($('#inputAfterTotal').val())+discount;
				$('#inputGrandTotal').val(discount);
			}

			price_format('inputGrandTotal');
			
		}else{
			$('#inputDiscountPercentTotal').val('0.00');
			$('#inputDiscountTotal').val('0.00');
			$('#inputAfterTotal').val('0.00');
			$('#inputTaxTotal').val('0.00');
			$('#inputGrandTotal').val('0.00');
			
		}
	
}
/*#########################################################################*/


function removeFormField(id) {
	$('#area_list_prod_'+id).remove();
	$(".area_list_prod").each(function (index, elm) {							  
   		$(elm).html(index+1);		
 	 });	
}


function sysCheckCodeDuplicate(url,input){

	var url_action=url+"-action.php";
	var url_prompt=url+"-prompt.php";
	var err=0;
	
	var Vars='ModuleAction=CheckCodeDuplicate&Action='+$('#ModuleAction').val()+'&inputCode='+$('#'+input).val();	
	$.ajax({
			url:url_action,
			cache : false,
			data : Vars ,
			success : function(txt) {								
				if(txt=="Duplicate"){
					MyGlassBox.show();
					MyGlassBox.setText(400,200,getHTML(url_prompt+"?PromptAction=CodeDuplicate"));		
					err=1;
					return err;
				}else{
					return err;
				}		
			}
	   });
	
}


/* GOLF */


function sysListSearch(){	
	$('#Sys_Page').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}
function sysListSort(FSort,Sort){
	$('#Sys_FSort').val(FSort);
	$('#Sys_Sort').val(Sort);	
	sysListLoadDatalist($('#mySearch').serialize());
}

function sysShowLoading(){
	$('#overlayx').html('<div class="loading">Wait...</div>');
	$('#overlayx').show();
}

function sysHideLoading(){
	$('#overlayx').hide();
	$('#overlayx').html('');
}

function sysListLoadDatalist(val){

	var Vars = "ModuleAction=Datalist&"+val;
	//sysShowLoading();
	
	$.ajax({
		url : $('#SysModURL').val(),
		data : Vars,
		type : "post",
		cache : false ,
		success : function(resp) {
			//sysHideLoading();
			
			$("#datalist-content").html(resp);
			
			$('.icheckbox').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square',
				increaseArea: '20%' // optional
			  });
			
			
			$( "#input_search" ).keypress(function( event ) {
			  if ( event.which == 13 ) {
				 event.preventDefault();
				sysListTextSearch();
			  }
			 });
			
		}
	});	
}

function sysListPage(page){ 
	
	if(parseInt(page)>parseInt($('#SysTotalPageCount').val())){
		page=$('#SysTotalPageCount').val();
	}
	
	$('#SysPage').val(page);
	
	sysListLoadDatalist($('#mySearch').serialize());
}

function sysListGOPage(){ 
	var page=$('#GoToPage').val();
	if(parseInt(page)>parseInt($('#SysTotalPageCount').val())){
		page=$('#SysTotalPageCount').val();
	}
	
	$('#SysPage').val(page);
	sysListLoadDatalist($('#mySearch').serialize());
}

function sysListPerPage(PageSize){ 

	$('#SysPageSize').val(PageSize);
	$('#SysPage').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}


function sysListTextSearch(){ 
	$('#SysTextSearch').val($('#input_search').val());
	$('#SysPage').val(1);
	sysListLoadDatalist($('#mySearch').serialize());
}

function sysSort(myfield,vsort){ 
	$('#SysFSort').val(myfield);
	$('#SysSort').val(vsort);
	sysListLoadDatalist($('#mySearch').serialize());
}




function sysChangelang(lang){
	/*
	if(lang=='TH'){
		lang='EN';	
	}else{
		lang='TH';
	}
	*/
	
	var Vars="ModuleAction=ChangeLang";	
		Vars+="&Lang="+lang;
		$.ajax({
			url : "../authen/authentication.php",
			data : Vars,
			type : "post",
			cache : false ,
			success : function(resp){
					//window.location=window.location;
					window.location='../dashboard/';
			}
		});
	
}