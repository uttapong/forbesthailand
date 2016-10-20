// JavaScript Document
function systemOpenActionArea(content) {
	$('#action_area_content').html(content);
	$('#action_area').slideDown('slow');
	$('#container-main').slideUp('slow');
}
function systemCloseActionArea() {
	$('#action_area').slideUp('slow');
	$('#container-main').slideDown('slow');
	$('#action_area_content').html('');
}

function systemShowProgressBar() {
	$('#img_progressbar').show();
}
function systemHideProgressBar() {
	$('#img_progressbar').hide();
}