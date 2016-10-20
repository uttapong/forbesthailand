/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
 
 //config.filebrowserBrowseUrl = '../obj/file-upload-editor1.php';
/*
	config.filebrowserBrowseUrl = '../obj/file-upload-editor1.php';
	config.filebrowserImageBrowseUrl ='../obj/file-upload-editor.php',
	*/
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.filebrowserImageBrowseUrl = '../obj/file-upload-editor.php',
	config.filebrowserImageUploadUrl = '../obj/file-upload-editor.php',

		//CKEDITOR.config.contentsCss
	/*	
	 config.contentsCss = 'http://www.ecadigital.com/web/pttmcc/css/main.css',
	  */
	  config.allowedContent = true;
	  config.contentsCss = ['../../assets/css/ckeditor.css'];
	 
	 
	 config.autoParagraph=false;

	 config.height = '500px';
	 /*
	 config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];
	 */
};
