<?php
/*
Plugin Name: Just Writing
Version: 2.17
Plugin URI: http://toolstack.com/just-writing
Author: Greg Ross
Author URI: http://toolstack.com
Description: Adds more buttons to the distraction free writing mode command bar.

Compatible with WordPress 3.5+.

Read the accompanying readme.txt file for instructions and documentation.

Copyright (c) 2013-14 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'JustWritingLoad' ) )
	{
	define( 'JustWritingVersion', '2.17' );

	Function JustWritingFileVersion()
		{
		GLOBAL $wp_version;
		
		if( version_compare( $wp_version, '3.8.99', '<=' ) )
			{
			return '3.5';
			}

		return '3.9';
		}
	
	/*
	 	This function is called during a page/post page load that we're editing.
	*/
	Function JustWritingLoadEdit()
		{
		JustWritingLoad( 'edit' );
		}
		
	/*
	 	This function is called during a new page/post page.
	*/
	Function JustWritingLoadNew()
		{
		JustWritingLoad( 'new' );
		}
		
	/*
	 	This function is called when a user edits their profile and creates the Just Writing section.
		
		$user = the user who's profile we're viewing
	*/
	Function JustWritingLoadProfile( $user )
		{
		include_once( "just-writing-options.php" );
		just_writing_user_profile_fields( $user );
		}
		
	/*
	 	This function is called when a user edits their profile and saves the Just Writing preferences.
		
		$user = the user who's settings we're saving
	*/
	Function JustWritingSaveProfile( $user )
		{
		include_once( "just-writing-options.php" );
		just_writing_save_user_profile_fields( $user );
		}

	/*
	 	This function is called to add the new buttons to the distraction free writing mode.
		
	 	It's registered at the end of the file with an add_action() call.
	 */
	Function JustWritingLoad( $source )
		{
		// Load the appropriate buttons array.
		include_once( 'just-writing-buttons.' . JustWritingFileVersion() . '.php' );

		// Get the user option to see if we're enabled.
		$cuid = get_current_user_id();
		$JustWritingEnabled = get_the_author_meta( 'just_writing_enabled', $cuid );
		
		// If the enabled check returned a blank string it's because this is the first run and no config
		// has been written yet, so let's do that now.
		if( $JustWritingEnabled == "" )
			{
			include_once( "just-writing-user-setup.php" );
			Just_Writing_User_Setup( $cuid );
			$JustWritingEnabled = "on";
			}
		
		// If we're enabled, setup as required.
		if( $JustWritingEnabled == "on" )
			{
			wp_register_style( 'justwriting_style', plugins_url( '', __FILE__ ) . '/just-writing.' . JustWritingFileVersion() . '.css' );
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
			$CenterTB = 0;
			if( get_the_author_meta( 'just_writing_c_tb', $cuid ) == 'on' ) { $CenterTB = 1; } 
			$DisableJSCP = 0;
			if( get_the_author_meta( 'just_writing_d_jscp', $cuid ) == 'on' ) { $DisableJSCP = 1; } 
			
			// By default, assume we're not autoloading DFWM.
			$AutoLoad = 0;
			
			if( $source == "new" )
				{
				// Check to see if we're supposed to autoload DFWM if we're creating a new post.
				if( get_the_author_meta( 'just_writing_al_new', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}

			if( $source == "edit" )
				{
				// Check to see if we're supposed to autoload DFWM if we're editing a post.
				if( get_the_author_meta( 'just_writing_al_edit', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}
				
			// Finally, check to see if we were passed an autoload variable on the URL, which happens if the user has
			// clicked DFWM in the post/pages list.
			if( array_key_exists( 'JustWritingAutoLoad', $_GET ) )
				{
				if( $_GET['JustWritingAutoLoad'] == 1 )
					{
					$AutoLoad = 1;
					}
				}
	
			// Register and enqueue the javascript.
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing.' . JustWritingFileVersion() . '.js?rtl=' . is_rtl() . '&disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder . '&hidemodebar=' . $HideModeBar . '&autoload=' . $AutoLoad . '&formatlistbox=' . $FormatLB . '&centertb=' . $CenterTB . '&disablejscp=' . $DisableJSCP );
			wp_enqueue_script( 'justwriting_js' );
	
			// Time to add our buttons to the DFWM toolbar.
			add_filter( 'wp_fullscreen_buttons', 'JustWriting' );
			}
		}

	/*
	 	This function is called for each post/page in the post/page list to add the DFWM link to the quick actions.
	 */
	function JustWritingLinkRow( $actions, $post )
		{
		$new_actions = array();

		$cuid = get_current_user_id();
		$JustWritingEnabled = get_the_author_meta( 'just_writing_enabled', $cuid );
		$JustWritingAddLinks = get_the_author_meta( 'just_writing_a_l', $cuid );

		// Only add the link if we're enabled and the user has selected the option.
		if( $JustWritingEnabled == "on" AND $JustWritingAddLinks == "on" )
			{
			foreach( $actions as $key => $value )
				{
				$new_actions[$key] = $value;

				if( $key == 'edit' )
					{
					$new_actions['JustWriting'] = '<a href="post.php?post=' . $post->ID . '&action=edit&JustWritingAutoLoad=1" title="Edit this item in Distraction Free Writing Mode">DFWM</a>';
					}
				}

			return $new_actions;
			}
		else
			{
			return $actions;
			}
		}

	/*
	 	This function generates the Just Writing settings page and handles the actions assocaited with it.
	 */
	function JustWritingAdminPage()
		{
		global $wpdb;

		if( isset( $_GET['JustWritingRemoveAction'] ) )
			{
			if( current_user_can( 'delete_plugins' ) ) 
				{
				$TableName = $wpdb->prefix . "usermeta";

				// Remove any user meta settings we've created, the LIKE clause will delete anything starting with "just_writing_".
				$wpdb->get_results( "DELETE FROM " . $TableName . " WHERE meta_key LIKE 'just_writing_%'" );
				
				// Store a temporary option to let us know we're been removed, this option will get deleted when Just Writing is uninstalled.
				update_option( 'Just_Writing_Removed', "true" );
				
				print "<div class='updated settings-error'><p><strong>User preferences removed and Just Writing disabled!</strong></p></div>\n";
				}
			else
				{
				print "<div class='updated settings-error'><p><strong>Sorry, you don't have the rights to remove the plugin!</strong></p></div>\n";
				}
			}

		if( isset( $_GET['JustWritingReenableAction'] ) )
			{
			// If the user wants to re-enabled Just Writing, get rid of the removed flag.
			delete_option( 'Just_Writing_Removed' );
			}
	?>
<div class="wrap">
	
	<fieldset style="border:1px solid #cecece;padding:15px; margin-top:25px" >
		<legend><span style="font-size: 24px; font-weight: 700;">&nbsp;<?php _e('User Settings');?>&nbsp;</span></legend>
		<p><?php echo sprintf(__('User settings can be found in %syour profile page%s, under the Just Writing heading.'), '<a href="' . get_edit_profile_url(get_current_user_id()) . '">', '</a>' );?></p>
	</fieldset>

	<fieldset style="border:1px solid #cecece;padding:15px; margin-top:25px" >
		<legend><span style="font-size: 24px; font-weight: 700;">&nbsp;<?php _e('Uninstall Actions'); ?>&nbsp;</span></legend>

<?php 
	if( current_user_can( 'delete_plugins' ) ) 
		{
		if( get_option( "Just_Writing_Removed" ) != 'true' )
			{ 
?>
		<div style="font-size: 16px;"><?php _e('**WARNING** No further confirmation will be given after you press the delete button, make sure you REALLY want to delete all user preferences and disable Just Writing!');?></div>
		<div>&nbsp;</div>
		<div><?php _e('Remove the user preferences and disable:')?>&nbsp;<input type="button" class="button" id="JustWritingRemoveAction" name="JustWritingRemoveAction" value="<?php _e('Remove') ?>" onclick="if( confirm('Ok, last chance, really remove the user preferences and disable?') ) { window.location = 'options-general.php?page=just-writing.php&JustWritingRemoveAction=TRUE'}"/>
<?php
			}
		else
			{
?>
		<div><?php _e('Re-enable Just Writing:')?>&nbsp;<input type="button" class="button" id="JustWritingReenableAction" name="JustWritingReenableAction" value="<?php _e('Re-enable') ?>" onclick="window.location = 'options-general.php?page=just-writing.php&JustWritingReenableAction=TRUE'"/>
<?php 
			}
		}
	else
		{
		_e("Sorry, you don't have the rights to delete the plugin!");
		}
?>
		
	</fieldset>
	
	<fieldset style="border:1px solid #cecece;padding:15px; margin-top:25px" >
		<legend><span style="font-size: 24px; font-weight: 700;">&nbsp;<?php _e('About'); ?>&nbsp;</span></legend>
		<h2><?php echo sprintf( __('Just Writing Version %s'), JustWritingVersion );?></h2>
		<p><?php _e('by');?> <a href="https://profiles.wordpress.org/gregross" target=_blank>Greg Ross</a></p>
		<p>&nbsp;</p>
		<p><?php printf(__('Licenced under the %sGPL Version 2%s'), '<a href="http://www.gnu.org/licenses/gpl-2.0.html" target=_blank>', '</a>');?></p>
		<p><?php printf(__('To find out more, please visit the %sWordPress Plugin Directory page%s or the plugin home page on %sToolStack.com%s'), '<a href="http://wordpress.org/plugins/just-writing/" target=_blank>', '</a>', '<a href="http://toolstack.com/just-writing" target=_blank>', '</a>');?></p>
		<p>&nbsp;</p>
		<p><?php printf(__("Don't forget to %srate and review%s it too!"), '<a href="http://wordpress.org/support/view/plugin-reviews/just-writing" target=_blank>', '</a>');?></p>
	</fieldset>
</div>
	<?php
		}
		
	/*
	 	This function adds the admin page to the settings menu.
	 */
	function JustWritingAddSettingsMenu()
		{
		add_options_page( 'Just Writing', 'Just Writing', 'manage_options', basename( __FILE__ ), 'JustWritingAdminPage');
		}
	}

// Add the admin page to the settings menu.
add_action( 'admin_menu', 'JustWritingAddSettingsMenu', 1 );

// If we've been removed, don't do anything else
if( get_option( 'Just_Writing_Removed' ) != 'true' )
	{
	// Handle the post screens
	add_action( 'admin_head-post-new.php', 'JustWritingLoadNew' );
	add_action( 'admin_head-post.php', 'JustWritingLoadEdit' );
	
	// Handle the user profile items
	add_action( 'show_user_profile', 'JustWritingLoadProfile' );
	add_action( 'edit_user_profile', 'JustWritingLoadProfile' );
	add_action( 'personal_options_update', 'JustWritingSaveProfile' );
	add_action( 'edit_user_profile_update', 'JustWritingSaveProfile' );
	
	// Handle adding DFWM to the post/page rows
	add_filter('post_row_actions', 'JustWritingLinkRow',10,2);
	add_filter('page_row_actions', 'JustWritingLinkRow',10,2);
	}
?>