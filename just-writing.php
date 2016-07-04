<?php
/*
Plugin Name: Just Writing
Version: 3.9
Plugin URI: http://toolstack.com/just-writing
Author: Greg Ross
Author URI: http://toolstack.com
Text Domain: just-writing
Domain Path: /languages/
Description: Adds more buttons to the distraction free writing mode command bar.

Compatible with WordPress 3.5+.

Read the accompanying readme.txt file for instructions and documentation.

Copyright (c) 2013-15 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

include_once( dirname( __FILE__ ) . '/ToolStack-WP-Utilities.class.php' );

GLOBAL $JustWritingUtilities;

// Create out global utilities object.  We might be tempted to load the user options now, but that's not possible as WordPress hasn't processed the login this early yet.
$JustWritingUtilities = new ToolStack_WP_Utilities_V2_5( 'just_writing', __FILE__ );

if( !function_exists( 'JustWritingLoad' ) )
	{
	define( 'JustWritingVersion', '3.9' );

	// Load the translation code.
	function just_writing_language() {
		load_plugin_textdomain('just-writing', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
		__('Just Writing', 'just-writing');
		__('Adds more buttons to the distraction free writing mode command bar.', 'just-writing');
	}

	// Add translation action.
	add_action('plugins_loaded', 'just_writing_language');
	
	Function JustWritingFileVersion()
		{
		GLOBAL $wp_version;
		
		if( version_compare( $wp_version, '3.9', '<' ) )
			{
			return '3.5';
			}
			
		// We compare against 4.0.99 in the second version compare to ensure we use the right version for beta/rc versions of WP.
		if( version_compare( $wp_version, '3.9', '>=' ) && version_compare( $wp_version, '4.0.99', '<=') )
			{
			return '3.9';
			}

		// We compare against 4.2.99 in the second version compare to ensure we use the right version for beta/rc versions of WP.
		if( version_compare( $wp_version, '4.1', '>=' ) && version_compare( $wp_version, '4.2.99', '<=') )
			{
			return '4.1';
			}

		// We compare against 4.4.99 in the second version compare to ensure we use the right version for beta/rc versions of WP.
		if( version_compare( $wp_version, '4.3', '>=' ) && version_compare( $wp_version, '4.4.99', '<=') )
			{
			return '4.3';
			}

		return '4.5';
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

	$file_version = JustWritingFileVersion();
	
	include_once( $file_version . '/just-writing.' . $file_version . '.php' );
	include_once( $file_version . '/just-writing-editor.' . $file_version . '.php' );
	}

// Check to see if we're installed and are the current version.
if( get_option('just_writing_plugin_version') != JustWritingVersion ) 
	{	
	include_once( dirname( __FILE__ ) . '/just-writing-install.php' );
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
	
	// Handle adding Writing mode to the post/pages menu
	add_action( 'admin_menu', 'JustWritingEditorMenuItem' );
	}
?>