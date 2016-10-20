function MySlide(objID , deley) {

		this.containerOBj = document.getElementById(objID);
		this.deley = deley * 1000; // Second
		this.stopFlag = false;
		this.activePosition = 0;
		this.lastActivePosition = -1;
		this.slideObj = this.containerOBj.getElementsByTagName("div");
		this.intervalID;
		this.timeOutID;
		

		
		this.init();
		this.startSlide();
		
}

MySlide.prototype.init = function() {

	var _self = this;
	
	var MouseTimeOut;
	var ChildNode = new Array();

	this.containerOBj.style.position = 'relative';
	this.containerOBj.style.overflow = 'hidden';
	
	if (this.containerOBj.style.paddingTop == "")	this.containerOBj.style.paddingTop = '0px';
	if (this.containerOBj.style.paddingLeft == "")	this.containerOBj.style.paddingLeft = '0px';
	
	this.containerOBj.onmouseover = function () { _self.stopSlide(); clearTimeout(MouseTimeOut); };
	this.containerOBj.onmouseout = function () { MouseTimeOut = setTimeout(function() { if (_self.stopFlag)  _self.resume(); } ,2);  };

	for(i=0;i<this.slideObj.length;i++) {
	
		if (this.slideObj[i].parentNode == this.containerOBj ) {
			this.slideObj[i].style.width = parseInt(this.containerOBj.style.width)+'px';
			this.slideObj[i].style.height = parseInt(this.containerOBj.style.height)+'px';
			this.slideObj[i].style.marginLeft = this.containerOBj.style.paddingLeft;
			this.slideObj[i].style.marginTop= this.containerOBj.style.paddingTop;
			this.slideObj[i].style.position = 'absolute';
	
			this.slideObj[i].style.top = parseInt(this.containerOBj.style.paddingTop)+parseInt(this.containerOBj.style.height)+'px';
	
			this.slideObj[i].style.left = '0px';
			
			ChildNode.push(this.slideObj[i]);
		}

	}
	
	this.slideObj = ChildNode;

}

MySlide.prototype.stopSlide = function() {

	this.slideObj[this.activePosition].style.top= '0px';
	this.stopFlag = true;
	clearInterval(this.intervalID);
	clearTimeout(this.timeOutID);

}

MySlide.prototype.resume = function() {
	this.stopFlag = false;
	this.startSlide();
}

MySlide.prototype.setNextPosition = function() {

		try {
			this.slideObj[this.lastActivePosition].style.top = parseInt(this.containerOBj.style.paddingTop)+parseInt(this.containerOBj.style.height)+'px';
		} catch (e) {}

		this.lastActivePosition = this.activePosition;
		if (this.activePosition == (this.slideObj.length)-1)
			this.activePosition = 0;
		else
			this.activePosition++;


}

MySlide.prototype.startSlide = function() {
	
	var _self = this;
	var IntervalID;
	var SubPX = 20;
	

		try {
			this.slideObj[this.activePosition].style.zIndex = 1;
			this.slideObj[this.lastActivePosition].style.zIndex = 0;
		} catch (e) {};
	

	this.intervalID = setInterval(function() {
				
											if (parseInt(_self.slideObj[_self.activePosition].style.top)-SubPX > 0) {
												_self.slideObj[_self.activePosition].style.top= (parseInt(_self.slideObj[_self.activePosition].style.top)-SubPX)+'px';
											
											} else {
											
												_self.slideObj[_self.activePosition].style.top= '0px';
												clearInterval(_self.intervalID);
												
												if (!_self.stopFlag) {
													
													_self.timeOutID = setTimeout(function() { _self.setNextPosition();_self.startSlide(); },_self.deley);
												}
												
											}
			
										},10);

	
}
