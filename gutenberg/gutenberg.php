<?php
function JustWritingGutenbergSettings( $editor_settings, $context )
	{
	//file_put_contents('/tmp/settings.txt', 'test: ' . serialize( $editor_settings ) );


	return $editor_settings;
	}

function JustWritingGutenbergEditor()
	{
	GLOBAL $JustWritingUtilities;

	// Get the current screen.
	$current_screen = get_current_screen();

	// Check to see if we're in Gutenberg or not, if not, nothing to do so just return.
	if ( ! method_exists( $current_screen, 'is_block_editor' ) || ! $current_screen->is_block_editor() )
		{
		return;
		}

	// Check to see if the prev/next buttons are enabled.
	if( $JustWritingUtilities->get_user_option( 'gutenberg_prev_next' ) != "on" )
		{
		return;
		}

	// Register and enqueue our style sheet.
	wp_register_style( 'justwriting_gutenberg_style', plugins_url( '', __FILE__ ) . '/just-writing-gutenberg.css' );
	wp_enqueue_style( 'justwriting_gutenberg_style' );

	// Register and enqueue the Gutenberge word count sidebar.
	wp_register_script( 'just-writing-gutenberg-js', plugins_url( '', __FILE__ ) . '/just-writing-gutenberg.js', array( 'wp-plugins', 'wp-edit-post', 'wp-element' ) );
	wp_enqueue_script( 'just-writing-gutenberg-js' );

	// Check to see which location we're placing the buttons.
	if( $JustWritingUtilities->get_user_option( 'gutenberg_prev_next_location' ) == "on" )
		{
		$location = 'div .edit-post-header__settings';
		}
	else
		{
		$location = 'div .interface-pinned-items';
		}

	//
	$next_post = get_previous_post();
	$previous_post = get_next_post();

	if( is_object( $next_post ) )
		{
		$next_post_button = '<a href="' . get_edit_post_link( $next_post->ID ) . '" class="components-button is-button is-secondary is-large jw-next-post">' . __( 'Next', 'just-writing' ) . ' &nbsp;&nbsp;<span class="dashicons dashicons-controls-forward"></span></a>';
		}
	else
		{
		$next_post_button = '<a aria-disabled="true" class="components-button is-button is-secondary is-large jw-next-post">' . __( 'Next', 'just-writing' ) . '&nbsp;&nbsp;<span class="dashicons dashicons-controls-forward"></span></a>';
		}

	if( is_object( $previous_post ) )
		{
		$previous_post_button = '<a href="' . get_edit_post_link( $previous_post->ID ) . '" class="components-button is-button is-secondary is-large jw-prev-post"><span class="dashicons dashicons-controls-back"></span>&nbsp;&nbsp;'. __( 'Previous', 'just-writing' ) . '</a>';
		}
	else
		{
		$previous_post_button = '<a aria-disabled="true" class="components-button is-button is-secondary is-large jw-prev-post"><span class="dashicons dashicons-controls-back"></span>&nbsp;&nbsp;'. __( 'Previous', 'just-writing' ) . '</a>';
		}

?>
    <script>
    	function JustWritingGutenbergAddPrevNext() {
    		var pinned_items = jQuery( '<?php echo $location; ?>' );

    		if( typeof pinned_items === 'object' ) {
				pinned_items.before( '<?php echo $previous_post_button . $next_post_button; ?>' );

		        button = jQuery( 'div.components-panel__body.just-writing-wordcount-setting-panel > h2 > button');
		        button.click( JustWritingUpdateWordCount )


				JustWritingUpdateWordCount();
			} else {
				setTimeout( 'JustWritingGutenbergAddPrevNext()', 250 );
			}
    	}

		jQuery( document ).ready( function( $ ) {
			setTimeout( 'JustWritingGutenbergAddPrevNext()', 100 );
		} );
    </script>
<?php
	}