<?php 

function JustWritingEditorPage()
	{
	GLOBAL $JustWritingUtilities;
	
	// Set the current user and load the user preferences.
	$JustWritingUtilities->set_user_id( get_current_user_id() );
	$JustWritingUtilities->load_user_options();

	// Load the editor javascript and features.
	JustWritingLoadEditor();
	
	// Enqueue the editor stylesheet.
	wp_enqueue_style('justwriting-editor-css', plugin_dir_url(__FILE__) . 'editor.css', true, '4.1');
	wp_enqueue_style('justwriting-custom-editor-css', plugin_dir_url(__FILE__) . 'just-writing-editor.4.1.css', true, '4.1');
	wp_enqueue_style('jquery-ui-dialog', includes_url() . 'css/jquery-ui-dialog.css');
	
	//Enqueue the javascript.
	//wp_enqueue_script('justwriting-editor-js', plugin_dir_url(__FILE__) . 'just-writing-editor.4.1.js' );
	
	// Enqueue the tinymce plugin.
	wp_enqueue_script('justwriting-tinymce-plugin', plugin_dir_url(__FILE__) . 'tinymce/plugin.js', array( 'tiny_mce' ) );
		
	// Enqueue jQuery UI
	wp_enqueue_script( 'jquery-ui' );
	wp_enqueue_script( 'jquery-ui-dialog' );
		
	$width = isset( $content_width ) && 800 > $content_width ? $content_width : 800;
	$width = $width + 22; // compensate for the padding and border
	$dfw_width = get_user_setting( 'dfw_width', $width );

	$post_ID = 0;
	$SaveButtonLabel = __('Save');
	$SaveButtonDesc = $SaveButtonLabel;
	
	if( array_key_exists( 'post', $_GET ) ) { $post_ID = (int)$_GET['post']; $SaveButtonLabel = __('Update'); }
	
	if( $post_ID > 0 ) { 
		$post = get_post($post_ID); 
		$LastEditTime = strtotime( $post->post_modified ); 
	
		if ( $last_user = get_userdata( get_post_meta( $post_ID, '_edit_last', true ) ) ) {
			$SaveButtonDesc = sprintf(__('Last edited by %1$s on %2$s at %3$s'), esc_html( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		} else {
			$SaveButtonDesc = sprintf(__('Last edited on %1$s at %2$s'), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		}
	} else { 
		if( array_key_exists( 'page', $_GET ) ) { $post_type = strtolower( str_replace( 'JustWriting', '', $_GET['page'] ) ); } else { $post_type = 'post'; }
		$post = get_default_post_to_edit( $post_type, true); 
		$post_ID = $post->ID;
	}

	$nonce_action = 'update-post_' . $post_ID;

	$title = $post->post_title;
	
	$sendback = wp_get_referer();
	if( !$sendback )
		{
			$sendback = admin_url( 'edit.php' );
			$sendback .= ( ! empty( $post_type ) ) ? '?post_type=' . $post_type : '';
		}

	// Add in our menu bar
?>
	<div style="height: auto; width: 100%;" id="fullscreen-topbar">
		<div style="max-width: 100%; min-width: auto;" id="wp-fullscreen-toolbar">
			<div id="wp-fullscreen-central-toolbar" style="width: auto;">

				<div class="wp-tmce-mode" id="wp-fullscreen-mode-bar">
					<div id="wp-fullscreen-modes" class="button-group">
					<a class="button wp-fullscreen-mode-tinymce active" href="#" onclick="JustWritingSwitchEditor('html');">Visual</a>
					<a class="button wp-fullscreen-mode-html" href="#" onclick="JustWritingSwitchEditor('text');">Text</a>
				</div>
			</div>

			<div style="" id="wp-fullscreen-button-bar">
				<div id="wp-fullscreen-buttons" class="mce-toolbar">
<?php

	// Setup the buttons
	// format: title, onclick, type (separator or button), both (show in both editors), class, style
	$buttons = array();
	if( $JustWritingUtilities->get_user_option( 'separator_one' ) == 'on' ) 	{ $buttons['JustWritingSeparatorOne'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator', 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'cut' ) == 'on' ) 				{ $buttons['cut'] = array( 'title' => __('Cut (Ctrl + X)'),'onclick' => "tinyMCE.execCommand('cut');",'both' => true); }
	if( $JustWritingUtilities->get_user_option( 'copy' ) == 'on' ) 				{ $buttons['copy'] = array( 'title' => __('Copy (Ctrl + C)'), 'onclick' => "tinyMCE.execCommand('copy');", 'both' => true ); }
	if( $JustWritingUtilities->get_user_option( 'paste' ) == 'on' ) 			{ $buttons['paste'] = array( 'title' => __('Paste (Ctrl + V)'), 'onclick' => "tinyMCE.execCommand('paste');", 'both' => true ); }
	if( $JustWritingUtilities->get_user_option( 'pastetext' ) == 'on' ) 		{ $buttons['pastetext'] = array( 'title' => __('Paste as Text'), 'onclick' => "jQuery('.mce-i-pastetext').parent().parent().click();",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'separator_two' ) == 'on' ) 	{ $buttons['JustWritingSeparatorTwo'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'font_name' ) == 'on' ) 		{ $buttons['fontselector'] = array( 'title' => __('Font'), 'onclick' => "tinyMCE.execCommand('FontName', false, 'Arial Black');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'font_size' ) == 'on' ) 		{ $buttons['fontsize'] = array( 'title' => __('Font size'), 'onclick' => "tinyMCE.execCommand('FontSize', false, '32');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'font_color' ) == 'on' ) 		{ $buttons['fontcolor'] = array( 'title' => __('Font color'), 'onclick' => "",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'background_color' ) == 'on' ) 	{ $buttons['backgroundcolor'] = array( 'title' => __('Background Color'), 'onclick' => "",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'bold' ) == 'on' ) 				{ $buttons['bold'] = array( 'title' => __('Bold (Ctrl + B)'), 'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'bold');", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'italics' ) == 'on' ) 			{ $buttons['italic'] = array( 'title' => __('Italic (Ctrl + I)'), 'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'italic');", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'strike' ) == 'on' ) 			{ $buttons['strikethrough'] = array('title' => __('Strikethrough (Alt + Shift + D)'),'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'strikethrough');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'underline' ) == 'on' ) 		{ $buttons['underline'] = array('title' => __('Underline (Alt + Shift + U)'),'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'underline');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'subscript' ) == 'on' ) 		{ $buttons['subscript'] = array('title' => __('Subscript'),'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'subscript');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'superscript' ) == 'on' ) 		{ $buttons['superscript'] = array('title' => __('Superscript'),'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'superscript');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'remove_format' ) == 'on' ) 	{ $buttons['removeformat'] = array('title' => __('Remove Format (Alt + Shift + O)'),'onclick' => "tinyMCE.execCommand('removeformat');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'separator_three' ) == 'on' ) 	{ $buttons['JustWritingSeparatorThree'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'ul' ) == 'on' ) 				{ $buttons['bullist'] = array( 'title' => __('Unordered list (Alt + Shift + U)'), 'onclick' => "jQuery('.mce-i-bullist').parent().parent().click();", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'nl' ) == 'on' ) 				{ $buttons['numlist'] = array( 'title' => __('Ordered list (Alt + Shift + O)'),'onclick' => "jQuery('.mce-i-numlist').parent().parent().click();", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'media' ) == 'on' ) 			{ $buttons['image'] = array( 'title' => __('Insert/edit image (Alt + Shift + M)'), 'onclick' => "jQuery('#insert-media-button').click();", 'both' => true ); }
	if( $JustWritingUtilities->get_user_option( 'link' ) == 'on' ) 				{ $buttons['link'] = array( 'title' => __('Insert/edit link (Alt + Shift + A)'), 'onclick' => "jQuery('.mce-i-link').parent().parent().click();", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'unlink' ) == 'on' ) 			{ $buttons['unlink'] = array( 'title' => __('Unlink (Alt + Shift + S)'), 'onclick' => "jQuery('.mce-i-unlink').parent().parent().click();", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'separator_four' ) == 'on' ) 	{ $buttons['JustWritingSeparatorFour'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'left_justify' ) == 'on' ) 		{ $buttons['alignleft'] = array('title' => __('Align Left (Alt + Shift + L)'),'onclick' => "tinyMCE.execCommand('justifyleft');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'center_justify' ) == 'on' ) 	{ $buttons['aligncenter'] = array('title' => __('Align Centre (Alt + Shift + C)'),'onclick' => "tinyMCE.execCommand('justifycenter');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'right_justify' ) == 'on' ) 	{ $buttons['alignright'] = array('title' => __('Align Right (Alt + Shift + R)'),'onclick' => "tinyMCE.execCommand('justifyright');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'full_justify' ) == 'on' ) 		{ $buttons['alignjustify'] = array('title' => __('Justify'),'onclick' => "tinyMCE.execCommand('justifyfull');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'outdent' ) == 'on' ) 			{ $buttons['outdent'] = array('title' => __('Outdent'),'onclick' => "tinyMCE.execCommand('outdent');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'indent' ) == 'on' ) 			{ $buttons['indent'] = array('title' => __('Indent'),'onclick' => "tinyMCE.execCommand('indent');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'separator_five' ) == 'on' ) 	{ $buttons['JustWritingSeparatorFive'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'format_listbox' ) == 'on' ) 	{ $buttons['Paragraph'] = array('title' => __('Paragraph'),'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'p');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'separator_six' ) == 'on' ) 	{ $buttons['JustWritingSeparatorSix'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'spellcheck' ) == 'on' ) 		{ $buttons['spellchecker'] = array('title' => __('Proofread Writing'),'onclick' => "tinyMCE.execCommand('mceWritingImprovementTool');",'both' => true); }
	if( $JustWritingUtilities->get_user_option( 'more' ) == 'on' ) 				{ $buttons['wp_more'] = array('title' => __('Insert More Tag (Alt + Shift + T)'),'onclick' => "tinyMCE.execCommand('WP_More');",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'char_map' ) == 'on' ) 			{ $buttons['charmap'] = array('title' => __('Insert custom character'),'onclick' => "jQuery('.mce-i-charmap').parent().parent().click();",'both' => false); }
	if( $JustWritingUtilities->get_user_option( 'separator_seven' ) == 'on' ) 	{ $buttons['JustWritingSeparatorSeven'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }
	if( $JustWritingUtilities->get_user_option( 'undo' ) == 'on' ) 				{ $buttons['undo'] = array('title' => __('Undo (Ctrl + Z)'),'onclick' => "tinyMCE.execCommand('undo');",'both' => true); }
	if( $JustWritingUtilities->get_user_option( 'redo' ) == 'on' ) 				{ $buttons['redo'] = array('title' => __('Redo (Ctrl + Y)'),'onclick' => "tinyMCE.execCommand('redo');",'both' => true); }
	if( $JustWritingUtilities->get_user_option( 'help' ) == 'on' )				{ $buttons['help'] = array( 'title' => __('Help (Alt + Shift + H)'), 'onclick' => "jQuery('.mce-i-wp_help').parent().parent().click();", 'both' => false ); }
	if( $JustWritingUtilities->get_user_option( 'separator_eight' ) == 'on' ) 	{ $buttons['JustWritingSeparatorEight'] = array( 'title' => __('Separator'), 'onclick' => "", 'type' => 'separator','both' => false); }

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

		if( !array_key_exists( 'type', $args ) ) { $args['type'] = 'button'; }
		
		$style = '';
		$class = '';
		$outerclass = 'mce-widget';
		
		if( 'separator' != $args['type'] ) { $outerclass .= ' mce-btn'; }
		if( $args['both'] ) { $outerclass .= ' wp-fullscreen-both'; }
		
		$onclick = ! empty( $args['onclick'] ) ? ' onclick="' . $args['onclick'] . '"' : '';
		$title = esc_attr( $args['title'] );
		if( array_key_exists( 'style', $args ) ) { $style = ' style="' . $args['style'] . '"'; }
		if( array_key_exists( 'class', $args ) ) { $style = ' class="' . $args['class'] . '"'; }
			?>

			<div class="<?php echo $outerclass; ?>">
			<button type="button" aria-label="<?php echo $title; ?>" title="<?php echo $title; ?>"<?php echo $onclick; ?> id="wp_fs_<?php echo $button; ?>"<?php echo $style;?><?php echo $class;?>>
				<i class="mce-ico mce-i-<?php echo $button; ?>"></i>
			</button>
			</div>
			<?php
		}
?>		
				</div>
			</div>
			
			<div id="wp-fullscreen-save">
				<a style="margin-left: 5px; margin-bottom: 8px;" class="button right" onclick="JustWritingExit('<?php echo esc_attr( htmlspecialchars( $sendback ) ); ?>')"><?php _e('Exit');?></a>
				<a style="margin-left: 5px;" class="button right" href="http://localhost/wordpress/blog/2014/11/01/hello-world/" target="wp-preview-1"><?php _e('Preview');?></a>
				<input title="<?php echo $SaveButtonDesc; ?>" class="button button-primary right" value="<?php echo $SaveButtonLabel;?>" onclick="JustWritingAjaxSave();" type="button">
				<span class="wp-fullscreen-saved-message">Updated.</span>
				<span class="wp-fullscreen-error-message">Save failed.</span>
				<span class="spinner"></span>
			</div>			
		</div>
	</div>	
<?php	
	// Output the footer as well as the JavaScript popup div's.
?>

	<div id="wp-fullscreen-statusbar" class="wp-fullscreen-active">
		<div id="wp-fullscreen-status" style="width: <?php echo $dfw_width; ?>px;">
			<div id="wp-fullscreen-count">Word count: <span class="word-count">0</span></div>
			<div id="wp-fullscreen-tagline">Just Writing.</div>
		</div>
	</div>
</div>

<div id="just_writing_formatselect_menu" class="mce-container mce-panel mce-floatpanel mce-menu mce-menu-align" hidefocus="1" tabindex="-1" style="border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; left: 24px; top: 295px; width: 131px; z-index: 300000; display: none; position: fixed;" role="menu"> 
	<div id="just_writing_formatselect_menu_co" class="mce-container-body mce-stack-layout" style="width: 131px;"> 
		<div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'p' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Paragraph</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'address' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:16px;font-weight:400;font-style:italic;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Address</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="jQuery('.mce-i-blockquote').parent().parent().click(); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:16px;font-weight:400;font-style:italic;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Block Quote</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'pre' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Consolas;font-size:15px;font-weight:400;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:1px solid rgba(0, 0, 0, 0.102);border-radius:0px;"> Pre</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h1' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:26px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Header 1</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h2' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span id="mce_57-text" class="mce-text" style="font-family:Lato;font-size:24px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;" style="width: 131px;"> Header 2</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h3' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:22px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Header 3</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h4' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Header 4</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h5' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Header</span> 
		</div> 
		<div class="mce-menu-item mce-menu-item-normal mce-last mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="false" onclick="tinyMCE.execCommand( 'FormatBlock', false, 'h6' ); document.getElementById('just_writing_formatselect_menu').style.display='none';" style="width: 131px;"> 
			<i class="mce-ico mce-i-none"></i> 
			<span class="mce-text" style="font-family:Lato;font-size:16px;font-weight:700;font-style:normal;text-decoration:none;text-transform:none;color:rgb(43, 43, 43);padding:0 2px;border:0px rgb(43, 43, 43);border-radius:0px;"> Header 6</span> 
		</div> 
	</div> 
</div>

<div id="just_writing_fontselect_menu" class="mce-container mce-panel mce-floatpanel mce-menu mce-menu-align" hidefocus="1" tabindex="-1" style="border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; left: 24px; top: 295px; width: 131px; z-index: 300000; display: none; position: fixed;" role="menu"> <div id="just_writing_fontselect_menu_co" class="mce-container-body mce-stack-layout" style="width: 131px;"> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Andale Mono' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Andale Mono" style="font-family:andale mono,times"> Andale Mono</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Arial' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Arial" style="font-family:arial,helvetica,sans-serif"> Arial</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Arial Black' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Arial Black" style="font-family:arial black,avant garde"> Arial Black</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Book Antiqua' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Book Antiqua" style="font-family:book antiqua,palatino"> Book Antiqua</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Comic Sans MS' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Comic Sans MS" style="font-family:comic sans ms,sans-serif"> Comic Sans MS</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Courier New' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Courier New" style="font-family:courier new,courier"> Courier New</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Georgia' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Georgia" style="font-family:georgia,palatino"> Georgia</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Helvetica' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Helvetica" style="font-family:helvetica"> Helvetica</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Impact' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Impact" style="font-family:impact,chicago"> Impact</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Symbol' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Symbol" style="font-family:symbol"> Symbol</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Tahoma' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Tahoma" style="font-family:tahoma,arial,helvetica,sans-serif"> Tahoma</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Terminal' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Terminal" style="font-family:terminal,monaco"> Terminal</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Times New Roman' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Times New Roman" style="font-family:times new roman,times"> Times New Roman</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Trebuchet MS' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Trebuchet MS" style="font-family:trebuchet ms,geneva"> Trebuchet MS</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Verdana' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Verdana" style="font-family:verdana,geneva"> Verdana</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Webdings' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Webdings"> Webdings</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px;" onclick="tinyMCE.execCommand( 'FontName', false, 'Wingdings' ); document.getElementById('just_writing_fontselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="Wingdings"> Wingdings</span> </div> </div> </div>
<div id="just_writing_fontsizeselect_menu" class="mce-container mce-panel mce-floatpanel mce-menu mce-menu-align" hidefocus="1" tabindex="-1" style="border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; left: 24px; top: 295px; width: 131px; z-index: 300000; display: none; position: fixed;" role="menu"> <div id="just_writing_fontsizeselect_menu_co" class="mce-container-body mce-stack-layout" style="width: 131px;"> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 6pt" onclick="tinyMCE.execCommand( 'FontSize', false, '6pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="6pt" style="font-size:6pt"> 6pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 8pt" onclick="tinyMCE.execCommand( 'FontSize', false, '8pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="8pt" style="font-size:8pt"> 8pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 10pt" onclick="tinyMCE.execCommand( 'FontSize', false, '10pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="10pt" style="font-size:10pt"> 10pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 12pt" onclick="tinyMCE.execCommand( 'FontSize', false, '12pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="12pt" style="font-size:12pt"> 12pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 14pt" onclick="tinyMCE.execCommand( 'FontSize', false, '14pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="14pt" style="font-size:14pt"> 14pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 16pt" onclick="tinyMCE.execCommand( 'FontSize', false, '16pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="16pt" style="font-size:16pt"> 16pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 18pt" onclick="tinyMCE.execCommand( 'FontSize', false, '18pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="18pt" style="font-size:18pt"> 18pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 20pt" onclick="tinyMCE.execCommand( 'FontSize', false, '20pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="20pt" style="font-size:20pt"> 20pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 22pt" onclick="tinyMCE.execCommand( 'FontSize', false, '22pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="22pt" style="font-size:22pt"> 22pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 24pt" onclick="tinyMCE.execCommand( 'FontSize', false, '24pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="24pt" style="font-size:24pt"> 24pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 28pt" onclick="tinyMCE.execCommand( 'FontSize', false, '28pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="28pt" style="font-size:28pt"> 28pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 32pt" onclick="tinyMCE.execCommand( 'FontSize', false, '32pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="32pt" style="font-size:32pt"> 32pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 36pt" onclick="tinyMCE.execCommand( 'FontSize', false, '36pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="36pt" style="font-size:36pt"> 36pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 40pt" onclick="tinyMCE.execCommand( 'FontSize', false, '40pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="40pt" style="font-size:40pt"> 40pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 44pt" onclick="tinyMCE.execCommand( 'FontSize', false, '44pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="44pt" style="font-size:44pt"> 44pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 48pt" onclick="tinyMCE.execCommand( 'FontSize', false, '48pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="48pt" style="font-size:48pt"> 48pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 52pt" onclick="tinyMCE.execCommand( 'FontSize', false, '52pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="52pt" style="font-size:52pt"> 52pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 62pt" onclick="tinyMCE.execCommand( 'FontSize', false, '62pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="62pt" style="font-size:62pt"> 62pt</span> </div> <div class="mce-menu-item mce-menu-item-normal mce-first mce-stack-layout-item" tabindex="-1" role="menuitem" aria-pressed="true" style="width: 131px; height: 72pt" onclick="tinyMCE.execCommand( 'FontSize', false, '72pt' ); document.getElementById('just_writing_fontsizeselect_menu').style.display='none';"> <i class="mce-ico mce-i-none"> </i> <span class="mce-text" title="72pt" style="font-size:72pt"> 72pt</span> </div> </div> </div>
<div class="JustWritingColorPopup" id="JustWritingFontColorPopup"><div class="JustWritingColorSwatch" style="background-color: #000000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#000000')"></div><div class="JustWritingColorSwatch" style="background-color: #0000FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#0000FF')"></div><div class="JustWritingColorSwatch" style="background-color: #0000A0;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#0000A0')"></div><div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#ADD8E6')"></div><div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#A52A2A')"></div><div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#00FFFF')"></div><div class="JustWritingColorSwatch" style="background-color: #008000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#008000')"></div><div class="JustWritingColorSwatch" style="background-color: #808080;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#808080')"></div><div class="JustWritingColorSwatch" style="background-color: #00FF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#00FF00')"></div><div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#FF00FF')"></div><div class="JustWritingColorSwatch" style="background-color: #800000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#800000')"></div><div class="JustWritingColorSwatch" style="background-color: #808000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#808000')"></div><div class="JustWritingColorSwatch" style="background-color: #FFA500;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#FFA500')"></div><div class="JustWritingColorSwatch" style="background-color: #800080;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#800080')"></div><div class="JustWritingColorSwatch" style="background-color: #FF0000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#FF0000')"></div><div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#C0C0C0')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#FFFFFF')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect('#FFFF00')"></div></div>
<div class="JustWritingColorPopup" id="JustWritingBackgroundColorPopup"><div class="JustWritingColorSwatch" style="background-color: #000000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#000000')"></div><div class="JustWritingColorSwatch" style="background-color: #0000FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#0000FF')"></div><div class="JustWritingColorSwatch" style="background-color: #0000A0;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#0000A0')"></div><div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#ADD8E6')"></div><div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#A52A2A')"></div><div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#00FFFF')"></div><div class="JustWritingColorSwatch" style="background-color: #008000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#008000')"></div><div class="JustWritingColorSwatch" style="background-color: #808080;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#808080')"></div><div class="JustWritingColorSwatch" style="background-color: #00FF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#00FF00')"></div><div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#FF00FF')"></div><div class="JustWritingColorSwatch" style="background-color: #800000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#800000')"></div><div class="JustWritingColorSwatch" style="background-color: #808000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#808000')"></div><div class="JustWritingColorSwatch" style="background-color: #FFA500;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#FFA500')"></div><div class="JustWritingColorSwatch" style="background-color: #800080;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#800080')"></div><div class="JustWritingColorSwatch" style="background-color: #FF0000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#FF0000')"></div><div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#C0C0C0')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#FFFFFF')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect('#FFFF00')"></div></div>

<div id="dialog-save-before-exit" title="Save changes?" style="display: none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Changes have been made, would you like to save them before exiting?</p>
</div>
<?php
	// Output the title and create the TinyMCE instance.

	
	?>
<form name="post" action="post.php" method="post" id="post">

	<?php wp_nonce_field( $nonce_action ); echo "\n"; ?>
	<input type="hidden" id="hiddenaction" name="action" value="wp-fullscreen-save-post" />
	<input type="hidden" id="originalaction" name="originalaction" value="editpost" />
	<input type="hidden" id="post_author" name="post_author" value="<?php echo $post->post_author; ?>" />
	<input type="hidden" id="post_type" name="post_type" value="<?php echo $post->post_type; ?>" />
	<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo $post->post_status; ?>" />
	<input type="hidden" id="referredby" name="referredby" value="http://localhost/wordpress/wp-admin/edit.php" />
	<input type="hidden" name="_wp_original_http_referer" value="http://localhost/wordpress/wp-admin/edit.php" />
	<input type='hidden' id='post_ID' name='post_ID' value='<?php echo $post->ID;?>' />
	<?php //wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); echo "\n"; ?>
	<?php //wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); echo "\n"; ?>
	
	<div style="padding-top: 54px; width: <?php echo $dfw_width;?>px; display: block; margin-left: auto; margin-right: auto;" id="wp-content-wrap" class="wp-core-ui wp-editor-wrap tmce-active has-dfw wp-fullscreen-wrap wp-fullscreen-active">
		<input class="wp-fullscreen-title" style="width: 100%; margin-bottom: 24px;" spellcheck="true" name="post_title" size="30" id="title" autocomplete="off" type="text" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>">
		<?php wp_editor( $post->post_content, 'post_content', array('media_buttons' => true, 'tinymce' => array( 'wp_autoresize_on' => true ) ) ); ?>
	</div>

</form>
<?php
	}
	
?>