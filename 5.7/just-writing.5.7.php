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

		// Get the user option to see if we're enabled.
		$cuid = get_current_user_id();
		$JustWritingEnabled = $JustWritingUtilities->get_user_option( 'enabled' );
		
		// If we're enabled, setup as required.
		if( $JustWritingEnabled == 'on' )
			{
			$file_version = JustWritingFileVersion();
		
			wp_register_style( 'justwriting_style', plugins_url( '', __FILE__ ) . '/just-writing.' . $file_version . '.css' );
			wp_enqueue_style( 'justwriting_style' ); 

			wp_register_script( 'justwriting_script', plugins_url( '', __FILE__ ) . '/just-writing.' . $file_version . '.js' );
			wp_enqueue_script( 'justwriting_script' ); 
			}
		}
		
	Function JustWritingLoadEditor()
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
			$CenterTB = 0;
			if( $JustWritingUtilities->get_user_option( 'center_toolbar' ) == 'on' ) { $CenterTB = 1; } 
			
			// Register and enqueue the javascript.
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing-editor.' . $file_version . '.js?rtl=' . is_rtl() . '&disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder . '&hidemodebar=' . $HideModeBar . '&centertb=' . $CenterTB );
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

		$path = 'edit.php?';		
		$name = $post->name;

		if( 'post' != $name && '' != $name ) // edit.php?post_type=post doesn't work
			$path .= 'post_type=' . $name . '&';
		
		// Only add the link if we're enabled and the user has selected the option.
		if( $JustWritingEnabled == "on" )
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

		// Set the current user and load the user preferences.
		$JustWritingUtilities->set_user_id();
		$JustWritingUtilities->load_user_options();

		$JustWritingEnabled = $JustWritingUtilities->get_user_option( 'enabled' );

		if( $JustWritingEnabled == "on" )
			{
			foreach( $post_types as $post_type ) 
				{
				$path = 'edit.php';		
				$name = $post_type->name;

				if( 'post' != $name ) // edit.php?post_type=post doesn't work
					$path .= '?post_type=' . $name;

				$page_id = add_submenu_page( $path, __( 'Write', 'just-writing' ), __( 'Write', 'just-writing' ), $post_type->cap->edit_posts, 'JustWriting' . ucwords($name), 'JustWritingEditorPage' );
				
				// Make sure we load the Just Writing code for each page type.
				//add_action( 'admin_head-' . $page_id, 'JustWritingLoadEdit' );
				}
			}
		}

	/*
	 	This function generates the Just Writing settings page and handles the actions associated with it.
	 */
	function JustWritingAdminPage()
		{
		global $wpdb;

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		
		wp_register_style("jquery-ui-css", plugin_dir_url(__FILE__) . "../css/jquery-ui-1.10.4.custom.css");
		wp_enqueue_style("jquery-ui-css");
		wp_register_style("jquery-ui-tabs-css", plugin_dir_url(__FILE__) . "../css/jquery-ui-tabs.css");
		wp_enqueue_style("jquery-ui-tabs-css");

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
	<script type="text/javascript">jQuery(document).ready(function() { jQuery("#tabs").tabs(); jQuery("#tabs").tabs("option", "active",0);} );</script>
	<h2><?php _e('Just Writing Settings', 'just-writing');?></h2>
	
	<div id="tabs">
		<ul>
			<li><a href="#fragment-0"><span><?php _e('Options', 'just-writing');?></span></a></li>
			<li><a href="#fragment-1"><span><?php _e('About', 'just-writing');?></span></a></li>
		</ul>

		<div id="fragment-0">
			<h3><?php _e('User Settings', 'just-writing');?></h3>
			<p><?php echo sprintf(__('User settings can be found in %syour profile page%s, under the Just Writing heading.', 'just-writing'), '<a href="' . get_edit_profile_url(get_current_user_id()) . '">', '</a>' );?>

			<h3><?php _e('Uninstall Actions', 'just-writing'); ?></h3>

<?php 
	if( current_user_can( 'delete_plugins' ) ) 
		{
		if( get_option( "Just_Writing_Removed" ) != 'true' )
			{ 
?>
				<div style="font-size: 16px;"><?php _e('**WARNING** No further confirmation will be given after you press the delete button, make sure you REALLY want to delete all user preferences and disable Just Writing!', 'just-writing');?></div>
				<div>&nbsp;</div>
				<div><?php _e('Remove the user preferences and disable:', 'just-writing')?>&nbsp;<input type="button" class="button" id="JustWritingRemoveAction" name="JustWritingRemoveAction" value="<?php _e('Remove', 'just-writing') ?>" onclick="if( confirm('Ok, last chance, really remove the user preferences and disable?') ) { window.location = 'options-general.php?page=just-writing.php&JustWritingRemoveAction=TRUE'}"/>
<?php
			}
		else
			{
?>
				<div><?php _e('Re-enable Just Writing:', 'just-writing')?>&nbsp;<input type="button" class="button" id="JustWritingReenableAction" name="JustWritingReenableAction" value="<?php _e('Re-enable', 'just-writing') ?>" onclick="window.location = 'options-general.php?page=just-writing.php&JustWritingReenableAction=TRUE'"/>
<?php 
			}
		}
	else
		{
		_e("Sorry, you don't have the rights to delete the plugin!", 'just-writing');
		}
?>
		
			</div>
		
		</div>
	
		<div id="fragment-1">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<td scope="row" align="center"><img src="<?php echo plugins_url('just-writing/images/logo-250.png'); ?>"></td>
					</tr>

					<tr valign="top">
						<td scope="row" align="center"><h2><?php echo sprintf(__('Just Writing V%s', 'just-writing'), JustWritingVersion); ?></h2></td>
					</tr>

					<tr valign="top">
						<td scope="row" align="center"><p>by <a href="https://toolstack.com">Greg Ross</a></p></td>
					</tr>

					<tr valign="top">
						<td scope="row" align="center"><hr /></td>
					</tr>

					<tr valign="top">
						<td scope="row" colspan="2"><h2><?php _e('Rate and Review at WordPress.org', 'just-writing'); ?></h2></td>
					</tr>
					
					<tr valign="top">
						<td scope="row" colspan="2"><?php _e('Thanks for installing Just Writing, I encourage you to submit a ', 'just-writing');?> <a href="http://wordpress.org/support/view/plugin-reviews/just-writing" target="_blank"><?php _e('rating and review', 'just-writing'); ?></a> <?php _e('over at WordPress.org.  Your feedback is greatly appreciated!', 'just-writing');?></td>
					</tr>
					
					<tr valign="top">
						<td scope="row" colspan="2"><h2><?php _e('Support', 'just-writing'); ?></h2></td>
					</tr>

					<tr valign="top">
						<td scope="row" colspan="2">
							<p><?php _e("Here are a few things to do submitting a support request:", 'just-writing'); ?></p>

							<ul style="list-style-type: disc; list-style-position: inside; padding-left: 25px;">
								<li><?php echo sprintf( __('Have you read the %s?', 'just-writing' ), '<a title="' . __('FAQs', 'just-writing') . '" href="https://wordpress.org/plugins/just-writing/faq/" target="_blank">' . __('FAQs', 'just-writing'). '</a>');?></li>
								<li><?php echo sprintf( __('Have you search the %s for a similar issue?', 'just-writing' ), '<a href="http://wordpress.org/support/plugin/just-writing" target="_blank">' . __('support forum', 'just-writing') . '</a>');?></li>
								<li><?php _e('Have you search the Internet for any error messages you are receiving?', 'just-writing' );?></li>
								<li><?php _e('Make sure you have access to your PHP error logs.', 'just-writing' );?></li>
							</ul>

							<p><?php _e('And a few things to double-check:', 'just-writing' );?></p>

							<ul style="list-style-type: disc; list-style-position: inside; padding-left: 25px;">
								<li><?php _e('Have you double checked the plugin settings?', 'just-writing' );?></li>
								<li><?php _e('Are you getting a blank or incomplete page displayed in your browser?  Did you view the source for the page and check for any fatal errors?', 'just-writing' );?></li>
								<li><?php _e('Have you checked your PHP and web server error logs?', 'just-writing' );?></li>
							</ul>

							<p><?php _e('Still not having any luck?', 'just-writing' );?> <?php echo sprintf(__('Then please open a new thread on the %s.', 'just-writing' ), '<a href="http://wordpress.org/support/plugin/just-writing" target="_blank">' . __('WordPress.org support forum', 'just-writing') . '</a>');?></p>
						</td>
					</tr>

				</tbody>
			</table>
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
		
	add_filter('atd_load_scripts', 'JustWritingFilterTinyMCESpellCheck');
	
	function JustWritingFilterTinyMCESpellCheck( $pages ) 
		{
		global $pagenow, $current_screen;

		if ( $pagenow == 'edit.php' ) {
			if ( isset( $current_screen->post_type ) && $current_screen->post_type ) {
				return post_type_supports( $current_screen->post_type, 'editor' );
			}
			return true;
		}

		return false;
		}

	add_action( 'init', 'justwriting_tinymcebuttons' );
	function justwriting_tinymcebuttons() 
		{
		add_filter( "mce_external_plugins", "justwriting_add_tinymcebuttons" );
		add_filter( 'mce_buttons', 'justwriting_register_tinymcebuttons' );
		}
		
	function justwriting_add_tinymcebuttons( $plugin_array ) 
		{
		$plugin_array['justwriting'] = plugins_url( '', __FILE__ ) . '/tinymce/plugin.js';
		return $plugin_array;
		}
		
	function justwriting_register_tinymcebuttons( $buttons ) 
		{
		array_push( $buttons, 'justwriting' ); 
		return $buttons;
		}
	}
?>