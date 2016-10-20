function MyAccordion(ContainerID,headerClass,contentClass,ActivePos,ActiveClass,SubActiveClass) {

	this.ContentObj = new Array();
	this.ContentObj = $('#'+ContainerID+' .'+contentClass);
	
	this.HeaderObj = new Array();
	this.HeaderObj = $('#'+ContainerID+' .'+headerClass);
	
	for(var i=0;i<this.ContentObj.length;i++) {
		$(this.ContentObj[i]).hide();
	}
	
	if (ActivePos != "") {
		try {
			$("#"+ActivePos).parent().slideToggle('fast');
			document.getElementById(ActivePos).className = SubActiveClass;
			
			var pos = this.ContentObj.index($("#"+ActivePos).parent());
			this.HeaderObj[pos].className = ActiveClass;
		} catch (e) {}
		
	}

	for(var i=0;i<this.HeaderObj.length;i++) {
		var _self = this;
		var pos = i;
		$(this.HeaderObj[i]).click(function() {
											var pos = $(_self.HeaderObj).index(this);
											if ( jQuery.trim(_self.ContentObj[pos].innerHTML) != "")
												$(_self.ContentObj[pos]).slideToggle('fast');
											
											for (i=0;i<_self.ContentObj.size();i++) {
												if (i != pos)	{
													$(_self.ContentObj[i]).slideUp('fast');
												}
											}
											
										});
	}
}