jQuery( document ).ready( function() { QTags.addButton('justwriting', 'Writing', gotoWritingMode ); } );

function gotoWritingMode() {
	var temp = window.location.href;
	var qsindex = temp.indexOf( 'wp-admin' );
	var post_id = jQuery('#post_ID').val();
	var adminurl = temp.substr( 0, qsindex ) + 'wp-admin/edit.php?page=JustWritingPost&post=' + post_id + '&action=edit';

	window.location.href = adminurl;
}

