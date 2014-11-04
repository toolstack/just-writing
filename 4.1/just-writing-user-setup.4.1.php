<?php
/*
Copyright (c) 2013 by Greg Ross

This software is released under the GPL v2.0, see license.txt for details
*/

if( !function_exists( 'Just_Writing_User_Setup' ) )
	{
	/*
	 	This function is called to setup the user preferences for the first time.
	*/
	Function Just_Writing_User_Setup( $user_id )
		{
		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
		}
	}
?>
