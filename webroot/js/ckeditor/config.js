/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.versionCheck = false;
	config.toolbarGroups = [
		{ name: 'document', groups: ['mode', 'document', 'doctools'] },
		{ name: 'clipboard', groups: ['clipboard', 'undo'] },
		{ name: 'insert', groups: ['insert'] },
		{ name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
		{ name: 'forms', groups: ['forms'] },
		{ name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
		{ name: 'links', groups: ['links'] },
		{ name: 'colors', groups: ['colors'] },
		{ name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
		{ name: 'styles', groups: ['styles'] },
		'/',
		{ name: 'tools', groups: ['tools'] },
		{ name: 'others', groups: ['others'] },
		{ name: 'about', groups: ['about'] }
	];

	config.removeButtons = 'Templates,Save,NewPage,ExportPdf,Preview,Print,PasteFromWord,SelectAll,Scayt,Checkbox,Radio,TextField,Form,Textarea,Select,Button,ImageButton,HiddenField,About,BulletedList,NumberedList,Outdent,Indent,Blockquote,CreateDiv,Anchor,Maximize,ShowBlocks';

    // Disable title attribute
    config.title = false;
	config.filebrowserUploadMethod = 'form';
	config.image_previewText = ' ';
	config.fileTools_requestHeaders = {
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
	config.allowedContent = 'iframe[*]';
	config.extraAllowedContent = 'iframe[*]';
};
