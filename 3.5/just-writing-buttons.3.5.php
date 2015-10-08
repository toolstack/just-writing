<?php
/*
	This function modifies the button list for the DFWM.  We don't use the button array passed by WordPress at all so it's just a throw away variable.
	
	$oldbuttons = the button array passed to us by WordPress.
 */
function JustWriting( $oldbuttons )
	{
	GLOBAL $JustWritingUtilities;

	// Set the current user and load the user preferences.
	$JustWritingUtilities->set_user_id( get_current_user_id() );
	$JustWritingUtilities->load_user_options();

	// clear out the default buttons
	$buttons = array();

	if( $JustWritingUtilities->get_user_option( 'separator_one' ) == 'on' )
		{
		$buttons['JustWritingSeparatorOne'] = array( 
											// Title of the button
											'title' => __('Separator', 'just-writing'), 
											// Command to execute
											'onclick' => "", 
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'cut' ) == 'on' )
		{
		$buttons['cut'] = array( 
											// Title of the button
											'title' => __('Cut (Ctrl + X)', 'just-writing'), 
											// Command to execute
											'onclick' => "tinyMCE.execCommand('cut');", 
											// Show on visual AND html mode
											'both' => true 
							);
		}
		
	if( $JustWritingUtilities->get_user_option( 'copy' ) == 'on' )
		{
		$buttons['copy'] = array( 
											// Title of the button
											'title' => __('Copy (Ctrl + C)', 'just-writing'), 
											// Command to execute
											'onclick' => "tinyMCE.execCommand('copy');", 
											// Show on visual AND html mode
											'both' => true 
							);
		}
		
	if( $JustWritingUtilities->get_user_option( 'paste' ) == 'on' )
		{
		$buttons['paste'] = array( 
											// Title of the button
											'title' => __('Paste (Ctrl + V)', 'just-writing'), 
											// Command to execute
											'onclick' => "tinyMCE.execCommand('paste');", 
											// Show on visual AND html mode
											'both' => true 
							);
		}

	if( $JustWritingUtilities->get_user_option( 'pastetext' ) == 'on' )
		{
		$buttons['pastetext'] = array( 
											// Title of the button
											'title' => __('Paste as Text', 'just-writing'), 
											// Command to execute
											'onclick' => "tinyMCE.execCommand('mcePasteText');", 
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'pasteword' ) == 'on' )
		{
		$buttons['pasteword'] = array( 
											// Title of the button
											'title' => __('Paste as Word', 'just-writing'), 
											// Command to execute
											'onclick' => "tinyMCE.execCommand('mcePasteWord');", 
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_two' ) == 'on' )
		{
		$buttons['JustWritingSeparatorTwo'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'font_name' ) == 'on' )
		{
		$buttons['fontselector'] = array( 
								// Title of the button
								'title' => __('Font', 'just-writing'), 
								// Command to execute
								'onclick' => "tinyMCE.execCommand('FontName', false, 'Arial Black');",
								// Show on visual AND html mode
								'both' => false
							);
		}
		
	if( $JustWritingUtilities->get_user_option( 'font_size' ) == 'on' )
		{
		$buttons['fontsize'] = array( 
								// Title of the button
								'title' => __('Font size', 'just-writing'), 
								// Command to execute
								'onclick' => "tinyMCE.execCommand('FontSize', false, '32');",
								// Show on visual AND html mode
								'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'font_color' ) == 'on' )
		{
		$buttons['fontcolor'] = array( 
								// Title of the button
								'title' => __('Font color', 'just-writing'), 
								// Command to execute
								'onclick' => "",
								// Show on visual AND html mode
								'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'background_color' ) == 'on' )
		{
		$buttons['backgroundcolor'] = array( 
								// Title of the button
								'title' => __('Background Color', 'just-writing'), 
								// Command to execute
								'onclick' => "",
								// Show on visual AND html mode
								'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'bold' ) == 'on' )
		{
		$buttons['bold'] = array( 
										// Title of the button
										'title' => __('Bold (Ctrl + B)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.b();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'italics' ) == 'on' )
		{
		$buttons['italic'] = array( 
										// Title of the button
										'title' => __('Italic (Ctrl + I)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.i();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'strike' ) == 'on' )
		{
		$buttons['strikethrough'] = array(
										// Title of the button
										'title' => __('Strikethrough (Alt + Shift + D)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'strikethrough');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'underline' ) == 'on' )
		{
		$buttons['underline'] = array(
										// Title of the button
										'title' => __('Underline (Alt + Shift + U)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'underline');",
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'subscript' ) == 'on' )
		{
		$buttons['subscript'] = array(
										// Title of the button
										'title' => __('Subscript', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'subscript');",
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'superscript' ) == 'on' )
		{
		$buttons['superscript'] = array(
										// Title of the button
										'title' => __('Superscript', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'superscript');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'remove_format' ) == 'on' )
		{
		$buttons['removeformat'] = array(
										// Title of the button
										'title' => __('Remove Format (Alt + Shift + O)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('removeformat');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'separator_three' ) == 'on' )
		{
		$buttons['JustWritingSeparatorThree'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'ul' ) == 'on' )
		{
		$buttons['bullist'] = array( 
										// Title of the button
										'title' => __('Unordered list (Alt + Shift + U)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.ul();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'nl' ) == 'on' )
		{
		$buttons['numlist'] = array( 
										// Title of the button
										'title' => __('Ordered list (Alt + Shift + O)', 'just-writing'),
										// Command to execute
										'onclick' => 'fullscreen.ol();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'media' ) == 'on' )
		{
		$buttons['image'] = array( 
										// Title of the button
										'title' => __('Insert/edit image (Alt + Shift + M)', 'just-writing'), 
										// Command to execute
										'onclick' => "fullscreen.medialib();", 
										// Show on visual AND html mode
										'both' => true 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'link' ) == 'on' )
		{
		$buttons['link'] = array( 
										// Title of the button
										'title' => __('Insert/edit link (Alt + Shift + A)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.link();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'unlink' ) == 'on' )
		{
		$buttons['unlink'] = array( 
										// Title of the button
										'title' => __('Unlink (Alt + Shift + S)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.unlink();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_four' ) == 'on' )
		{
		$buttons['JustWritingSeparatorFour'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'left_justify' ) == 'on' )
		{
		$buttons['justifyleft'] = array(
										// Title of the button
										'title' => __('Align Left (Alt + Shift + L)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyleft');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'center_justify' ) == 'on' )
		{
		$buttons['justifycenter'] = array(
										// Title of the button
										'title' => __('Align Centre (Alt + Shift + C)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifycenter');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'right_justify' ) == 'on' )
		{
		$buttons['justifyright'] = array(
										// Title of the button
										'title' => __('Align Right (Alt + Shift + R)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyright');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'full_justify' ) == 'on' )
		{
		$buttons['justifyfull'] = array(
										// Title of the button
										'title' => __('Justify', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyfull');",
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'outdent' ) == 'on' )
		{
		$buttons['outdent'] = array(
										// Title of the button
										'title' => __('Outdent', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('outdent');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'indent' ) == 'on' )
		{
		$buttons['indent'] = array(
										// Title of the button
										'title' => __('Indent', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('indent');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'separator_five' ) == 'on' )
		{
		$buttons['JustWritingSeparatorFive'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'p_format' ) == 'on' || $JustWritingUtilities->get_user_option( 'format_listbox' ) == 'on' )
		{
		$buttons['Paragraph'] = array(
										// Title of the button
										'title' => __('Paragraph', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'p');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'format_listbox' ) != 'on' )
		{
		if( $JustWritingUtilities->get_user_option( 'h1_format' ) == 'on' )
			{
			$buttons['H1'] = array(
											// Title of the button
											'title' => __('H1', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h1');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'h2_format' ) == 'on' )
			{
			$buttons['H2'] = array(
											// Title of the button
											'title' => __('H2', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h2');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'h3_format' ) == 'on' )
			{
			$buttons['H3'] = array(
											// Title of the button
											'title' => __('H3', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h3');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'h4_format' ) == 'on' )
			{
			$buttons['H4'] = array(
											// Title of the button
											'title' => __('H4', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h4');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'h5_format' ) == 'on' )
			{
			$buttons['H5'] = array(
											// Title of the button
											'title' => __('H5', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h5');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'h6_format' ) == 'on' )
			{
			$buttons['H6'] = array(
											// Title of the button
											'title' => __('H6', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'h6');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'quotes' ) == 'on' )
			{
			$buttons['blockquote'] = array( 
											// Title of the button
											'title' => __('Blockquote (Alt + Shift + Q)', 'just-writing'), 
											// Command to execute
											'onclick' => 'fullscreen.blockquote();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( $JustWritingUtilities->get_user_option( 'address_format' ) == 'on' )
			{
			$buttons['Address'] = array(
											// Title of the button
											'title' => __('Address', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'address');",
											// Show on visual AND html mode
											'both' => false
										);
			}
			
		if( $JustWritingUtilities->get_user_option( 'pre_format' ) == 'on' )
			{
			$buttons['Preformatted'] = array(
											// Title of the button
											'title' => __('Preformatted', 'just-writing'),
											// Command to execute
											'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'pre');",
											// Show on visual AND html mode
											'both' => false
										);
			}
		}

	if( $JustWritingUtilities->get_user_option( 'separator_six' ) == 'on' )
		{
		$buttons['JustWritingSeparatorSix'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'spellcheck' ) == 'on' )
		{
		$buttons['spellchecker'] = array(
										// Title of the button
										'title' => __('Proofread Writing', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('mceWritingImprovementTool');",
										// Show on visual AND html mode
										'both' => true
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'more' ) == 'on' )
		{
		$buttons['wp_more'] = array(
										// Title of the button
										'title' => __('Insert More Tag (Alt + Shift + T)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('WP_More');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'char_map' ) == 'on' )
		{
		$buttons['charmap'] = array(
										// Title of the button
										'title' => __('Insert custom character', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('mceCharMap');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'separator_seven' ) == 'on' )
		{
		$buttons['JustWritingSeparatorSeven'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}
	if( $JustWritingUtilities->get_user_option( 'undo' ) == 'on' )
		{
		$buttons['undo'] = array(
										// Title of the button
										'title' => __('Undo (Ctrl + Z)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('undo');",
										// Show on visual AND html mode
										'both' => true
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'redo' ) == 'on' )
		{
		$buttons['redo'] = array(
										// Title of the button
										'title' => __('Redo (Ctrl + Y)', 'just-writing'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('redo');",
										// Show on visual AND html mode
										'both' => true
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'help' ) == 'on' )
		{
		$buttons['help'] = array( 
										// Title of the button
										'title' => __('Help (Alt + Shift + H)', 'just-writing'), 
										// Command to execute
										'onclick' => 'fullscreen.help();', 
										// Show on visual AND html mode
										'both' => false 
								);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_eight' ) == 'on' )
		{
		$buttons['JustWritingSeparatorEight'] = array( 
										// Title of the button
										'title' => __('Separator', 'just-writing'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	// This is a 'fake' button we're use during the JavaScript code to get the current translation of "Exit".
	$buttons['JustWritingExit'] = array( 
									// Title of the button
									'title' => __('Exit', 'just-writing'), 
									// Command to execute
									'onclick' => "",
									// Show on visual AND html mode
									'both' => false
								);

	return $buttons;
	}
?>