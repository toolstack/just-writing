/* global tinymce */
/**
 * WP Fullscreen (Distraction-Free Writing) TinyMCE plugin
 */
tinymce.PluginManager.add( 'justwriting', function( editor ) {
	var settings = editor.settings;

	function gotoWritingMode() {
		var temp = window.location.href;
		var qsindex = temp.indexOf( 'wp-admin' );
		var post_id = jQuery('#post_ID').val();
		var adminurl = temp.substr( 0, qsindex ) + 'wp-admin/edit.php?page=JustWritingPost&post=' + post_id + '&action=edit';
	
		window.location.href = adminurl;
	}

	// Register buttons
	editor.addButton( 'justwriting', {
		tooltip: 'Writing mode',
		shortcut: 'Alt+Shift+W',
		onclick: gotoWritingMode,
		classes: 'btn widget justwritingtinymcebutton' // This overwrites all classes on the container!
	});

	editor.addMenuItem( 'justwriting', {
		text: 'Writing mode',
		icon: 'wp_fullscreen',
		shortcut: 'Alt+Shift+W',
		context: 'view',
		onclick: gotoWritingMode
	});
});
