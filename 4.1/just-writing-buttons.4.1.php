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

	$buttons = $oldbuttons;
	
	// clear out the default buttons
	$buttons = array();

	if( $JustWritingUtilities->get_user_option( 'separator_one' ) == 'on' )
		{
		$buttons['JustWritingSeparatorOne'] = array( 
											// Title of the button
											'title' => __('Separator'), 
											// Command to execute
											'onclick' => "", 
											// Define as a separator so the button class doesn't get added.
											'type' => 'separator',
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'cut' ) == 'on' )
		{
		$buttons['cut'] = array( 
											// Title of the button
											'title' => __('Cut (Ctrl + X)'), 
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
											'title' => __('Copy (Ctrl + C)'), 
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
											'title' => __('Paste (Ctrl + V)'), 
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
											'title' => __('Paste as Text'), 
											// Command to execute
											'onclick' => "jQuery('.mce-i-pastetext').parent().parent().click();",
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_two' ) == 'on' )
		{
		$buttons['JustWritingSeparatorTwo'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'font_name' ) == 'on' )
		{
		$buttons['fontselector'] = array( 
								// Title of the button
								'title' => __('Font'), 
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
								'title' => __('Font size'), 
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
								'title' => __('Font color'), 
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
								'title' => __('Background Color'), 
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
										'title' => __('Bold (Ctrl + B)'), 
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'bold');", 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'italics' ) == 'on' )
		{
		$buttons['italic'] = array( 
										// Title of the button
										'title' => __('Italic (Ctrl + I)'), 
										// Command to execute
										'onclick' => "tinyMCE.execCommand('FormatBlock', false, 'italic');", 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( $JustWritingUtilities->get_user_option( 'strike' ) == 'on' )
		{
		$buttons['strikethrough'] = array(
										// Title of the button
										'title' => __('Strikethrough (Alt + Shift + D)'),
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
										'title' => __('Underline (Alt + Shift + U)'),
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
										'title' => __('Subscript'),
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
										'title' => __('Superscript'),
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
										'title' => __('Remove Format (Alt + Shift + O)'),
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
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'ul' ) == 'on' )
		{
		$buttons['bullist'] = array( 
										// Title of the button
										'title' => __('Unordered list (Alt + Shift + U)'), 
										// Command to execute
										'onclick' => "jQuery('.mce-i-bullist').parent().parent().click();", 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'nl' ) == 'on' )
		{
		$buttons['numlist'] = array( 
										// Title of the button
										'title' => __('Ordered list (Alt + Shift + O)'),
										// Command to execute
										'onclick' => "jQuery('.mce-i-numlist').parent().parent().click();", 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'media' ) == 'on' )
		{
		$buttons['image'] = array( 
										// Title of the button
										'title' => __('Insert/edit image (Alt + Shift + M)'), 
										// Command to execute
										'onclick' => "jQuery('#insert-media-button').click();", 
										// Show on visual AND html mode
										'both' => true 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'link' ) == 'on' )
		{
		$buttons['link'] = array( 
										// Title of the button
										'title' => __('Insert/edit link (Alt + Shift + A)'), 
										// Command to execute
										'onclick' => "jQuery('.mce-i-link').parent().parent().click();", 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( $JustWritingUtilities->get_user_option( 'unlink' ) == 'on' )
		{
		$buttons['unlink'] = array( 
										// Title of the button
										'title' => __('Unlink (Alt + Shift + S)'), 
										// Command to execute
										'onclick' => "jQuery('.mce-i-unlink').parent().parent().click();", 
										// Show on visual AND html mode
										'both' => false 
						);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_four' ) == 'on' )
		{
		$buttons['JustWritingSeparatorFour'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'left_justify' ) == 'on' )
		{
		$buttons['alignleft'] = array(
										// Title of the button
										'title' => __('Align Left (Alt + Shift + L)'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyleft');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'center_justify' ) == 'on' )
		{
		$buttons['aligncenter'] = array(
										// Title of the button
										'title' => __('Align Centre (Alt + Shift + C)'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifycenter');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'right_justify' ) == 'on' )
		{
		$buttons['alignright'] = array(
										// Title of the button
										'title' => __('Align Right (Alt + Shift + R)'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyright');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'full_justify' ) == 'on' )
		{
		$buttons['alignjustify'] = array(
										// Title of the button
										'title' => __('Justify'),
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
										'title' => __('Outdent'),
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
										'title' => __('Indent'),
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
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( $JustWritingUtilities->get_user_option( 'p_format' ) == 'on' || $JustWritingUtilities->get_user_option( 'format_listbox' ) == 'on' )
		{
		$buttons['Paragraph'] = array(
										// Title of the button
										'title' => __('Paragraph'),
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
											'title' => __('H1'),
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
											'title' => __('H2'),
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
											'title' => __('H3'),
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
											'title' => __('H4'),
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
											'title' => __('H5'),
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
											'title' => __('H6'),
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
											'title' => __('Blockquote (Alt + Shift + Q)'), 
											// Command to execute
											'onclick' => "jQuery('.mce-i-blockquote').parent().parent().click();", 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( $JustWritingUtilities->get_user_option( 'address_format' ) == 'on' )
			{
			$buttons['Address'] = array(
											// Title of the button
											'title' => __('Address'),
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
											'title' => __('Preformatted'),
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
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'spellcheck' ) == 'on' )
		{
		$buttons['spellchecker'] = array(
										// Title of the button
										'title' => __('Proofread Writing'),
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
										'title' => __('Insert More Tag (Alt + Shift + T)'),
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
										'title' => __('Insert custom character'),
										// Command to execute
										'onclick' => "jQuery('.mce-i-charmap').parent().parent().click();",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( $JustWritingUtilities->get_user_option( 'separator_seven' ) == 'on' )
		{
		$buttons['JustWritingSeparatorSeven'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}
	if( $JustWritingUtilities->get_user_option( 'undo' ) == 'on' )
		{
		$buttons['undo'] = array(
										// Title of the button
										'title' => __('Undo (Ctrl + Z)'),
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
										'title' => __('Redo (Ctrl + Y)'),
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
										'title' => __('Help (Alt + Shift + H)'), 
										// Command to execute
										'onclick' => "jQuery('.mce-i-wp_help').parent().parent().click();", 
										// Show on visual AND html mode
										'both' => false 
								);
		}

	if( $JustWritingUtilities->get_user_option( 'separator_eight' ) == 'on' )
		{
		$buttons['JustWritingSeparatorEight'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Define as a separator so the button class doesn't get added.
										'type' => 'separator',
										// Show on visual AND html mode
										'both' => false
									);
		}

	// This is a 'fake' button we're use during the JavaScript code to get the current translation of "Exit".
	$buttons['JustWritingExit'] = array( 
									// Title of the button
									'title' => __('Exit'), 
									// Command to execute
									'onclick' => "",
									// Show on visual AND html mode
									'both' => false
								);

	return $buttons;
	}
?>