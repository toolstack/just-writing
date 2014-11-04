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
	// If the user cannot edit their profile, then don't save the settings
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	
	}

/*
 	This function is called to draw the user settings page for Just Writing.
*/
function just_writing_user_profile_fields( $user ) 
	{ 
	// If the user cannot edit posts or pages, then we don't want to display the Just Writing options as they won't be using Just Writing.
	if ( !current_user_can( 'edit_posts', $user ) || !current_user_can( 'edit_pages', $user ) ) { return; }

	// Check to see if this is the first time we've run for this user and no config
	// has been written yet, so let's do that now.
	if( get_the_author_meta( 'just_writing_enabled', $user->ID ) == "" )
		{
		include_once( "just-writing-user-setup.4.1.php" );
		Just_Writing_User_Setup( $user->ID );
		}
	
	wp_register_script( 'justwritingoptions_js', plugins_url( '', __FILE__ )  . '/just-writing-options.4.1.js' );
	wp_enqueue_script( 'justwritingoptions_js' );

	?>
	<h3 id=JustWriting>Just Writing</h3>
	 
	<table class="form-table">
		<tr>
			<th></th>
			<td>
			<span class="description"><?php echo __("Just Writing currently doesn't support WordPress 4.1 and above, sorry.");?></span>
			</td>
		</tr>
	</table>
<?php 
	}
?>