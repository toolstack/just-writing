<?php
/*
	This function modifies the button list for the DFWM.  We don't use the button array passed by WordPress at all so it's just a throw away variable.
	
	$oldbuttons = the button array passed to us by WordPress.
 */
function JustWriting( $oldbuttons )
	{
	$cuid = get_current_user_id();

	$buttons = $oldbuttons;
	
	// clear out the default buttons
	$buttons = array();

	if( get_the_author_meta( 'just_writing_separatorone', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorOne'] = array( 
											// Title of the button
											'title' => __('Separator'), 
											// Command to execute
											'onclick' => "", 
											// Show on visual AND html mode
											'both' => false
							);
		}

	if( get_the_author_meta( 'just_writing_cut', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_copy', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_paste', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_pastetext', $cuid ) == 'on' )
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

/*
	Paste as Word was removed in WP3.9 so it is no longer required.
		
	if( get_the_author_meta( 'just_writing_pasteword', $cuid ) == 'on' )
		{
		$buttons['pasteword'] = array( 
											// Title of the button
											'title' => __('Paste as Word'), 
											// Command to execute
											'onclick' => "jQuery('.mce-i-pasteword').parent().parent().click();",
											// Show on visual AND html mode
											'both' => false
							);
		}
*/
	if( get_the_author_meta( 'just_writing_separatortwo', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorTwo'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
						);
		}
		
	if( get_the_author_meta( 'just_writing_f_n', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_f_s', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_f_c', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_b_c', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_bold', $cuid ) == 'on' )
		{
		$buttons['bold'] = array( 
										// Title of the button
										'title' => __('Bold (Ctrl + B)'), 
										// Command to execute
										'onclick' => 'fullscreen.b();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( get_the_author_meta( 'just_writing_italics', $cuid ) == 'on' )
		{
		$buttons['italic'] = array( 
										// Title of the button
										'title' => __('Italic (Ctrl + I)'), 
										// Command to execute
										'onclick' => 'fullscreen.i();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
		
	if( get_the_author_meta( 'just_writing_strike', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_under', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_subscript', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_superscript', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_remove', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_separatorthree', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorThree'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( get_the_author_meta( 'just_writing_ul', $cuid ) == 'on' )
		{
		$buttons['bullist'] = array( 
										// Title of the button
										'title' => __('Unordered list (Alt + Shift + U)'), 
										// Command to execute
										'onclick' => 'fullscreen.ul();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( get_the_author_meta( 'just_writing_nl', $cuid ) == 'on' )
		{
		$buttons['numlist'] = array( 
										// Title of the button
										'title' => __('Ordered list (Alt + Shift + O)'),
										// Command to execute
										'onclick' => 'fullscreen.ol();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( get_the_author_meta( 'just_writing_media', $cuid ) == 'on' )
		{
		$buttons['image'] = array( 
										// Title of the button
										'title' => __('Insert/edit image (Alt + Shift + M)'), 
										// Command to execute
										'onclick' => "fullscreen.medialib();", 
										// Show on visual AND html mode
										'both' => true 
						);
		}
						
	if( get_the_author_meta( 'just_writing_link', $cuid ) == 'on' )
		{
		$buttons['link'] = array( 
										// Title of the button
										'title' => __('Insert/edit link (Alt + Shift + A)'), 
										// Command to execute
										'onclick' => 'fullscreen.link();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}
						
	if( get_the_author_meta( 'just_writing_unlink', $cuid ) == 'on' )
		{
		$buttons['unlink'] = array( 
										// Title of the button
										'title' => __('Unlink (Alt + Shift + S)'), 
										// Command to execute
										'onclick' => 'fullscreen.unlink();', 
										// Show on visual AND html mode
										'both' => false 
						);
		}

	if( get_the_author_meta( 'just_writing_separatorfour', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorFour'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( get_the_author_meta( 'just_writing_left', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_center', $cuid ) == 'on' )
		{
		$buttons['aligncenter'] = array(
										// Title of the button
										'title' => __('Align Full (Alt + Shift + C)'),
										// Command to execute
										'onclick' => "tinyMCE.execCommand('justifyfull');",
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( get_the_author_meta( 'just_writing_right', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_outdent', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_indent', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_separatorfive', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorFive'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}

	if( get_the_author_meta( 'just_writing_p', $cuid ) == 'on' || get_the_author_meta( 'just_writing_f_lb', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_f_lb', $cuid ) != 'on' )
		{
		if( get_the_author_meta( 'just_writing_h1', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_h2', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_h3', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_h4', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_h5', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_h6', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_quotes', $cuid ) == 'on' )
			{
			$buttons['blockquote'] = array( 
											// Title of the button
											'title' => __('Blockquote (Alt + Shift + Q)'), 
											// Command to execute
											'onclick' => 'fullscreen.blockquote();', 
											// Show on visual AND html mode
											'both' => false 
							);
			}
							
		if( get_the_author_meta( 'just_writing_address', $cuid ) == 'on' )
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
			
		if( get_the_author_meta( 'just_writing_pf', $cuid ) == 'on' )
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

	if( get_the_author_meta( 'just_writing_separatorsix', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorSix'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}
		
	if( get_the_author_meta( 'just_writing_spell', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_more', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_char', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_separatorseven', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorSeven'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
										// Show on visual AND html mode
										'both' => false
									);
		}
	if( get_the_author_meta( 'just_writing_undo', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_redo', $cuid ) == 'on' )
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
		
	if( get_the_author_meta( 'just_writing_help', $cuid ) == 'on' )
		{
		$buttons['help'] = array( 
										// Title of the button
										'title' => __('Help (Alt + Shift + H)'), 
										// Command to execute
										'onclick' => 'fullscreen.help();', 
										// Show on visual AND html mode
										'both' => false 
								);
		}

	if( get_the_author_meta( 'just_writing_separatoreight', $cuid ) == 'on' )
		{
		$buttons['JustWritingSeparatorEight'] = array( 
										// Title of the button
										'title' => __('Separator'), 
										// Command to execute
										'onclick' => "", 
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