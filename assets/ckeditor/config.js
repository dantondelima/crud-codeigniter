/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
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
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
		config.removeButtons = 'Scayt,Save,NewPage,Preview,Source,Templates,Print,PasteFromWord,Find,SelectAll,Replace,Cut,Copy,Paste,PasteText,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Flash,Smiley,CreateDiv,Checkbox,Superscript,Subscript,Language,Anchor,SpecialChar,Iframe,Maximize,ShowBlocks,About';
        config.filebrowserBrowseUrl = '../assets/ckeditor/ckfinder/ckfinder.html';
        config.filebrowserImageBrowseUrl = '../assets/ckeditor/ckfinder/ckfinder.html?type=Images';
        config.filebrowserFlashBrowseUrl = '../assets/ckeditor/ckfinder/ckfinder.html?type=Flash';
        config.filebrowserUploadUrl = '../assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
        config.filebrowserImageUploadUrl = '../assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
        config.filebrowserFlashUploadUrl = '../assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};