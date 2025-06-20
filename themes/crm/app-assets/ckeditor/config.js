/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

config.entities = false;
config.entities_latin = false;
config.basicEntities = false;
config.forceSimpleAmpersand = true;
config.allowedContent=true;


config.enterMode = CKEDITOR.ENTER_BR // pressing the ENTER KEY input <br/>
config.shiftEnterMode = CKEDITOR.ENTER_P; //pressing the SHIFT + ENTER KEYS input <p>
config.autoParagraph = false;


	config.toolbar_MyToolbar =
	[
		{ name: 'document', items : [ 'Source' ] },
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },

	

	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker' ] },
	


	
	{ name: 'links', items : [ 'Link','Unlink' ] },
	{ name: 'insert', items : [ 'Image','Table','HorizontalRule','PageBreak' ] },
	'/',
	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] }
	];
};
