<?php
/*
Plugin Name: Just Writing
Version: 2.0
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
			
		if( get_the_author_meta( 'just_writing_p', $cuid ) == 'on' )
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
	 *	This function is called to check if we need to add the above .css and .js files
	 *	on this page.  ONLY the posts pages need to include the files, all other admin pages
	 *	don't need them.
	 */
	function Just_Writing_Includes()
		{
		// First check to make sure we have a server variable set to the script name, if we
		// don't fall back to including the .css and .js files on all admin pages.
		if(isset($_SERVER['SCRIPT_NAME']) )
			{
			// Grab the lower case base name of the script file.
			$pagename = strtolower(basename($_SERVER['SCRIPT_NAME'], ".php"));
			
			// There are only two pages we really need to include the files on, so
			// use a switch to make it easier for later if we need to add more page
			// names to the list.
			switch( $pagename )
				{
				case "post":
				case "post-new":
					return "schedule_posts_calendar";
				default:
					return "";
				}
			}
		else
			{
			return true;
			}
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
		update_user_meta( $user_id, 'just_writing_h_b', just_writing_get_checked_state( $_POST['just_writing_h_b'] ) );
		}

	/*
	 *	This function is called to draw the user settings page for Just Writing.
	 */
	function just_writing_user_profile_fields( $user ) 
		{ ?>
	<h3>Just Writing</h3>
	 
	<table class="form-table">
		<tr>
			<th><label for="just_writing_enabled"><?php echo __("Enable Just Writing");?></label></th>
			<td>
			<input type="checkbox" id="just_writing_enabled" name="just_writing_enabled" <?php if( get_the_author_meta( 'just_writing_enabled', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Check to enable Just Writing");?></span>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_options"><?php echo __("Options");?></label></th>
			<td>
			<input type="checkbox" id="just_writing_h_p" name="just_writing_h_p" <?php if( get_the_author_meta( 'just_writing_h_p', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Hide the preview button");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_b" name="just_writing_h_b" <?php if( get_the_author_meta( 'just_writing_h_b', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Hide the border on the subject/body areas");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_d_fade" name="just_writing_d_fade" <?php if( get_the_author_meta( 'just_writing_d_fade', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Disable the fade out of the toolbar*");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_wc" name="just_writing_h_wc" <?php if( get_the_author_meta( 'just_writing_h_wc', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Hide the word count");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<span class="description"><?php echo __("* May have performance impacts");?></span>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_buttons"><?php echo __("Just Writing Buttons");?></label></th>
			<td>
			<input type="checkbox" id="just_writing_bold" name="just_writing_bold" <?php if( get_the_author_meta( 'just_writing_bold', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Bold");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_italics" name="just_writing_italics" <?php if( get_the_author_meta( 'just_writing_italics', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Italics");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_strike" name="just_writing_strike" <?php if( get_the_author_meta( 'just_writing_strike', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Strikethrough");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_under" name="just_writing_under" <?php if( get_the_author_meta( 'just_writing_under', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Underline");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_remove" name="just_writing_remove" <?php if( get_the_author_meta( 'just_writing_remove', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Remove Formating");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_ul" name="just_writing_ul" <?php if( get_the_author_meta( 'just_writing_ul', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Unordered List");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_nl" name="just_writing_nl" <?php if( get_the_author_meta( 'just_writing_nl', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Ordered List");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_media" name="just_writing_media" <?php if( get_the_author_meta( 'just_writing_media', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Add Media");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_link" name="just_writing_link" <?php if( get_the_author_meta( 'just_writing_link', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Link");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_unlink" name="just_writing_unlink" <?php if( get_the_author_meta( 'just_writing_unlink', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Unlink");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_left" name="just_writing_left" <?php if( get_the_author_meta( 'just_writing_left', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Align Left");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_center" name="just_writing_center" <?php if( get_the_author_meta( 'just_writing_center', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Align Center");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_right" name="just_writing_right" <?php if( get_the_author_meta( 'just_writing_right', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Align Right");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_outdent" name="just_writing_outdent" <?php if( get_the_author_meta( 'just_writing_outdent', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Outdent");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_indent" name="just_writing_indent" <?php if( get_the_author_meta( 'just_writing_indent', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Indent");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_p" name="just_writing_p" <?php if( get_the_author_meta( 'just_writing_p', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Paragraph");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h1" name="just_writing_h1" <?php if( get_the_author_meta( 'just_writing_h1', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h1");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h2" name="just_writing_h2" <?php if( get_the_author_meta( 'just_writing_h2', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h2");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_h3" name="just_writing_h3" <?php if( get_the_author_meta( 'just_writing_h3', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h3");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h4" name="just_writing_h4" <?php if( get_the_author_meta( 'just_writing_h4', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h4");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h5" name="just_writing_h5" <?php if( get_the_author_meta( 'just_writing_h5', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h5");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_h6" name="just_writing_h6" <?php if( get_the_author_meta( 'just_writing_h6', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("h6");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_quotes" name="just_writing_quotes" <?php if( get_the_author_meta( 'just_writing_quotes', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Block Quotes");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_address" name="just_writing_address" <?php if( get_the_author_meta( 'just_writing_address', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Address");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_pf" name="just_writing_pf" <?php if( get_the_author_meta( 'just_writing_pf', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Preformatted");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_spell" name="just_writing_spell" <?php if( get_the_author_meta( 'just_writing_spell', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Spellcheck");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_more" name="just_writing_more" <?php if( get_the_author_meta( 'just_writing_more', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Insert More Tag");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_char" name="just_writing_char" <?php if( get_the_author_meta( 'just_writing_char', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Insert custom character");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_undo" name="just_writing_undo" <?php if( get_the_author_meta( 'just_writing_undo', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Undo");?></span>
			</td>
			<td>
			<input type="checkbox" id="just_writing_redo" name="just_writing_redo" <?php if( get_the_author_meta( 'just_writing_redo', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Redo");?></span>
			</td>
		</tr>
		<tr>
			<td></th>
			<td>
			<input type="checkbox" id="just_writing_help" name="just_writing_help" <?php if( get_the_author_meta( 'just_writing_help', $user->ID ) == "on" ) { echo "CHECKED"; } ?>>
			<span class="description"><?php echo __("Help");?></span>
			</td>
			<td>
			<span class="description"><a onClick='just_writing_bold.checked=true;just_writing_italics.checked=true;just_writing_ul.checked=true;just_writing_nl.checked=true;just_writing_quotes.checked=true;just_writing_media.checked=true;just_writing_link.checked=true;just_writing_unlink.checked=true;just_writing_strike.checked=true;just_writing_under.checked=true;just_writing_remove.checked=true;just_writing_left.checked=true;just_writing_center.checked=true;just_writing_right.checked=true;just_writing_outdent.checked=true;just_writing_indent.checked=true;just_writing_p.checked=true;just_writing_h1.checked=true;just_writing_h2.checked=true;just_writing_h3.checked=true;just_writing_h4.checked=true;just_writing_h5.checked=true;just_writing_h6.checked=true;just_writing_address.checked=true;just_writing_pf.checked=true;just_writing_spell.checked=true;just_writing_more.checked=true;just_writing_char.checked=true;just_writing_undo.checked=true;just_writing_redo.checked=true;just_writing_help.checked=true;'><?php echo __("Select All");?></a></span>
			</td>
			<td>
			<span class="description"><a onClick='just_writing_bold.checked=false;just_writing_italics.checked=false;just_writing_ul.checked=false;just_writing_nl.checked=false;just_writing_quotes.checked=false;just_writing_media.checked=false;just_writing_link.checked=false;just_writing_unlink.checked=false;just_writing_strike.checked=false;just_writing_under.checked=false;just_writing_remove.checked=false;just_writing_left.checked=false;just_writing_center.checked=false;just_writing_right.checked=false;just_writing_outdent.checked=false;just_writing_indent.checked=false;just_writing_p.checked=false;just_writing_h1.checked=false;just_writing_h2.checked=false;just_writing_h3.checked=false;just_writing_h4.checked=false;just_writing_h5.checked=false;just_writing_h6.checked=false;just_writing_address.checked=false;just_writing_pf.checked=false;just_writing_spell.checked=false;just_writing_more.checked=false;just_writing_char.checked=false;just_writing_undo.checked=false;just_writing_redo.checked=false;just_writing_help.checked=false;'><?php echo __("Deselect All");?></a></span>
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
		}
		
	// First find out if we're in a post/page list, in a post/page edit page or somewhere we don't care about.
	$fname = Just_Writing_Includes();

	if( $fname )
		{
		// We have to force pluggable.php to load before we can call get_current_user_id();
		if( !function_exists( 'wp_get_current_user' ) ) { include( ABSPATH . "wp-includes/pluggable.php" ); }

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
			if( get_the_author_meta( 'just_writing_h_b', $cuid ) == 'on' ) { $HideBorder = 1; } 
			
			// Register and enqueue the javascript.
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing.js?disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder );
			wp_enqueue_script( 'justwriting_js' );
	
			add_filter( 'wp_fullscreen_buttons', 'JustWriting' );
			}
		}
	}	 
	
	// Handle the user profile items
	add_action( 'show_user_profile', 'just_writing_user_profile_fields' );
	add_action( 'edit_user_profile', 'just_writing_user_profile_fields' );
	add_action( 'personal_options_update', 'just_writing_save_user_profile_fields' );
	add_action( 'edit_user_profile_update', 'just_writing_save_user_profile_fields' );
?>