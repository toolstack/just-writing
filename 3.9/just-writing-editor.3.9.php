<?php
// Meta boxes: wp-admin\includes\meta-boxes.php
// Main post logic: wp-admin\post.php
// Post editor: wp-admin\wp-admin/edit-form-advanced.php

/** WordPress Administration Bootstrap */
require_once( 'c:\\xampp\\htdocs\\wordpress\\' . 'wp-admin/admin.php' );

wp_reset_vars( array( 'action' ) );

if ( isset( $_GET['post'] ) )
 	$post_id = $post_ID = (int) $_GET['post'];
elseif ( isset( $_POST['post_ID'] ) )
 	$post_id = $post_ID = (int) $_POST['post_ID'];
else
 	$post_id = $post_ID = 0;

$post = $post_type = $post_type_object = null;

if ( $post_id )
	$post = get_post( $post_id );

if ( $post ) {
	$post_type = $post->post_type;
	$post_type_object = get_post_type_object( $post_type );
}

if ( ! $post )
	wp_die( __( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?' ) );

if ( ! $post_type_object )
	wp_die( __( 'Unknown post type.' ) );

if ( ! current_user_can( 'edit_post', $post_id ) )
	wp_die( __( 'You are not allowed to edit this item.' ) );

if ( 'trash' == $post->post_status )
	wp_die( __( 'You can&#8217;t edit this item because it is in the Trash. Please restore it and try again.' ) );

$title = $post_type_object->labels->edit_item;
$post = get_post($post_id, OBJECT, 'edit');

include( ABSPATH . 'wp-admin/edit-form-advanced.php' );

include( ABSPATH . 'wp-admin/admin-footer.php' );

?>