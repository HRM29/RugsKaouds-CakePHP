/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/* CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
}; */


CKEDITOR.editorConfig = function( config ) {
	config.filebrowserBrowseUrl = 'http://notosolutions.net/rugsnc/webroot/js/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = 'http://notosolutions.net/rugsnc/webroot/js/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = 'http://notosolutions.net/rugsnc/webroot/js/ckfinder/ckfinder.html?type=Flash';
	
	config.filebrowserUploadUrl = 'http://notosolutions.net/crowdfunding/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = 'http://notosolutions.net/rugsnc/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = 'http://notosolutions.net/rugsnc/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
}
CKFinder.setupCKEditor( CKEDITOR, '../' );
