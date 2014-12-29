<?php

if( !function_exists( 'JustWritingLoad' ) )
	{
	/*
	 	This function is called when a user edits their profile and creates the Just Writing section.
		
		$user = the user who's profile we're viewing
	*/
	Function JustWritingLoadProfile( $user )
		{
		$file_version = JustWritingFileVersion();
		
		include_once( dirname( __FILE__ ) . '/just-writing-options.' . $file_version . '.php' );
		
		just_writing_user_profile_fields( $user );
		}
		
	/*
	 	This function is called when a user edits their profile and saves the Just Writing preferences.
		
		$user = the user who's settings we're saving
	*/
	Function JustWritingSaveProfile( $user )
		{
		$file_version = JustWritingFileVersion();

		include_once( dirname( __FILE__ ) . '/just-writing-options.' . $file_version . '.php' );

		just_writing_save_user_profile_fields( $user );
		}

	/*
	 	This function is called to add the new buttons to the distraction free writing mode.
		
	 	It's registered at the end of the file with an add_action() call.
	 */
	Function JustWritingLoad( $source )
		{
		GLOBAL $JustWritingUtilities;

		// Set the current user and load the user preferences.
		$JustWritingUtilities->set_user_id();
		$JustWritingUtilities->load_user_options();
		
		$file_version = JustWritingFileVersion();
		
		// Load the appropriate buttons array.
		include_once( dirname( __FILE__ ) . '/just-writing-buttons.' . $file_version . '.php' );

		// Get the user option to see if we're enabled.
		$cuid = get_current_user_id();
		$JustWritingEnabled = $JustWritingUtilities->get_user_option( 'enabled' );
		
		// If the enabled check returned a blank string it's because this is the first run and no config
		// has been written yet, so let's do that now.
		if( $JustWritingEnabled == '' )
			{
			include_once( dirname( __FILE__ ) . '/just-writing-user-setup.' . $file_version . '.php' );
			Just_Writing_User_Setup( $cuid );
			$JustWritingEnabled = 'on';
			}
		
		// If we're enabled, setup as required.
		if( $JustWritingEnabled == 'on' )
			{
			wp_register_style( 'justwriting_style', plugins_url( '', __FILE__ ) . '/just-writing.' . $file_version . '.css' );
			wp_enqueue_style( 'justwriting_style' ); 

			// Get the options to pass to the javascript code
			$DisableFade = 0;
			if( $JustWritingUtilities->get_user_option( 'disable_fade' ) == 'on' ) { $DisableFade = 1; } 
			$HideWordCount = 0;
			if( $JustWritingUtilities->get_user_option( 'hide_wordcount' ) == 'on' ) { $HideWordCount = 1; } 
			$HidePreview = 0;
			if( $JustWritingUtilities->get_user_option( 'hide_preview' ) == 'on' ) { $HidePreview = 1; } 
			$HideBorder = 0;
			if( $JustWritingUtilities->get_user_option( 'hide_border' ) == 'on' ) { $HideBorder = 2; } 
			if( $JustWritingUtilities->get_user_option( 'lighten_border' ) == 'on' ) { $HideBorder = 1; } 
			$HideModeBar = 0;
			if( $JustWritingUtilities->get_user_option( 'hide_modeselect' ) == 'on' ) { $HideModeBar = 1; } 
			$FormatLB = 0;
			if( $JustWritingUtilities->get_user_option( 'format_listbox' ) == 'on' ) { $FormatLB = 1; } 
			$CenterTB = 0;
			if( $JustWritingUtilities->get_user_option( 'center_toolbar' ) == 'on' ) { $CenterTB = 1; } 
			$DisableJSCP = 0;
			if( $JustWritingUtilities->get_user_option( 'disable_jscp' ) == 'on' ) { $DisableJSCP = 1; } 
			$BrowserFS = 0;
			if( $JustWritingUtilities->get_user_option( 'browser_fullscreen' ) == 'on' ) { $BrowserFS = 1; } 
			
			// By default, assume we're not autoloading DFWM.
			$AutoLoad = 0;
			
			if( $source == "new" )
				{
				// Check to see if we're supposed to autoload DFWM if we're creating a new post.
				if( $JustWritingUtilities->get_user_option( 'autoload_newposts' ) == 'on' ) { $AutoLoad = 1; } 
				}

			if( $source == "edit" )
				{
				// Check to see if we're supposed to autoload DFWM if we're editing a post.
				if( $JustWritingUtilities->get_user_option( 'autoload_editposts' ) == 'on' ) { $AutoLoad = 1; } 
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
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing.' . $file_version . '.js?rtl=' . is_rtl() . '&disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder . '&hidemodebar=' . $HideModeBar . '&autoload=' . $AutoLoad . '&formatlistbox=' . $FormatLB . '&centertb=' . $CenterTB . '&disablejscp=' . $DisableJSCP . '&browserfs=' . $BrowserFS );
			wp_enqueue_script( 'justwriting_js' );
			
			wp_register_script( 'jquery_fullscreen', plugins_url( '', __FILE__ )  . '/../jquery.fullscreen-0.4.1.min.js' );
			wp_enqueue_script( 'jquery_fullscreen' );
	
			// Time to add our buttons to the DFWM toolbar.
			add_filter( 'wp_fullscreen_buttons', 'JustWriting' );
			}
		
		}

	/*
	 	This function is called for each post/page in the post/page list to add the DFWM link to the quick actions.
	 */
	function JustWritingLinkRow( $actions, $post )
		{
		GLOBAL $JustWritingUtilities;
		
		// Set the current user and load the user preferences.
		$JustWritingUtilities->set_user_id();
		$JustWritingUtilities->load_user_options();
		
		$file_version = JustWritingFileVersion();
		
		$new_actions = array();

		$cuid = get_current_user_id();
		$JustWritingEnabled = $JustWritingUtilities->get_user_option( 'enabled' );
		$JustWritingAddLinks = $JustWritingUtilities->get_user_option( 'add_DFWM_post_pages' );

		$path = 'edit.php?';		
		$name = $post->name;

		if( 'post' != $name && '' != $name ) // edit.php?post_type=post doesn't work
			$path .= 'post_type=' . $name . '&';
		
		// Only add the link if we're enabled and the user has selected the option.
		if( $JustWritingEnabled == "on" AND $JustWritingAddLinks == "on" )
			{
			foreach( $actions as $key => $value )
				{
				$new_actions[$key] = $value;

				if( $key == 'edit' )
					{
					$new_actions['Write'] = '<a href="' . $path . 'page=JustWritingPost&post=' . $post->ID . '&action=edit" title="Edit this item in Just Writing Mode">Write</a>';
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
	 	This function is called to add the Writing menu to the post/pages menus.
	 */
	function JustWritingEditorMenuItem()
		{
		GLOBAL $JustWritingUtilities;

		$post_types = (array)get_post_types( array( 'show_ui' => true ), 'object' );

		foreach( $post_types as $post_type ) 
			{
			$path = 'edit.php';		
			$name = $post_type->name;

			if( 'post' != $name ) // edit.php?post_type=post doesn't work
				$path .= '?post_type=' . $name;

			$page_id = add_submenu_page( $path, __( 'Write' ), __( 'Write' ), $post_type->cap->edit_posts, 'JustWriting' . ucwords($name), 'JustWritingEditorPage' );
			
			// Make sure we load the Just Writing code for each page type.
			add_action( 'admin_head-' . $page_id, 'JustWritingLoadEdit' );
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
				$wpdb->get_results( "DELETE FROM " . $TableName . " WHERE meta_key LIKE 'just_writing%'" );
				
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
		<p><?php echo __('WordPress 4.1 DFWM is not currently supported, there are no settings at this time that can be changed.');?></p>
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
		
	add_filter('tinymce_spellcheck_load_on_pages', 'JustWritingFilterTinyMCESpellCheck');
	
	function JustWritingFilterTinyMCESpellCheck( $pages ) 
		{
		$pages[] = 'edit.php';
		
		return $pages;
		}
	}
?>