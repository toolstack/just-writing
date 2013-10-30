<?php
/*
Plugin Name: Just Writing
Version: 2.7
Plugin URI: http://toolstack.com/just-writing
Author: Greg Ross
Author URI: http://toolstack.com
Description: Adds more buttons to the distraction free writing mode command bar.

Compatible with WordPress 3.5+.

Read the accompanying readme.txt file for instructions and documentation.

Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'JustWriting' ) )
	{
	/*
	 *	This function is called to add the new buttons to the distraction free
	 *  writing mode.
	 *	It's registered at the end of the file with an add_action() call.
	 */
	function JustWriting( $oldbuttons )
		{
		$cuid = get_current_user_id();
		
		// clear out the default buttons
		$buttons = array();
		
		if( get_the_author_meta( 'just_writing_cut', $cuid ) == 'on' )
			{
			$buttons['cut'] = array( 
												// Title of the button
												'title' => __('Cut (Ctrl + X)'), 
												// Command to execute
												'onclick' => "tinyMCE.execCommand('cut');", 
												// Show on visual AND html mode
												'both' => true 
								);
			}
			
		if( get_the_author_meta( 'just_writing_copy', $cuid ) == 'on' )
			{
			$buttons['copy'] = array( 
												// Title of the button
												'title' => __('Copy (Ctrl + C)'), 
												// Command to execute
												'onclick' => "tinyMCE.execCommand('copy');", 
												// Show on visual AND html mode
												'both' => true 
								);
			}
			
		if( get_the_author_meta( 'just_writing_paste', $cuid ) == 'on' )
			{
			$buttons['paste'] = array( 
												// Title of the button
												'title' => __('Paste (Ctrl + V)'), 
												// Command to execute
												'onclick' => "tinyMCE.execCommand('paste');", 
												// Show on visual AND html mode
												'both' => true 
								);
			}

		if( get_the_author_meta( 'just_writing_pastetext', $cuid ) == 'on' )
			{
			$buttons['pastetext'] = array( 
												// Title of the button
												'title' => __('Paste as Text'), 
												// Command to execute
												'onclick' => "tinyMCE.execCommand('mcePasteText');", 
												// Show on visual AND html mode
												'both' => false
								);
			}

		if( get_the_author_meta( 'just_writing_pasteword', $cuid ) == 'on' )
			{
			$buttons['pasteword'] = array( 
												// Title of the button
												'title' => __('Paste as Text'), 
												// Command to execute
												'onclick' => "tinyMCE.execCommand('mcePasteWord');", 
												// Show on visual AND html mode
												'both' => false
								);
			}

		if( get_the_author_meta( 'just_writing_bold', $cuid ) == 'on' )
			{
			$buttons['bold'] = array( 
											// Title of the button
											'title' => __('Bold (Ctrl + B)'), 
											// Command to execute
											'onclick' => 'fullscreen.b();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
			
		if( get_the_author_meta( 'just_writing_italics', $cuid ) == 'on' )
			{
			$buttons['italic'] = array( 
											// Title of the button
											'title' => __('Italic (Ctrl + I)'), 
											// Command to execute
											'onclick' => 'fullscreen.i();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
			
		if( get_the_author_meta( 'just_writing_strike', $cuid ) == 'on' )
			{
			$buttons['strikethrough'] = array(
											// Title of the button
											'title' => __('Strikethrough (Alt + Shift + D)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'strikethrough');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_under', $cuid ) == 'on' )
			{
			$buttons['underline'] = array(
											// Title of the button
											'title' => __('Underline (Alt + Shift + U)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'underline');",
											// Show on visual AND html mode
											'both' => false
										);
			}

		if( get_the_author_meta( 'just_writing_subscript', $cuid ) == 'on' )
			{
			$buttons['subscript'] = array(
											// Title of the button
											'title' => __('Subscript'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'subscript');",
											// Show on visual AND html mode
											'both' => false
										);
			}

		if( get_the_author_meta( 'just_writing_superscript', $cuid ) == 'on' )
			{
			$buttons['superscript'] = array(
											// Title of the button
											'title' => __('Superscript'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'superscript');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_remove', $cuid ) == 'on' )
			{
			$buttons['removeformat'] = array(
											// Title of the button
											'title' => __('Remove Format (Alt + Shift + O)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('removeformat');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_ul', $cuid ) == 'on' )
			{
			$buttons['bullist'] = array( 
											// Title of the button
											'title' => __('Unordered list (Alt + Shift + U)'), 
											// Command to execute
											'onclick' => 'fullscreen.ul();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( get_the_author_meta( 'just_writing_nl', $cuid ) == 'on' )
			{
			$buttons['numlist'] = array( 
											// Title of the button
											'title' => __('Ordered list (Alt + Shift + O)'),
											// Command to execute
											'onclick' => 'fullscreen.ol();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( get_the_author_meta( 'just_writing_media', $cuid ) == 'on' )
			{
			$buttons['image'] = array( 
											// Title of the button
											'title' => __('Insert/edit image (Alt + Shift + M)'), 
											// Command to execute
											'onclick' => "fullscreen.medialib();", 
											// Show on visual AND html mode
											'both' => true 
							);
			}
							
		if( get_the_author_meta( 'just_writing_link', $cuid ) == 'on' )
			{
			$buttons['link'] = array( 
											// Title of the button
											'title' => __('Insert/edit link (Alt + Shift + A)'), 
											// Command to execute
											'onclick' => 'fullscreen.link();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( get_the_author_meta( 'just_writing_unlink', $cuid ) == 'on' )
			{
			$buttons['unlink'] = array( 
											// Title of the button
											'title' => __('Unlink (Alt + Shift + S)'), 
											// Command to execute
											'onclick' => 'fullscreen.unlink();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
		
		if( get_the_author_meta( 'just_writing_left', $cuid ) == 'on' )
			{
			$buttons['justifyleft'] = array(
											// Title of the button
											'title' => __('Align Left (Alt + Shift + L)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('justifyleft');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_center', $cuid ) == 'on' )
			{
			$buttons['justifyfull'] = array(
											// Title of the button
											'title' => __('Align Full (Alt + Shift + C)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('justifyfull');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_right', $cuid ) == 'on' )
			{
			$buttons['justifyright'] = array(
											// Title of the button
											'title' => __('Align Right (Alt + Shift + R)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('justifyright');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_outdent', $cuid ) == 'on' )
			{
			$buttons['outdent'] = array(
											// Title of the button
											'title' => __('Outdent'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('outdent');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_indent', $cuid ) == 'on' )
			{
			$buttons['indent'] = array(
											// Title of the button
											'title' => __('Indent'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('indent');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_p', $cuid ) == 'on' || get_the_author_meta( 'just_writing_f_lb', $cuid ) == 'on' )
			{
			$buttons['Paragraph'] = array(
											// Title of the button
											'title' => __('Paragraph'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'p');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_f_lb', $cuid ) != 'on' )
			{
			if( get_the_author_meta( 'just_writing_h1', $cuid ) == 'on' )
				{
				$buttons['H1'] = array(
												// Title of the button
												'title' => __('H1'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h1');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_h2', $cuid ) == 'on' )
				{
				$buttons['H2'] = array(
												// Title of the button
												'title' => __('H2'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h2');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_h3', $cuid ) == 'on' )
				{
				$buttons['H3'] = array(
												// Title of the button
												'title' => __('H3'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h3');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_h4', $cuid ) == 'on' )
				{
				$buttons['H4'] = array(
												// Title of the button
												'title' => __('H4'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h4');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_h5', $cuid ) == 'on' )
				{
				$buttons['H5'] = array(
												// Title of the button
												'title' => __('H5'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h5');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_h6', $cuid ) == 'on' )
				{
				$buttons['H6'] = array(
												// Title of the button
												'title' => __('H6'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h6');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_quotes', $cuid ) == 'on' )
				{
				$buttons['blockquote'] = array( 
												// Title of the button
												'title' => __('Blockquote (Alt + Shift + Q)'), 
												// Command to execute
												'onclick' => 'fullscreen.blockquote();', 
												// Show on visual AND html mode
												'both' => false 
								);
				}
								
			if( get_the_author_meta( 'just_writing_address', $cuid ) == 'on' )
				{
				$buttons['Address'] = array(
												// Title of the button
												'title' => __('Address'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'address');",
												// Show on visual AND html mode
												'both' => false
											);
				}
				
			if( get_the_author_meta( 'just_writing_pf', $cuid ) == 'on' )
				{
				$buttons['Preformatted'] = array(
												// Title of the button
												'title' => __('Preformatted'),
												// Command to execute
												'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'pre');",
												// Show on visual AND html mode
												'both' => false
											);
				}
			}
			
		if( get_the_author_meta( 'just_writing_spell', $cuid ) == 'on' )
			{
			$buttons['spellchecker'] = array(
											// Title of the button
											'title' => __('Proofread Writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('mceWritingImprovementTool');",
											// Show on visual AND html mode
											'both' => true
										);
			}
			
		if( get_the_author_meta( 'just_writing_more', $cuid ) == 'on' )
			{
			$buttons['wp_more'] = array(
											// Title of the button
											'title' => __('Insert More Tag (Alt + Shift + T)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('WP_More');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_char', $cuid ) == 'on' )
			{
			$buttons['charmap'] = array(
											// Title of the button
											'title' => __('Insert custom character'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('mceCharMap');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( get_the_author_meta( 'just_writing_undo', $cuid ) == 'on' )
			{
			$buttons['undo'] = array(
											// Title of the button
											'title' => __('Undo (Ctrl + Z)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('undo');",
											// Show on visual AND html mode
											'both' => true
										);
			}
			
		if( get_the_author_meta( 'just_writing_redo', $cuid ) == 'on' )
			{
			$buttons['redo'] = array(
											// Title of the button
											'title' => __('Redo (Ctrl + Y)'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('redo');",
											// Show on visual AND html mode
											'both' => true
										);
			}
			
		if( get_the_author_meta( 'just_writing_help', $cuid ) == 'on' )
			{
			$buttons['help'] = array( 
											// Title of the button
											'title' => __('Help (Alt + Shift + H)'), 
											// Command to execute
											'onclick' => 'fullscreen.help();', 
											// Show on visual AND html mode
											'both' => false 
									);
			}

		return $buttons;
		}

	/*
	 *	This function returns either on or off depending on the state of an HTML checkbox 
	 *  input field returned from a post command.
	 */
	function just_writing_get_checked_state( $value )
		{
		if( $value == 'on' ) 
			{
			return 'on';
			}
		else
			{
			return 'off';
			}
		}
	
	/*
	 *	This function is called to save the user profile settings for Just Writing.
	 */
	function just_writing_save_user_profile_fields( $user_id )
		{
		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
		update_user_meta( $user_id, 'just_writing_enabled', just_writing_get_checked_state( $_POST['just_writing_enabled'] ) );
		update_user_meta( $user_id, 'just_writing_bold', just_writing_get_checked_state( $_POST['just_writing_bold'] ) );
		update_user_meta( $user_id, 'just_writing_italics', just_writing_get_checked_state( $_POST['just_writing_italics'] ) );
		update_user_meta( $user_id, 'just_writing_ul', just_writing_get_checked_state( $_POST['just_writing_ul'] ) );
		update_user_meta( $user_id, 'just_writing_nl', just_writing_get_checked_state( $_POST['just_writing_nl'] ) );
		update_user_meta( $user_id, 'just_writing_quotes', just_writing_get_checked_state( $_POST['just_writing_quotes'] ) );
		update_user_meta( $user_id, 'just_writing_media', just_writing_get_checked_state( $_POST['just_writing_media'] ) );
		update_user_meta( $user_id, 'just_writing_link', just_writing_get_checked_state( $_POST['just_writing_link'] ) );
		update_user_meta( $user_id, 'just_writing_unlink', just_writing_get_checked_state( $_POST['just_writing_unlink'] ) );
		update_user_meta( $user_id, 'just_writing_strike', just_writing_get_checked_state( $_POST['just_writing_strike'] ) );
		update_user_meta( $user_id, 'just_writing_under', just_writing_get_checked_state( $_POST['just_writing_under'] ) );
		update_user_meta( $user_id, 'just_writing_remove', just_writing_get_checked_state( $_POST['just_writing_remove'] ) );
		update_user_meta( $user_id, 'just_writing_left', just_writing_get_checked_state( $_POST['just_writing_left'] ) );
		update_user_meta( $user_id, 'just_writing_center', just_writing_get_checked_state( $_POST['just_writing_center'] ) );
		update_user_meta( $user_id, 'just_writing_right', just_writing_get_checked_state( $_POST['just_writing_right'] ) );
		update_user_meta( $user_id, 'just_writing_outdent', just_writing_get_checked_state( $_POST['just_writing_outdent'] ) );
		update_user_meta( $user_id, 'just_writing_indent', just_writing_get_checked_state( $_POST['just_writing_indent'] ) );
		update_user_meta( $user_id, 'just_writing_p', just_writing_get_checked_state( $_POST['just_writing_p'] ) );
		update_user_meta( $user_id, 'just_writing_h1', just_writing_get_checked_state( $_POST['just_writing_h1'] ) );
		update_user_meta( $user_id, 'just_writing_h2', just_writing_get_checked_state( $_POST['just_writing_h2'] ) );
		update_user_meta( $user_id, 'just_writing_h3', just_writing_get_checked_state( $_POST['just_writing_h3'] ) );
		update_user_meta( $user_id, 'just_writing_h4', just_writing_get_checked_state( $_POST['just_writing_h4'] ) );
		update_user_meta( $user_id, 'just_writing_h5', just_writing_get_checked_state( $_POST['just_writing_h5'] ) );
		update_user_meta( $user_id, 'just_writing_h6', just_writing_get_checked_state( $_POST['just_writing_h6'] ) );
		update_user_meta( $user_id, 'just_writing_address', just_writing_get_checked_state( $_POST['just_writing_address'] ) );
		update_user_meta( $user_id, 'just_writing_pf', just_writing_get_checked_state( $_POST['just_writing_pf'] ) );
		update_user_meta( $user_id, 'just_writing_spell', just_writing_get_checked_state( $_POST['just_writing_spell'] ) );
		update_user_meta( $user_id, 'just_writing_more', just_writing_get_checked_state( $_POST['just_writing_more'] ) );
		update_user_meta( $user_id, 'just_writing_char', just_writing_get_checked_state( $_POST['just_writing_char'] ) );
		update_user_meta( $user_id, 'just_writing_undo', just_writing_get_checked_state( $_POST['just_writing_undo'] ) );
		update_user_meta( $user_id, 'just_writing_redo', just_writing_get_checked_state( $_POST['just_writing_redo'] ) );
		update_user_meta( $user_id, 'just_writing_help', just_writing_get_checked_state( $_POST['just_writing_help'] ) );
		update_user_meta( $user_id, 'just_writing_d_fade', just_writing_get_checked_state( $_POST['just_writing_d_fade'] ) );
		update_user_meta( $user_id, 'just_writing_h_wc', just_writing_get_checked_state( $_POST['just_writing_h_wc'] ) );
		update_user_meta( $user_id, 'just_writing_h_p', just_writing_get_checked_state( $_POST['just_writing_h_p'] ) );
		update_user_meta( $user_id, 'just_writing_h_mb', just_writing_get_checked_state( $_POST['just_writing_h_mb'] ) );
		update_user_meta( $user_id, 'just_writing_al_new', just_writing_get_checked_state( $_POST['just_writing_al_new'] ) );
		update_user_meta( $user_id, 'just_writing_al_edit', just_writing_get_checked_state( $_POST['just_writing_al_edit'] ) );
		update_user_meta( $user_id, 'just_writing_f_lb', just_writing_get_checked_state( $_POST['just_writing_f_lb'] ) );
		update_user_meta( $user_id, 'just_writing_superscript', just_writing_get_checked_state( $_POST['just_writing_superscript'] ) );
		update_user_meta( $user_id, 'just_writing_subscript', just_writing_get_checked_state( $_POST['just_writing_subscript'] ) );
		update_user_meta( $user_id, 'just_writing_cut', just_writing_get_checked_state( $_POST['just_writing_cut'] ) );
		update_user_meta( $user_id, 'just_writing_copy', just_writing_get_checked_state( $_POST['just_writing_copy'] ) );
		update_user_meta( $user_id, 'just_writing_paste', just_writing_get_checked_state( $_POST['just_writing_paste'] ) );
		update_user_meta( $user_id, 'just_writing_pastetext', just_writing_get_checked_state( $_POST['just_writing_pastetext'] ) );
		update_user_meta( $user_id, 'just_writing_pasteword', just_writing_get_checked_state( $_POST['just_writing_pasteword'] ) );

		//Deal with the border options
		if( $_POST['just_writing_border_setting'] == 'hide' )
			{
			update_user_meta( $user_id, 'just_writing_h_b', 'on' );
			update_user_meta( $user_id, 'just_writing_l_b', 'off' );
			}
		elseif( $_POST['just_writing_border_setting'] == 'light' )
			{
			update_user_meta( $user_id, 'just_writing_h_b', 'off' );
			update_user_meta( $user_id, 'just_writing_l_b', 'on' );
			}
		else
			{
			update_user_meta( $user_id, 'just_writing_h_b', 'off' );
			update_user_meta( $user_id, 'just_writing_l_b', 'off' );
			}

		}

	/*
	 *	This function is called to draw the user settings page for Just Writing.
	 */
	function just_writing_user_profile_fields( $user ) 
		{ 
		// Check to see if this is the first time we've run for this user and no config
		// has been written yet, so let's do that now.
		if( get_the_author_meta( 'just_writing_enabled', $user->ID ) == "" )
			{
			Just_Writing_User_Setup( $user->ID );
			}
		
		wp_register_script( 'justwritingoptions_js', plugins_url( '', __FILE__ )  . '/just-writing-options.js' );
		wp_enqueue_script( 'justwritingoptions_js' );

		?>
	<h3>Just Writing</h3>
	 
	<table class="form-table">
		<tr>
			<th></th>
			<td>
			<span class="description"><?php echo __("Just Writing allows you to customize the Distraction Free Writing Mode in WordPress in several different ways to enable you to write the way you want to.  To find out more, please visit the ") . "<a href='http://wordpress.org/plugins/just-writing/' target=_blank>WordPress Plugin Directory page</a> " . __("or plugin home page on") . " <a href='http://toolstack.com/just-writing' target=_blank>ToolStack.com</a>.<br><br>" . __("And don't forget to ") . "<a href='http://wordpress.org/plugins/just-writing/' target=_blank>" . __("rate") . "</a>" . __(" and ") . "<a href='http://wordpress.org/support/view/plugin-reviews/just-writing' target=_blank>" . __("review") . "</a>" . __(" it too!");?></span>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_enabled"><?php echo __("Enable");?></label></th>
			<td>
			<input type="checkbox" id="just_writing_enabled" name="just_writing_enabled" <?php if( get_the_author_meta( 'just_writing_enabled', $user->ID ) == "on" ) { echo "CHECKED"; } ?> onClick="if(!just_writing_enabled.checked){ just_writing_options_table.style.display='none'}else{just_writing_options_table.style.display=''}">
			<?php echo __("Check to enable Just Writing (don't forget to make sure the visual editor is enabled at the top of this page)");?>
			</td>
		</tr>
	</table>
	<table class="form-table" id='just_writing_options_table' <?php if( get_the_author_meta( 'just_writing_enabled', $user->ID ) != "on" ) { echo "style='display:none;'"; } ?>>	
		<tr>
			<th><label for="just_writing_options"><?php echo __("Options");?></label></th>
			<td colspan=3>
			<?php echo __("Border on the title/body areas options:");?><br>
			<input type="radio" id="just_writing_s_b" name="just_writing_border_setting" value="show" <?php if( get_the_author_meta( 'just_writing_l_b', $user->ID ) != "on" && get_the_author_meta( 'just_writing_h_b', $user->ID ) != "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Show");?><br>
			<input type="radio" id="just_writing_l_b" name="just_writing_border_setting" value="light" <?php if( get_the_author_meta( 'just_writing_l_b', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Lighten");?><br>
			<input type="radio" id="just_writing_h_b" name="just_writing_border_setting" value="hide" <?php if( get_the_author_meta( 'just_writing_h_b', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_h_p" name="just_writing_h_p" <?php if( get_the_author_meta( 'just_writing_h_p', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the preview button");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_wc" name="just_writing_h_wc" <?php if( get_the_author_meta( 'just_writing_h_wc', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the word count");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_mb" name="just_writing_h_mb" <?php if( get_the_author_meta( 'just_writing_h_mb', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the editor mode selector");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_d_fade" name="just_writing_d_fade" <?php if( get_the_author_meta( 'just_writing_d_fade', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Disable the fade out of the toolbar *May have performance impacts*");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_al_new" name="just_writing_al_new" <?php if( get_the_author_meta( 'just_writing_al_new', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Go directly to Distraction Free Writing Mode for new posts *May have performance impacts*");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_al_edit" name="just_writing_al_edit" <?php if( get_the_author_meta( 'just_writing_al_edit', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Go directly to Distraction Free Writing Mode when editing a post *May have performance impacts*");?>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_buttons"><?php echo __("Buttons");?></label></th>
			<td colspan=3>
			<b><?php echo __("Cut/Copy/Paste *Will not work in all browsers*");?></b>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_cut" name="just_writing_cut" <?php if( get_the_author_meta( 'just_writing_cut', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Cut");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_copy" name="just_writing_copy" <?php if( get_the_author_meta( 'just_writing_copy', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Copy");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_paste" name="just_writing_paste" <?php if( get_the_author_meta( 'just_writing_paste', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_pastetext" name="just_writing_pastetext" <?php if( get_the_author_meta( 'just_writing_pastetext', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste as Text");?>
			</td>
			<td colspan=2>
			<input type="checkbox" id="just_writing_pasteword" name="just_writing_pasteword" <?php if( get_the_author_meta( 'just_writing_pasteword', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste from Word");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Text Decorations");?></b>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_bold" name="just_writing_bold" <?php if( get_the_author_meta( 'just_writing_bold', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Bold");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_italics" name="just_writing_italics" <?php if( get_the_author_meta( 'just_writing_italics', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Italics");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_strike" name="just_writing_strike" <?php if( get_the_author_meta( 'just_writing_strike', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Strikethrough");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_under" name="just_writing_under" <?php if( get_the_author_meta( 'just_writing_under', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Underline");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_superscript" name="just_writing_superscript" <?php if( get_the_author_meta( 'just_writing_superscript', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Superscript");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_subscript" name="just_writing_subscript" <?php if( get_the_author_meta( 'just_writing_subscript', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Subscript");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_remove" name="just_writing_remove" <?php if( get_the_author_meta( 'just_writing_remove', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Remove Formating");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Lists, Media and Links");?></b>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_ul" name="just_writing_ul" <?php if( get_the_author_meta( 'just_writing_ul', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Unordered List");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_nl" name="just_writing_nl" <?php if( get_the_author_meta( 'just_writing_nl', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Ordered List");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_media" name="just_writing_media" <?php if( get_the_author_meta( 'just_writing_media', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add Media");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_link" name="just_writing_link" <?php if( get_the_author_meta( 'just_writing_link', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Link");?>
			</td>
			<td colspan=2>
			<input type="checkbox" id="just_writing_unlink" name="just_writing_unlink" <?php if( get_the_author_meta( 'just_writing_unlink', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Unlink");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Alignment");?></b>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_left" name="just_writing_left" <?php if( get_the_author_meta( 'just_writing_left', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Left");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_center" name="just_writing_center" <?php if( get_the_author_meta( 'just_writing_center', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Center");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_right" name="just_writing_right" <?php if( get_the_author_meta( 'just_writing_right', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Right");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_outdent" name="just_writing_outdent" <?php if( get_the_author_meta( 'just_writing_outdent', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Outdent");?>
			</td>
			<td colspan=2>
			<input type="checkbox" id="just_writing_indent" name="just_writing_indent" <?php if( get_the_author_meta( 'just_writing_indent', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Indent");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Paragraph Formats");?></b>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_f_lb" name="just_writing_f_lb" <?php if( get_the_author_meta( 'just_writing_f_lb', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Enable formats dropdown instead of buttons (this will show all formats and hide all associated buttons, ignoring the options below).");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_p" name="just_writing_p" <?php if( get_the_author_meta( 'just_writing_p', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paragraph");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h1" name="just_writing_h1" <?php if( get_the_author_meta( 'just_writing_h1', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h1");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h2" name="just_writing_h2" <?php if( get_the_author_meta( 'just_writing_h2', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h2");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_h3" name="just_writing_h3" <?php if( get_the_author_meta( 'just_writing_h3', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h3");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h4" name="just_writing_h4" <?php if( get_the_author_meta( 'just_writing_h4', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h4");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h5" name="just_writing_h5" <?php if( get_the_author_meta( 'just_writing_h5', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h5");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_h6" name="just_writing_h6" <?php if( get_the_author_meta( 'just_writing_h6', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h6");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_quotes" name="just_writing_quotes" <?php if( get_the_author_meta( 'just_writing_quotes', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Block Quotes");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_address" name="just_writing_address" <?php if( get_the_author_meta( 'just_writing_address', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Address");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_pf" name="just_writing_pf" <?php if( get_the_author_meta( 'just_writing_pf', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Preformatted");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Actions");?></b>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_spell" name="just_writing_spell" <?php if( get_the_author_meta( 'just_writing_spell', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Spellcheck");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_more" name="just_writing_more" <?php if( get_the_author_meta( 'just_writing_more', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Insert More Tag");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_char" name="just_writing_char" <?php if( get_the_author_meta( 'just_writing_char', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Insert custom character");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_undo" name="just_writing_undo" <?php if( get_the_author_meta( 'just_writing_undo', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Undo");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_redo" name="just_writing_redo" <?php if( get_the_author_meta( 'just_writing_redo', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Redo");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_help" name="just_writing_help" <?php if( get_the_author_meta( 'just_writing_help', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Help");?>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<a onClick='JustWritingSelectAll()'><?php echo __("Select All");?></a>
			</td>
			<td>
			<a onClick='JustWritingDeSelectAll()'><?php echo __("Deselect All");?></a>
			</td>
			<td>
			<a onClick='JustWritingSelectDefaults()'><?php echo __("Select Defaults");?></a>
			</td>
		</tr>
	</table>
<?php 
		}

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
		}

	Function JustWritingLoadEdit()
		{
		JustWritingLoad( 'edit' );
		}
		
	Function JustWritingLoadNew()
		{
		JustWritingLoad( 'new' );
		}

	Function JustWritingLoad( $fname )
		{
		// Get the user option to see if we're enabled
		$cuid = get_current_user_id();
		$JustWritingEnabled = get_the_author_meta( 'just_writing_enabled', $cuid );
		
		// If the enabled check returned a blank string it's because this is the first run and no config
		// has been written yet, so let's do that now.
		if( $JustWritingEnabled == "" )
			{
			Just_Writing_User_Setup( $cuid );
			$JustWritingEnabled = "on";
			}
		
		// If we're enabled, setup as required.
		if( $JustWritingEnabled == "on" )
			{
			wp_register_style( 'justwriting_style', plugins_url( '', __FILE__ ) . '/just-writing.css' );
			wp_enqueue_style( 'justwriting_style' ); 

			// Get the options to pass to the javascript code
			$DisableFade = 0;
			if( get_the_author_meta( 'just_writing_d_fade', $cuid ) == 'on' ) { $DisableFade = 1; } 
			$HideWordCount = 0;
			if( get_the_author_meta( 'just_writing_h_wc', $cuid ) == 'on' ) { $HideWordCount = 1; } 
			$HidePreview = 0;
			if( get_the_author_meta( 'just_writing_h_p', $cuid ) == 'on' ) { $HidePreview = 1; } 
			$HideBorder = 0;
			if( get_the_author_meta( 'just_writing_h_b', $cuid ) == 'on' ) { $HideBorder = 2; } 
			if( get_the_author_meta( 'just_writing_l_b', $cuid ) == 'on' ) { $HideBorder = 1; } 
			$HideModeBar = 0;
			if( get_the_author_meta( 'just_writing_h_mb', $cuid ) == 'on' ) { $HideModeBar = 1; } 
			$FormatLB = 0;
			if( get_the_author_meta( 'just_writing_f_lb', $cuid ) == 'on' ) { $FormatLB = 1; } 

			$AutoLoad = 0;
			
			if( $fname == "new" )
				{
				if( get_the_author_meta( 'just_writing_al_new', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}

			if( $fname == "edit" )
				{
				if( get_the_author_meta( 'just_writing_al_edit', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}
				
			// Register and enqueue the javascript.
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing.js?rtl=' . is_rtl() . '&disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder . '&hidemodebar=' . $HideModeBar . '&autoload=' . $AutoLoad . '&formatlistbox=' . $FormatLB );
			wp_enqueue_script( 'justwriting_js' );
	
			add_filter( 'wp_fullscreen_buttons', 'JustWriting' );
			}
		}
	}
	
	// Handle the post screens
	add_action('admin_head-post-new.php', 'JustWritingLoadNew');
	add_action('admin_head-post.php', 'JustWritingLoadEdit');
	
	// Handle the user profile items
	add_action( 'show_user_profile', 'just_writing_user_profile_fields' );
	add_action( 'edit_user_profile', 'just_writing_user_profile_fields' );
	add_action( 'personal_options_update', 'just_writing_save_user_profile_fields' );
	add_action( 'edit_user_profile_update', 'just_writing_save_user_profile_fields' );
?>