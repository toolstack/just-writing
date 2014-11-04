<?php
	if( is_admin() ) 
		{
		GLOBAL $wpdb;
		
		$wp_prefix = $wpdb->prefix;

		// Check to see if the "new" settings code is in place or not, if not, upgrade the old settings to the new system.
		if( get_option('just_writing_plugin_version') === FALSE ) 
			{
			$core_options = array( 'just_writing_enabled' => 'enabled', 'just_writing_bold' => 'bold', 'just_writing_italics' => 'italics', 'just_writing_ul' => 'ul', 'just_writing_nl' => 'nl', 'just_writing_quotes' => 'quotes', 'just_writing_media' => 'media', 'just_writing_link' => 'link', 'just_writing_unlink' => 'unlink', 'just_writing_strike' => 'strike', 'just_writing_under' => 'underline', 'just_writing_remove' => 'removeformat', 'just_writing_left' => 'left_justify', 'just_writing_center' => 'center_justify', 'just_writing_right' => 'right_justify', 'just_writing_justify' => 'full_justify', 'just_writing_outdent' => 'outdent', 'just_writing_indent' => 'indent', 'just_writing_p' => 'p_format', 'just_writing_h1' => 'h1_format', 'just_writing_h2' => 'h2_format', 'just_writing_h3' => 'h3_format', 'just_writing_h4' => 'h4_format', 'just_writing_h5' => 'h5_format', 'just_writing_h6' => 'h6_format', 'just_writing_address' => 'address_format', 'just_writing_pf' => 'pre_format', 'just_writing_spell' => 'spellcheck', 'just_writing_more' => 'more', 'just_writing_char' => 'char_map', 'just_writing_undo' => 'undo', 'just_writing_redo' => 'redo', 'just_writing_help' => 'help', 'just_writing_d_fade' => 'disable_fade', 'just_writing_h_wc' => 'hide_wordcount', 'just_writing_h_p' => 'hide_preview', 'just_writing_h_mb' => 'hide_modeselect', 'just_writing_al_new' => 'autoload_newposts', 'just_writing_al_edit' => 'autoload_editposts', 'just_writing_f_lb' => 'format_listbox', 'just_writing_superscript' => 'superscript', 'just_writing_subscript' => 'subscript', 'just_writing_cut' => 'cut', 'just_writing_copy' => 'copy', 'just_writing_paste' => 'paste', 'just_writing_pastetext' => 'pastetext', 'just_writing_pasteword' => 'pasteword', 'just_writing_separatorone' => 'separator_one', 'just_writing_separatortwo' => 'separator_two', 'just_writing_separatorthree' => 'separator_three', 'just_writing_separatorfour' => 'separator_four', 'just_writing_separatorfive' => 'separator_five', 'just_writing_separatorsix' => 'separator_six', 'just_writing_separatorseven' => 'separator_seven', 'just_writing_separatoreight' => 'separator_eight', 'just_writing_f_n' => 'font_name', 'just_writing_f_s' => 'font_size', 'just_writing_f_c' => 'font_color', 'just_writing_b_c' => 'background_color', 'just_writing_c_tb' => 'center_toolbar', 'just_writing_a_l' => 'add_DFWM_post_pages', 'just_writing_d_jscp' => 'disable_jscp', 'just_writing_browser_fs' => 'browser_fullscreen', 'just_writing_h_b' => 'hide_border', 'just_writing_l_b' => 'lighten_border', 'just_writing_quick_setting' => 'quick_settings'  );
			
			// Find all the users that currently have metadata set for Just Writing.
			$result = $wpdb->get_results( "SELECT DISTINCT `user_id` FROM {$wp_prefix}usermeta WHERE `meta_key` LIKE 'just_writing_%'" );
				
			// Loop through all the users we found
			foreach( $result as $user )
				{
				// Set the user ID to work with and load the options if there are any (there shouldn't be, but just in case).
				$JustWritingUtilities->set_user_id( $user->user_id );
				$JustWritingUtilities->load_user_options();
				
				// Handle the core options, we're going to strip off the 'just_writing_' header as we store them in the new settings array.
				foreach( $core_options as $option => $new_name ) {
					// Grab the option from the user meta table.  Noramlly we'd just use get_the_author_meta() but apparently it's too early to call that yet ;)
					$data = $wpdb->get_var( "SELECT meta_value FROM {$wp_prefix}usermeta WHERE meta_key = '{$option}' AND user_id = '{$user->user_id}'" );

					// Store the option in memory, we'll actually save it in the database shortly.
					$JustWritingUtilities->store_user_option( $new_name, $data );
					
					// Delete the old option.
					// delete_option( $option );
				}

				// Now that we've set all the options, save them to the database.
				$JustWritingUtilities->save_user_options();
			}
			
			// Now that we're done, reload the current users options so we can use them later on.
			$JustWritingUtilities->set_user_id( get_current_user_id() );
			$JustWritingUtilities->load_user_options();
		}
		
		// Store the new version information.
		update_option('just_writing_plugin_version', JustWritingVersion );
	}
?>