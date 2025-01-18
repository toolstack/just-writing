<?php
/*
Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'Just_Writing_User_Setup' ) )
	{
	/*
	 	This function is called to setup the user preferences for the first time.
	*/
	Function Just_Writing_User_Setup( $user_id )
		{
		GLOBAL $JustWritingUtilities;

		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

		// Set the current user and load the user preferences.
		$JustWritingUtilities->set_user_id( $user_id );
		$JustWritingUtilities->load_user_options();

		// Set the defaults.
		$JustWritingUtilities->store_user_option( 'enabled', 'on' );
		$JustWritingUtilities->store_user_option( 'quick_setting', 'jwdefault' );
		$JustWritingUtilities->store_user_option( 'bold', 'on' );
		$JustWritingUtilities->store_user_option( 'italics', 'on' );
		$JustWritingUtilities->store_user_option( 'ul', 'on' );
		$JustWritingUtilities->store_user_option( 'nl', 'on' );
		$JustWritingUtilities->store_user_option( 'media', 'on' );
		$JustWritingUtilities->store_user_option( 'link', 'on' );
		$JustWritingUtilities->store_user_option( 'unlink', 'on' );
		$JustWritingUtilities->store_user_option( 'strike', 'on' );
		$JustWritingUtilities->store_user_option( 'underline', 'on' );
		$JustWritingUtilities->store_user_option( 'removeformat', 'on' );
		$JustWritingUtilities->store_user_option( 'left_justify', 'on' );
		$JustWritingUtilities->store_user_option( 'center_justify', 'on' );
		$JustWritingUtilities->store_user_option( 'right_justify', 'on' );
		$JustWritingUtilities->store_user_option( 'full_justify', 'off' );
		$JustWritingUtilities->store_user_option( 'outdent', 'on' );
		$JustWritingUtilities->store_user_option( 'indent', 'on' );
		$JustWritingUtilities->store_user_option( 'spellcheck', 'on' );
		$JustWritingUtilities->store_user_option( 'more', 'on' );
		$JustWritingUtilities->store_user_option( 'char_map', 'off' );
		$JustWritingUtilities->store_user_option( 'undo', 'on' );
		$JustWritingUtilities->store_user_option( 'redo', 'on' );
		$JustWritingUtilities->store_user_option( 'help', 'off' );
		$JustWritingUtilities->store_user_option( 'disable_fade', 'off' );
		$JustWritingUtilities->store_user_option( 'hide_wordcount', 'off' );
		$JustWritingUtilities->store_user_option( 'hide_preview', 'off' );
		$JustWritingUtilities->store_user_option( 'hide_border', 'off' );
		$JustWritingUtilities->store_user_option( 'lighten_border', 'on' );
		$JustWritingUtilities->store_user_option( 'hide_modeselect', 'off' );
		$JustWritingUtilities->store_user_option( 'autoload_editposts', 'off' );
		$JustWritingUtilities->store_user_option( 'autoload_newposts', 'off' );
		$JustWritingUtilities->store_user_option( 'format_listbox', 'on' );
		$JustWritingUtilities->store_user_option( 'superscript', 'off' );
		$JustWritingUtilities->store_user_option( 'subscript', 'off' );
		$JustWritingUtilities->store_user_option( 'cut', 'off' );
		$JustWritingUtilities->store_user_option( 'copy', 'off' );
		$JustWritingUtilities->store_user_option( 'paste', 'off' );
		$JustWritingUtilities->store_user_option( 'pastetext', 'off' );
		$JustWritingUtilities->store_user_option( 'pasteword', 'off' );
		$JustWritingUtilities->store_user_option( 'separator_one', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_two', 'off' );
		$JustWritingUtilities->store_user_option( 'separator_three', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_four', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_five', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_six', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_seven', 'on' );
		$JustWritingUtilities->store_user_option( 'separator_eight', 'on' );
		$JustWritingUtilities->store_user_option( 'font_name', 'off' );
		$JustWritingUtilities->store_user_option( 'font_size', 'off' );
		$JustWritingUtilities->store_user_option( 'font_color', 'off' );
		$JustWritingUtilities->store_user_option( 'background_color', 'off' );
		$JustWritingUtilities->store_user_option( 'center_toolbar', 'on' );
		
		// Write them to the database.
		$JustWritingUtilities->save_user_options();
		
		// Reset the current user id for the utilities class back to the current user.
		$JustWritingUtilities->set_user_id( get_current_user_id() );

		}
	}
?>
