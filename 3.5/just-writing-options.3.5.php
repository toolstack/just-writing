<?php
/*
Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

/*
 	This function returns either on or off depending on the state of an HTML checkbox 
    input field returned from a post command.
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
 	This function is called to save the user profile settings for Just Writing.
*/
function just_writing_save_user_profile_fields( $user_id )
	{
	GLOBAL $JustWritingUtilities;
	
	// If the user cannot edit their profile, then don't save the settings
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

	// Set the current user and load the user preferences.
	$JustWritingUtilities->set_user_id( $user_id );
	$JustWritingUtilities->load_user_options();

	$JustWritingUtilities->store_user_option( 'enabled', just_writing_get_checked_state( $_POST['just_writing_enabled'] ) );
	$JustWritingUtilities->store_user_option( 'bold', just_writing_get_checked_state( $_POST['just_writing_bold'] ) );
	$JustWritingUtilities->store_user_option( 'italics', just_writing_get_checked_state( $_POST['just_writing_italics'] ) );
	$JustWritingUtilities->store_user_option( 'ul', just_writing_get_checked_state( $_POST['just_writing_ul'] ) );
	$JustWritingUtilities->store_user_option( 'nl', just_writing_get_checked_state( $_POST['just_writing_nl'] ) );
	$JustWritingUtilities->store_user_option( 'quotes', just_writing_get_checked_state( $_POST['just_writing_quotes'] ) );
	$JustWritingUtilities->store_user_option( 'media', just_writing_get_checked_state( $_POST['just_writing_media'] ) );
	$JustWritingUtilities->store_user_option( 'link', just_writing_get_checked_state( $_POST['just_writing_link'] ) );
	$JustWritingUtilities->store_user_option( 'unlink', just_writing_get_checked_state( $_POST['just_writing_unlink'] ) );
	$JustWritingUtilities->store_user_option( 'strike', just_writing_get_checked_state( $_POST['just_writing_strike'] ) );
	$JustWritingUtilities->store_user_option( 'underline', just_writing_get_checked_state( $_POST['just_writing_under'] ) );
	$JustWritingUtilities->store_user_option( 'remove_format', just_writing_get_checked_state( $_POST['just_writing_remove'] ) );
	$JustWritingUtilities->store_user_option( 'left_justify', just_writing_get_checked_state( $_POST['just_writing_left'] ) );
	$JustWritingUtilities->store_user_option( 'center_justify', just_writing_get_checked_state( $_POST['just_writing_center'] ) );
	$JustWritingUtilities->store_user_option( 'right_justify', just_writing_get_checked_state( $_POST['just_writing_right'] ) );
	$JustWritingUtilities->store_user_option( 'full_justify', just_writing_get_checked_state( $_POST['just_writing_justify'] ) );
	$JustWritingUtilities->store_user_option( 'outdent', just_writing_get_checked_state( $_POST['just_writing_outdent'] ) );
	$JustWritingUtilities->store_user_option( 'indent', just_writing_get_checked_state( $_POST['just_writing_indent'] ) );
	$JustWritingUtilities->store_user_option( 'p_format', just_writing_get_checked_state( $_POST['just_writing_p'] ) );
	$JustWritingUtilities->store_user_option( 'h1_format', just_writing_get_checked_state( $_POST['just_writing_h1'] ) );
	$JustWritingUtilities->store_user_option( 'h2_format', just_writing_get_checked_state( $_POST['just_writing_h2'] ) );
	$JustWritingUtilities->store_user_option( 'h3_format', just_writing_get_checked_state( $_POST['just_writing_h3'] ) );
	$JustWritingUtilities->store_user_option( 'h4_format', just_writing_get_checked_state( $_POST['just_writing_h4'] ) );
	$JustWritingUtilities->store_user_option( 'h5_format', just_writing_get_checked_state( $_POST['just_writing_h5'] ) );
	$JustWritingUtilities->store_user_option( 'h6_format', just_writing_get_checked_state( $_POST['just_writing_h6'] ) );
	$JustWritingUtilities->store_user_option( 'address_format', just_writing_get_checked_state( $_POST['just_writing_address'] ) );
	$JustWritingUtilities->store_user_option( 'pre_format', just_writing_get_checked_state( $_POST['just_writing_pf'] ) );
	$JustWritingUtilities->store_user_option( 'spellcheck', just_writing_get_checked_state( $_POST['just_writing_spell'] ) );
	$JustWritingUtilities->store_user_option( 'more', just_writing_get_checked_state( $_POST['just_writing_more'] ) );
	$JustWritingUtilities->store_user_option( 'char_map', just_writing_get_checked_state( $_POST['just_writing_char'] ) );
	$JustWritingUtilities->store_user_option( 'undo', just_writing_get_checked_state( $_POST['just_writing_undo'] ) );
	$JustWritingUtilities->store_user_option( 'redo', just_writing_get_checked_state( $_POST['just_writing_redo'] ) );
	$JustWritingUtilities->store_user_option( 'help', just_writing_get_checked_state( $_POST['just_writing_help'] ) );
	$JustWritingUtilities->store_user_option( 'disable_fade', just_writing_get_checked_state( $_POST['just_writing_d_fade'] ) );
	$JustWritingUtilities->store_user_option( 'hide_wordcount', just_writing_get_checked_state( $_POST['just_writing_h_wc'] ) );
	$JustWritingUtilities->store_user_option( 'hide_preview', just_writing_get_checked_state( $_POST['just_writing_h_p'] ) );
	$JustWritingUtilities->store_user_option( 'hide_modeselect', just_writing_get_checked_state( $_POST['just_writing_h_mb'] ) );
	$JustWritingUtilities->store_user_option( 'autoload_newposts', just_writing_get_checked_state( $_POST['just_writing_al_new'] ) );
	$JustWritingUtilities->store_user_option( 'autoload_editposts', just_writing_get_checked_state( $_POST['just_writing_al_edit'] ) );
	$JustWritingUtilities->store_user_option( 'format_listbox', just_writing_get_checked_state( $_POST['just_writing_f_lb'] ) );
	$JustWritingUtilities->store_user_option( 'superscript', just_writing_get_checked_state( $_POST['just_writing_superscript'] ) );
	$JustWritingUtilities->store_user_option( 'subscript', just_writing_get_checked_state( $_POST['just_writing_subscript'] ) );
	$JustWritingUtilities->store_user_option( 'cut', just_writing_get_checked_state( $_POST['just_writing_cut'] ) );
	$JustWritingUtilities->store_user_option( 'copy', just_writing_get_checked_state( $_POST['just_writing_copy'] ) );
	$JustWritingUtilities->store_user_option( 'paste', just_writing_get_checked_state( $_POST['just_writing_paste'] ) );
	$JustWritingUtilities->store_user_option( 'pastetext', just_writing_get_checked_state( $_POST['just_writing_pastetext'] ) );
	$JustWritingUtilities->store_user_option( 'pasteword', just_writing_get_checked_state( $_POST['just_writing_pasteword'] ) );
	$JustWritingUtilities->store_user_option( 'separator_one', just_writing_get_checked_state( $_POST['just_writing_separatorone'] ) );
	$JustWritingUtilities->store_user_option( 'separator_two', just_writing_get_checked_state( $_POST['just_writing_separatortwo'] ) );
	$JustWritingUtilities->store_user_option( 'separator_three', just_writing_get_checked_state( $_POST['just_writing_separatorthree'] ) );
	$JustWritingUtilities->store_user_option( 'separator_four', just_writing_get_checked_state( $_POST['just_writing_separatorfour'] ) );
	$JustWritingUtilities->store_user_option( 'separator_five', just_writing_get_checked_state( $_POST['just_writing_separatorfive'] ) );
	$JustWritingUtilities->store_user_option( 'separator_six', just_writing_get_checked_state( $_POST['just_writing_separatorsix'] ) );
	$JustWritingUtilities->store_user_option( 'separator_seven', just_writing_get_checked_state( $_POST['just_writing_separatorseven'] ) );
	$JustWritingUtilities->store_user_option( 'separator_eight', just_writing_get_checked_state( $_POST['just_writing_separatoreight'] ) );
	$JustWritingUtilities->store_user_option( 'font_name', just_writing_get_checked_state( $_POST['just_writing_f_n'] ) );
	$JustWritingUtilities->store_user_option( 'font_size', just_writing_get_checked_state( $_POST['just_writing_f_s'] ) );
	$JustWritingUtilities->store_user_option( 'font_color', just_writing_get_checked_state( $_POST['just_writing_f_c'] ) );
	$JustWritingUtilities->store_user_option( 'background_color', just_writing_get_checked_state( $_POST['just_writing_b_c'] ) );
	$JustWritingUtilities->store_user_option( 'center_toolbar', just_writing_get_checked_state( $_POST['just_writing_c_tb'] ) );
	$JustWritingUtilities->store_user_option( 'add_DFWM_post_pages', just_writing_get_checked_state( $_POST['just_writing_a_l'] ) );
	$JustWritingUtilities->store_user_option( 'disable_jscp', just_writing_get_checked_state( $_POST['just_writing_d_jscp'] ) );
	$JustWritingUtilities->store_user_option( 'browser_fullscreen', just_writing_get_checked_state( $_POST['just_writing_browser_fs'] ) );

	// Deal with the border options radio group
	if( $_POST['just_writing_border_setting'] == 'hide' )
		{
		$JustWritingUtilities->store_user_option( 'hide_border', 'on' );
		$JustWritingUtilities->store_user_option( 'lighten_border', 'off' );
		}
	elseif( $_POST['just_writing_border_setting'] == 'light' )
		{
		$JustWritingUtilities->store_user_option( 'hide_border', 'off' );
		$JustWritingUtilities->store_user_option( 'lighten_border', 'on' );
		}
	else
		{
		$JustWritingUtilities->store_user_option( 'hide_border', 'off' );
		$JustWritingUtilities->store_user_option( 'lighten_border', 'off' );
		}

	// Deal with the quick settings option radio group
	switch( $_POST['just_writing_quick_setting'] )
		{
		case 'minimal':
			$JustWritingUtilities->store_user_option( 'quick_setting', 'minimal' );
			break;
		case 'wpdefault':
			$JustWritingUtilities->store_user_option( 'quick_setting', 'wpdefault' );
			break;
		case 'jwdefault':
			$JustWritingUtilities->store_user_option( 'quick_setting', 'jwdefault' );
			break;
		case 'advanced':
			$JustWritingUtilities->store_user_option( 'quick_setting', 'advanced' );
			break;
		case 'full':
			$JustWritingUtilities->store_user_option( 'quick_setting', 'full' );
			break;
		default:
			$JustWritingUtilities->store_user_option( 'quick_setting', 'custom' );
		}

	// Write them to the database.
	$JustWritingUtilities->save_user_options();
	
	// Reset the current user id for the utilities class back to the current user.
	$JustWritingUtilities->set_user_id( get_current_user_id() );
	}

/*
 	This function is called to draw the user settings page for Just Writing.
*/
function just_writing_user_profile_fields( $user ) 
	{ 
	GLOBAL $JustWritingUtilities;
	
	// If the user cannot edit posts or pages, then we don't want to display the Just Writing options as they won't be using Just Writing.
	if ( !current_user_can( 'edit_posts', $user ) || !current_user_can( 'edit_pages', $user ) ) { return; }

	// Set the current user and load the user preferences.
	$JustWritingUtilities->set_user_id( $user->ID );
	$JustWritingUtilities->load_user_options();
	
	// Check to see if this is the first time we've run for this user and no config
	// has been written yet, so let's do that now.
	if( $JustWritingUtilities->get_user_option( 'enabled' ) == "" )
		{
		include_once( "just-writing-user-setup.3.5.php" );
		Just_Writing_User_Setup( $user->ID );
		}
	
	wp_register_script( 'justwritingoptions_js', plugins_url( '', __FILE__ )  . '/just-writing-options.3.5.js' );
	wp_enqueue_script( 'justwritingoptions_js' );

	?>
	<h3 id=JustWriting>Just Writing</h3>
	 
	<table class="form-table">
		<tr>
			<th></th>
			<td>
			<span class="description"><?php echo __("Just Writing allows you to customize the Distraction Free Writing Mode in WordPress in several different ways to enable you to write the way you want to.  To find out more, please visit the ") . "<a href='http://wordpress.org/plugins/just-writing/' target=_blank>WordPress Plugin Directory page</a> " . __("or plugin home page on") . " <a href='http://toolstack.com/just-writing' target=_blank>ToolStack.com</a>.<br><br>" . __("And don't forget to ") . "<a href='http://wordpress.org/support/view/plugin-reviews/just-writing' target=_blank>" . __("rate and review") . "</a>" . __(" it too!");?></span>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_enabled"><?php echo __("Enable");?></label></th>
			<td>
			<input type="checkbox" id="just_writing_enabled" name="just_writing_enabled" <?php if( $JustWritingUtilities->get_user_option( 'enabled' ) == "on" ) { echo "CHECKED"; } ?> onClick="if(!just_writing_enabled.checked){ just_writing_options_table.style.display='none'; just_writing_quick_settings.style.display='none';}else{just_writing_options_table.style.display=''; just_writing_quick_settings.style.display='';}">
			<?php echo __("Check to enable Just Writing (don't forget to make sure the visual editor is enabled at the top of this page)");?>
			</td>
		</tr>
	</table>
	<table class="form-table" id='just_writing_quick_settings'>
		<tr>
			<th>Quick Options</th>
			<td>			
			<?php echo __("Use the following quick settings:"); $QuickSettings = $JustWritingUtilities->get_user_option( 'quick_setting' ); if( $QuickSettings == "" ) { $QuickSettings = "custom"; }?><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('minimal')" id="just_writing_qs_mininal" name="just_writing_quick_setting" value="minimal" <?php if( $QuickSettings == "minimal" ) { echo "CHECKED"; } ?>>
			<?php echo __("Minimal") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("Nothing but Save and Exit and real DFWM!");?></span><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('wpdefault')" id="just_writing_qs_wpdefault" name="just_writing_quick_setting" value="wpdefault" <?php if( $QuickSettings == "wpdefault" ) { echo "CHECKED"; } ?>>
			<?php echo __("WordPress Default") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("Just center the toolbar and move the exit button to the right hand side.");?></span><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('jwdefault')" id="just_writing_qs_jwdefault" name="just_writing_quick_setting" value="jwdefault" <?php if( $QuickSettings == "jwdefault" ) { echo "CHECKED"; } ?>>
			<?php echo __("Just Writing Default") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("A balanced toolbar that should work on all browsers.");?></span><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('advanced')" id="just_writing_qs_advanced" name="just_writing_quick_setting" value="advanced" <?php if( $QuickSettings == "advanced" ) { echo "CHECKED"; } ?>>
			<?php echo __("Advanced") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("Unlock the real power of DFWM!");?></span><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('full')" id="just_writing_qs_advanced" name="just_writing_quick_setting" value="full" <?php if( $QuickSettings == "full" ) { echo "CHECKED"; } ?>>
			<?php echo __("Full") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("All buttons and many of the options enabled.");?></span><br>
			<input type="radio" onclick="JustWritingSetQuickOptions('custom')" id="just_writing_qs_custom" name="just_writing_quick_setting" value="custom" <?php if( $QuickSettings == "custom" ) { echo "CHECKED"; } ?>>
			<?php echo __("Custom") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='description'>" . __("Select your options below:");?></span>
			</td>
		</tr>
	</table>
	<table class="form-table" id='just_writing_options_table' <?php if( $JustWritingUtilities->get_user_option( 'enabled' ) != "on" ) { echo "style='display:none;'"; } ?>>	
		<tr>
			<th><label for="just_writing_options"><?php echo __("Advanced Options");?></label></th>
			<td colspan=3>
			<span class='description' style='font-size: 75%;'><a href=#JustWriting onClick="JustWritingToggleOptionGroups()">Show/Hide</a></span>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<?php echo __("Border on the title/body areas options:");?><br>
			<input type="radio" id="just_writing_s_b" name="just_writing_border_setting" value="show" <?php if( $JustWritingUtilities->get_user_option( 'lighten_border' ) != "on" && $JustWritingUtilities->get_user_option( 'hide_border' ) != "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Show");?><br>
			<input type="radio" id="just_writing_l_b" name="just_writing_border_setting" value="light" <?php if( $JustWritingUtilities->get_user_option( 'lighten_border' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Lighten");?><br>
			<input type="radio" id="just_writing_h_b" name="just_writing_border_setting" value="hide" <?php if( $JustWritingUtilities->get_user_option( 'hide_border' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_h_p" name="just_writing_h_p" <?php if( $JustWritingUtilities->get_user_option( 'hide_preview' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the preview button");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_wc" name="just_writing_h_wc" <?php if( $JustWritingUtilities->get_user_option( 'hide_wordcount' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the word count");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h_mb" name="just_writing_h_mb" <?php if( $JustWritingUtilities->get_user_option( 'hide_modeselect' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Hide the editor mode selector");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_c_tb" name="just_writing_c_tb" <?php if( $JustWritingUtilities->get_user_option( 'center_toolbar' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Center the ToolBar on screen");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_a_l" name="just_writing_a_l" <?php if( $JustWritingUtilities->get_user_option( 'add_DFWM_post_pages' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add DFWM link to the Post/Pages lists");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_d_jscp" name="just_writing_d_jscp" <?php if( $JustWritingUtilities->get_user_option( 'disable_jscp' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Disable the Javascript Pickers");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_d_fade" name="just_writing_d_fade" <?php if( $JustWritingUtilities->get_user_option( 'disable_fade' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Disable the fade out of the toolbar *May have performance impacts*");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_browser_fs" name="just_writing_browser_fs" <?php if( $JustWritingUtilities->get_user_option( 'browser_fullscreen' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Open DFWM in your browsers full screen mode, note this only works if you click the full screen button in the editor and not with the DFWM link or auto load functions");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_al_new" name="just_writing_al_new" <?php if( $JustWritingUtilities->get_user_option( 'autoload_newposts' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Go directly to Distraction Free Writing Mode for new posts *May have performance impacts*");?>
			</td>
		</tr>
		<tr id=JustWritingOptionGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_al_edit" name="just_writing_al_edit" <?php if( $JustWritingUtilities->get_user_option( 'autoload_editposts' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Go directly to Distraction Free Writing Mode when editing a post *May have performance impacts*");?>
			</td>
		</tr>
		<tr>
			<th><label for="just_writing_options"><?php echo __("Advanced Buttons");?></label></th>
			<td colspan=3>
			<span class='description' style='font-size: 75%;'><a href=#JustWriting onClick="JustWritingToggleButtonGroups()">Show/Hide</a></span>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Cut/Copy/Paste *Will not work in all browsers*");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorone" name="just_writing_separatorone" <?php if( $JustWritingUtilities->get_user_option( 'separator_one' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_cut" name="just_writing_cut" <?php if( $JustWritingUtilities->get_user_option( 'cut' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Cut");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_copy" name="just_writing_copy" <?php if( $JustWritingUtilities->get_user_option( 'copy' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Copy");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_paste" name="just_writing_paste" <?php if( $JustWritingUtilities->get_user_option( 'paste' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_pastetext" name="just_writing_pastetext" <?php if( $JustWritingUtilities->get_user_option( 'pastetext' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste as Text");?>
			</td>
			<td colspan=2>
			<input type="checkbox" id="just_writing_pasteword" name="just_writing_pasteword" <?php if( $JustWritingUtilities->get_user_option( 'pasteword' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paste from Word");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Text Decorations");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatortwo" name="just_writing_separatortwo" <?php if( $JustWritingUtilities->get_user_option( 'separator_two' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_f_n" name="just_writing_f_n" <?php if( $JustWritingUtilities->get_user_option( 'font_name' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Font");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_f_s" name="just_writing_f_s" <?php if( $JustWritingUtilities->get_user_option( 'font_size' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Font Size");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_f_c" name="just_writing_f_c" <?php if( $JustWritingUtilities->get_user_option( 'font_color' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Font Color");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_b_c" name="just_writing_b_c" <?php if( $JustWritingUtilities->get_user_option( 'background_color' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Background Color");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_bold" name="just_writing_bold" <?php if( $JustWritingUtilities->get_user_option( 'bold' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Bold");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_italics" name="just_writing_italics" <?php if( $JustWritingUtilities->get_user_option( 'italics' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Italics");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_strike" name="just_writing_strike" <?php if( $JustWritingUtilities->get_user_option( 'strike' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Strikethrough");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_under" name="just_writing_under" <?php if( $JustWritingUtilities->get_user_option( 'underline' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Underline");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_superscript" name="just_writing_superscript" <?php if( $JustWritingUtilities->get_user_option( 'superscript' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Superscript");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_subscript" name="just_writing_subscript" <?php if( $JustWritingUtilities->get_user_option( 'subscript' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Subscript");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_remove" name="just_writing_remove" <?php if( $JustWritingUtilities->get_user_option( 'remove_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Remove Formating");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Lists, Media and Links");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorthree" name="just_writing_separatorthree" <?php if( $JustWritingUtilities->get_user_option( 'separator_three' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_ul" name="just_writing_ul" <?php if( $JustWritingUtilities->get_user_option( 'ul' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Unordered List");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_nl" name="just_writing_nl" <?php if( $JustWritingUtilities->get_user_option( 'nl' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Ordered List");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_media" name="just_writing_media" <?php if( $JustWritingUtilities->get_user_option( 'media' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add Media");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_link" name="just_writing_link" <?php if( $JustWritingUtilities->get_user_option( 'link' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Link");?>
			</td>
			<td colspan=2>
			<input type="checkbox" id="just_writing_unlink" name="just_writing_unlink" <?php if( $JustWritingUtilities->get_user_option( 'unlink' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Unlink");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Alignment");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorfour" name="just_writing_separatorfour" <?php if( $JustWritingUtilities->get_user_option( 'separator_four' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_left" name="just_writing_left" <?php if( $JustWritingUtilities->get_user_option( 'left_justify' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Left");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_center" name="just_writing_center" <?php if( $JustWritingUtilities->get_user_option( 'center_justify' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Center");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_right" name="just_writing_right" <?php if( $JustWritingUtilities->get_user_option( 'right_justify' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Align Right");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_justify" name="just_writing_justify" <?php if( $JustWritingUtilities->get_user_option( 'full_justify' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Full Justify");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_outdent" name="just_writing_outdent" <?php if( $JustWritingUtilities->get_user_option( 'outdent' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Outdent");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_indent" name="just_writing_indent" <?php if( $JustWritingUtilities->get_user_option( 'indent' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Indent");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Paragraph Formats");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorfive" name="just_writing_separatorfive" <?php if( $JustWritingUtilities->get_user_option( 'separator_five' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_f_lb" name="just_writing_f_lb" <?php if( $JustWritingUtilities->get_user_option( 'format_listbox' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Enable formats dropdown instead of buttons (this will show all formats and hide all associated buttons, ignoring the options below).");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_p" name="just_writing_p" <?php if( $JustWritingUtilities->get_user_option( 'p_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Paragraph");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h1" name="just_writing_h1" <?php if( $JustWritingUtilities->get_user_option( 'h1_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h1");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h2" name="just_writing_h2" <?php if( $JustWritingUtilities->get_user_option( 'h2_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h2");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_h3" name="just_writing_h3" <?php if( $JustWritingUtilities->get_user_option( 'h3_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h3");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h4" name="just_writing_h4" <?php if( $JustWritingUtilities->get_user_option( 'h4_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h4");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_h5" name="just_writing_h5" <?php if( $JustWritingUtilities->get_user_option( 'h5_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h5");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_h6" name="just_writing_h6" <?php if( $JustWritingUtilities->get_user_option( 'h6_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("h6");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_quotes" name="just_writing_quotes" <?php if( $JustWritingUtilities->get_user_option( 'quotes_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Block Quotes");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_address" name="just_writing_address" <?php if( $JustWritingUtilities->get_user_option( 'address_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Address");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_pf" name="just_writing_pf" <?php if( $JustWritingUtilities->get_user_option( 'pre_format' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Preformatted");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<b><?php echo __("Actions");?></b>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorsix" name="just_writing_separatorsix" <?php if( $JustWritingUtilities->get_user_option( 'separator_six' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_spell" name="just_writing_spell" <?php if( $JustWritingUtilities->get_user_option( 'spellcheck' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Spellcheck");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_more" name="just_writing_more" <?php if( $JustWritingUtilities->get_user_option( 'more' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Insert More Tag");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_char" name="just_writing_char" <?php if( $JustWritingUtilities->get_user_option( 'char_map' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Insert custom character");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatorseven" name="just_writing_separatorseven" <?php if( $JustWritingUtilities->get_user_option( 'separator_seven' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator before this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<input type="checkbox" id="just_writing_undo" name="just_writing_undo" <?php if( $JustWritingUtilities->get_user_option( 'undo' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Undo");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_redo" name="just_writing_redo" <?php if( $JustWritingUtilities->get_user_option( 'redo' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Redo");?>
			</td>
			<td>
			<input type="checkbox" id="just_writing_help" name="just_writing_help" <?php if( $JustWritingUtilities->get_user_option( 'help' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Help");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td colspan=3>
			<input type="checkbox" id="just_writing_separatoreight" name="just_writing_separatoreight" <?php if( $JustWritingUtilities->get_user_option( 'separator_eight' ) == "on" ) { echo "CHECKED"; } ?>>
			<?php echo __("Add a separator after this group");?>
			</td>
		</tr>
		<tr id=JustWritingButtonGroup style='display: none;'>
			<th></th>
			<td>
			<a onClick='JustWritingSelectAll()'><?php echo __("Select All");?></a>
			</td>
			<td>
			<a onClick='JustWritingDeSelectAll()'><?php echo __("Deselect All");?></a>
			</td>
			<td>
			</td>
		</tr>
	</table>
<?php 
	}
?>