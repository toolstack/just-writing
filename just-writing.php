<?php
/*
Plugin Name: Just Writing
Version: 2.12
Plugin URI: http://toolstack.com/just-writing
Author: Greg Ross
Author URI: http://toolstack.com
Description: Adds more buttons to the distraction free writing mode command bar.

Compatible with WordPress 3.5+.

Read the accompanying readme.txt file for instructions and documentation.

Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'JustWritingLoad' ) )
	{
	/*
	 *	This function is called to add the new buttons to the distraction free
	 *  writing mode.
	 *	It's registered at the end of the file with an add_action() call.
	 */
	
	Function JustWritingLoadEdit()
		{
		JustWritingLoad( 'edit' );
		}
		
	Function JustWritingLoadNew()
		{
		JustWritingLoad( 'new' );
		}
		
	Function JustWritingLoadProfile( $user )
		{
		include_once( "just-writing-options.php" );
		just_writing_user_profile_fields( $user );
		}
		
	Function JustWritingSaveProfile( $user )
		{
		include_once( "just-writing-options.php" );
		just_writing_save_user_profile_fields( $user );
		}

	Function JustWritingLoad( $source )
		{
		// Load the buttons array 
		include_once( "just-writing-buttons.php" );

		// Get the user option to see if we're enabled
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
			$CenterTB = 0;
			if( get_the_author_meta( 'just_writing_c_tb', $cuid ) == 'on' ) { $CenterTB = 1; } 

			$AutoLoad = 0;
			
			if( $source == "new" )
				{
				if( get_the_author_meta( 'just_writing_al_new', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}

			if( $source == "edit" )
				{
				if( get_the_author_meta( 'just_writing_al_edit', $cuid ) == 'on' ) { $AutoLoad = 1; } 
				}
				
			if( $_GET['JustWritingAutoLoad'] == 1 )
				{
				$AutoLoad = 1;
				}
	
			// Register and enqueue the javascript.
			wp_register_script( 'justwriting_js', plugins_url( '', __FILE__ )  . '/just-writing.js?rtl=' . is_rtl() . '&disablefade=' . $DisableFade . '&hidewordcount=' . $HideWordCount . '&hidepreview=' . $HidePreview . '&hideborder=' . $HideBorder . '&hidemodebar=' . $HideModeBar . '&autoload=' . $AutoLoad . '&formatlistbox=' . $FormatLB . '&centertb=' . $CenterTB );
			wp_enqueue_script( 'justwriting_js' );
	
			add_filter( 'wp_fullscreen_buttons', 'JustWriting' );
			}
		}

	function JustWritingLinkRow( $actions, $post )
		{
		$new_actions = array();
		
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
	}
	
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

?>