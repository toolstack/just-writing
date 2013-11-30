<?php
// if not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

// Just Writing leaves all users settings alone during uninstall, however an admin can remove 
// them from the admin settings page.  If that has been done then one last setting will be
// left to remove.
delete_option( 'Just_Writing_Removed' );
?>
