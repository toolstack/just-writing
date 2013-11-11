<?php
/*
Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'Just_Writing_User_Setup' ) )
	{
	/*
	 *	This function is called to setup the user preferences for the first time.
	 */
	Function Just_Writing_User_Setup( $user_id )
		{
		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
		update_user_meta( $user_id, 'just_writing_enabled', 'on' );
		update_user_meta( $user_id, 'just_writing_bold', 'on' );
		update_user_meta( $user_id, 'just_writing_italics', 'on' );
		update_user_meta( $user_id, 'just_writing_ul', 'on' );
		update_user_meta( $user_id, 'just_writing_nl', 'on' );
		update_user_meta( $user_id, 'just_writing_quotes', 'on' );
		update_user_meta( $user_id, 'just_writing_media', 'on' );
		update_user_meta( $user_id, 'just_writing_link', 'on' );
		update_user_meta( $user_id, 'just_writing_unlink', 'on' );
		update_user_meta( $user_id, 'just_writing_strike', 'on' );
		update_user_meta( $user_id, 'just_writing_under', 'on' );
		update_user_meta( $user_id, 'just_writing_remove', 'on' );
		update_user_meta( $user_id, 'just_writing_left', 'on' );
		update_user_meta( $user_id, 'just_writing_center', 'on' );
		update_user_meta( $user_id, 'just_writing_right', 'on' );
		update_user_meta( $user_id, 'just_writing_outdent', 'on' );
		update_user_meta( $user_id, 'just_writing_indent', 'on' );
		update_user_meta( $user_id, 'just_writing_p', 'on' );
		update_user_meta( $user_id, 'just_writing_h1', 'on' );
		update_user_meta( $user_id, 'just_writing_h2', 'on' );
		update_user_meta( $user_id, 'just_writing_h3', 'on' );
		update_user_meta( $user_id, 'just_writing_h4', 'on' );
		update_user_meta( $user_id, 'just_writing_h5', 'on' );
		update_user_meta( $user_id, 'just_writing_h6', 'on' );
		update_user_meta( $user_id, 'just_writing_address', 'on' );
		update_user_meta( $user_id, 'just_writing_pf', 'on' );
		update_user_meta( $user_id, 'just_writing_spell', 'on' );
		update_user_meta( $user_id, 'just_writing_more', 'on' );
		update_user_meta( $user_id, 'just_writing_char', 'on' );
		update_user_meta( $user_id, 'just_writing_undo', 'on' );
		update_user_meta( $user_id, 'just_writing_redo', 'on' );
		update_user_meta( $user_id, 'just_writing_help', 'off' );
		update_user_meta( $user_id, 'just_writing_d_fade', 'off' );
		update_user_meta( $user_id, 'just_writing_h_wc', 'off' );
		update_user_meta( $user_id, 'just_writing_h_p', 'off' );
		update_user_meta( $user_id, 'just_writing_h_b', 'off' );
		update_user_meta( $user_id, 'just_writing_l_b', 'off' );
		update_user_meta( $user_id, 'just_writing_h_mb', 'off' );
		update_user_meta( $user_id, 'just_writing_al_edit', 'off' );
		update_user_meta( $user_id, 'just_writing_al_new', 'off' );
		update_user_meta( $user_id, 'just_writing_f_lb', 'on' );
		update_user_meta( $user_id, 'just_writing_superscript', 'on' );
		update_user_meta( $user_id, 'just_writing_subscript', 'on' );
		update_user_meta( $user_id, 'just_writing_cut', 'off' );
		update_user_meta( $user_id, 'just_writing_copy', 'off' );
		update_user_meta( $user_id, 'just_writing_paste', 'off' );
		update_user_meta( $user_id, 'just_writing_pastetext', 'off' );
		update_user_meta( $user_id, 'just_writing_pasteword', 'off' );
		update_user_meta( $user_id, 'just_writing_separatorone', 'off' );
		update_user_meta( $user_id, 'just_writing_separatortwo', 'on' );
		update_user_meta( $user_id, 'just_writing_separatorthree', 'on' );
		update_user_meta( $user_id, 'just_writing_separatorfour', 'on' );
		update_user_meta( $user_id, 'just_writing_separatorfive', 'on' );
		update_user_meta( $user_id, 'just_writing_separatorsix', 'on' );
		update_user_meta( $user_id, 'just_writing_separatorseven', 'on' );
		update_user_meta( $user_id, 'just_writing_separatoreight', 'off' );
		update_user_meta( $user_id, 'just_writing_f_n', 'off' );
		update_user_meta( $user_id, 'just_writing_f_s', 'off' );
		update_user_meta( $user_id, 'just_writing_f_c', 'off' );
		update_user_meta( $user_id, 'just_writing_b_c', 'off' );
		update_user_meta( $user_id, 'just_writing_c_tb', 'on' );
		}
	}
?>
