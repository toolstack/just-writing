<?php 

function JustWritingEditorPage()
	{
	// Enqueue the editor stylesheet.
	wp_enqueue_style('justwriting-editor-css', plugin_dir_url(__FILE__) . 'editor.css', true, '4.1');

	$width = isset( $content_width ) && 800 > $content_width ? $content_width : 800;
	$width = $width + 22; // compensate for the padding and border
	$dfw_width = get_user_setting( 'dfw_width', $width );

	$post_ID = 0;
	$SaveButtonLabel = __('Save');
	if( array_key_exists( 'post', $_GET ) ) { $post_ID = (int)$_GET['post']; $SaveButtonLabel = __('Update'); }
	
	if( $post_ID > 0 ) { $post = get_post($post_ID); } else { $post = get_default_post_to_edit(); }
	$title = $post->post_title;
	
	$sendback = wp_get_referer();
	if( !$sendback )
		{
			$sendback = admin_url( 'edit.php' );
			$sendback .= ( ! empty( $post_type ) ) ? '?post_type=' . $post_type : '';
		}

	
	
	// Remove all the chrome from WordPress.
?>
<style>
div#wpadminbar { display: none !important; }
div#adminmenuwrap { display: none !important; }
div#adminmenuback { display: none !important; }
div#wpfooter { display: none !important; }
div#wpcontent { margin-left: 0px !important; }
.mce-toolbar-grp { display: none !important; }
div#wp-justwritingeditor-editor-tools { display: none !important; }
.mce-statusbar { display: none !important; }
</style>

<?php	
	// Add in our menu bar
?>
	<div style="height: auto; min-width: auto;" id="fullscreen-topbar">
		<div style="max-width: 100%; min-width: auto;" id="wp-fullscreen-toolbar">
			<div id="wp-fullscreen-central-toolbar" style="width: auto;">

				<div style="margin-left: 356px;" class="wp-tmce-mode" id="wp-fullscreen-mode-bar">
					<div id="wp-fullscreen-modes" class="button-group">
					<a class="button wp-fullscreen-mode-tinymce active" href="#" onclick="wp.editor.fullscreen.switchmode( 'tinymce' ); return false;">Visual</a>
					<a class="button wp-fullscreen-mode-html" href="#" onclick="wp.editor.fullscreen.switchmode( 'html' ); return false;">Text</a>
				</div>
			</div>

			<div style="width: auto;" id="wp-fullscreen-button-bar">
				<div id="wp-fullscreen-buttons" class="mce-toolbar">
<?php
		$buttons = array(
			// format: title, onclick, show in both editors
			'bold' => array( 'title' => __('Bold (Ctrl + B)'), 'both' => false ),
			'italic' => array( 'title' => __('Italic (Ctrl + I)'), 'both' => false ),
			'bullist' => array( 'title' => __('Unordered list (Alt + Shift + U)'), 'both' => false ),
			'numlist' => array( 'title' => __('Ordered list (Alt + Shift + O)'), 'both' => false ),
			'blockquote' => array( 'title' => __('Blockquote (Alt + Shift + Q)'), 'both' => false ),
			'wp-media-library' => array( 'title' => __('Media library (Alt + Shift + M)'), 'both' => true ),
			'link' => array( 'title' => __('Insert/edit link (Alt + Shift + A)'), 'both' => true ),
			'unlink' => array( 'title' => __('Unlink (Alt + Shift + S)'), 'both' => false ),
			'help' => array( 'title' => __('Help (Alt + Shift + H)'), 'both' => false ),
		);

		/**
		 * Filter the list of TinyMCE buttons for the fullscreen
		 * 'Distraction-Free Writing' editor.
		 *
		 * @since 3.2.0
		 *
		 * @param array $buttons An array of TinyMCE buttons for the DFW editor.
		 */
		$buttons = apply_filters( 'wp_fullscreen_buttons', $buttons );

		foreach ( $buttons as $button => $args ) {
			if ( 'separator' == $args ) {
				continue;
			}

			$onclick = ! empty( $args['onclick'] ) ? ' onclick="' . $args['onclick'] . '"' : '';
			$title = esc_attr( $args['title'] );
			?>

			<div class="mce-widget mce-btn<?php if ( $args['both'] ) { ?> wp-fullscreen-both<?php } ?>">
			<button type="button" aria-label="<?php echo $title; ?>" title="<?php echo $title; ?>"<?php echo $onclick; ?> id="wp_fs_<?php echo $button; ?>">
				<i class="mce-ico mce-i-<?php echo $button; ?>"></i>
			</button>
			</div>
			<?php
		}
?>		
				</div>
			</div>
			
			<div id="wp-fullscreen-save">
				<a style="margin-left: 5px; margin-bottom: 8px;" class="button right" href="<?php echo esc_attr( htmlspecialchars( $sendback ) ); ?>">Exit</a>
				<a style="margin-left: 5px;" class="button right" href="http://localhost/wordpress/blog/2014/11/01/hello-world/" target="wp-preview-1">Preview Changes</a>
				<input title="Last edited on November 1, 2014 at 10:25 pm" class="button button-primary right" value="<?php echo $SaveButtonLabel;?>" onclick="wp.editor.fullscreen.save();" type="button">
			</div>			
		</div>
	</div>	
<?php	
	// Output the footer
?>


	<div id="wp-fullscreen-statusbar">
		<div id="wp-fullscreen-status" style="width: <?php echo $dfw_width; ?>px;">
			<div id="wp-fullscreen-count">Word count: <span class="word-count">0</span></div>
			<div id="wp-fullscreen-tagline">Just writing.</div>
		</div>
	</div>
</div>
<?php
	// Output the title and create the TinyMCE instance.

	
	?>
	<div style="padding-top: 54px; width: <?php echo $dfw_width;?>px; display: block; margin-left: auto; margin-right: auto;" id="wp-content-wrap" class="wp-core-ui wp-editor-wrap tmce-active has-dfw wp-fullscreen-wrap">
		<input class="wp-fullscreen-title" style="border: 1px dotted rgb(204, 204, 204); width: 100%; margin-bottom: 24px;" spellcheck="true" name="post_title" size="30" id="title" autocomplete="off" type="text" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>">
		<?php wp_editor( $post->post_content, 'justwritingeditor', array('media_buttons' => false, 'textarea_name' => 'just_writing_textarea' ) ); ?>
	</div>
<?php
	}
	
?>