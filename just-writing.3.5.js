var JustWritingAutoLoadIntervalID = null;
var JustWritingToolbarCenterID = null;
var JustWritingTinyMCECurrentSelection = null;

/*
	This function returns the index of specific JavaScript file we're looking for.
	
	name = the file name of the script to look for
*/
function GetScriptIndex( name )
	{
	var i;
	
	// Loop through all the scripts in the current document to find the one we want.
	for( i = 0; i < document.scripts.length; i++ ) 
		{
		// Make a temporary copy of the URI and find out where the query string starts.
		var tmp_src = String( document.scripts[i].src );
		var qs_index = tmp_src.indexOf( '?' );

		// Check if the script is the script we are looking for and if it has a QS, if so return the current index.
		if( tmp_src.indexOf( name ) >= 0 && qs_index >= 0)
			{
			return i;
			}
		}
		
	return -1;
	}

/*
	This function retuns the value of a variable passed on the URI of a JavaScript file.
*/
function GetScriptVariable( index, name, vardef )
	{
	// If a negative index has been passed in it's because we didn't find any matching script with a query
	// string, so just return the default value.
	if( index < 0 )
		{
		return vardef;
		}

	// Make a temporary copy of the URI and find out where the query string starts.
	var tmp_src = String( document.scripts[index].src );
	var qs_index = tmp_src.indexOf( '?' );

	// Split the query string in to var/value pairs.  ie: 'var1=value1', 'var2=value2', ...
	var params_raw = tmp_src.substr( qs_index + 1 ).split( '&' );
	var j;
	
	// Now look for the one we want.
	for( j = 0; j < params_raw.length; j++ )
		{
		// Split names from the values.
		var pp_raw = params_raw[j].split( '=' );

		// If this is the one we're looking for, simply return it.
		if( pp_raw[0] == name )
			{
			// Check to make sure a value was actually passed in, otherwise we should return the default later on.
			if( typeof( pp_raw[1] ) != 'undefined' )
				{
				return pp_raw[1];
				}
			}
		}

	// If we fell through the loop and didn't find ANY matching variable, simply return the default value.
	return vardef;
	}

/*
	This is the main function called on the edit post/page page.
*/
function JustWriting()
	{
	// Find the TopBar <div> in the current page.
	var TopBar = document.getElementById( 'fullscreen-topbar' );
	
	// If we didn't find the parent, don't bother doing anything else.
	if( TopBar )
		{
		var ToolBar = document.getElementById( 'wp-fullscreen-toolbar' );
		var CentralBar = document.getElementById( 'wp-fullscreen-central-toolbar' );
		var ButtonBar = document.getElementById( 'wp-fullscreen-button-bar' );
		var TagLine = document.getElementById( 'wp-fullscreen-tagline' );

		// Setup the toolbar to auto-resize so it looks right with all the new buttons.
		TopBar.style.height = 'auto';
		ToolBar.style.maxWidth = '100%';
		ToolBar.style.minWidth = 'auto';
		TopBar.style.minWidth = 'auto';
		CentralBar.style.width = 'auto';
		ButtonBar.style.width = 'auto';

		// Replace the 'Just Write.' tagline :)
		TagLine.innerHTML = 'Just Writing.';

		// Hide the default exit link
		JustWritingElementSetDisplay( 'wp-fullscreen-close', 'none' );

		// Time to get the options the user has selected from the script call
		var GSI = GetScriptIndex( 'just-writing.3.5.js' );
		var DisableFade = GetScriptVariable( GSI, 'disablefade', 0 );
		var HideWordCount = GetScriptVariable( GSI, 'hidewordcount', 0 );
		var HidePreview = GetScriptVariable( GSI, 'hidepreview', 0 );
		var HideBorder = GetScriptVariable( GSI, 'hideborder', 0 );
		var HideModeBar = GetScriptVariable( GSI, 'hidemodebar', 0 );
		var AutoLoad = GetScriptVariable( GSI, 'autoload', 0 );
		var FormatLB = GetScriptVariable( GSI, 'formatlistbox', 0 );
		var rtl = GetScriptVariable( GSI, 'rtl', 0 );
		var CenterToolbar = GetScriptVariable( GSI, 'centertb', 0 );
		var DisableJSPickers = GetScriptVariable( GSI, 'disablejscp', 0 );

		// If the user has selected to keep the toolbar visible at all times, setup a recurring function to fake a mouse move.
		if( DisableFade == 1 )
			{
			setInterval( JustWritingMoveMouse, 1500 );
			}

		// If we're supposed to autoload the DFWM, check to see if TinyMCE has finished loading every 100ms.
		if( AutoLoad == 1 )
			{
			// We need to save the interval to a global so we can clear it later.
			JustWritingAutoLoadIntervalID = setInterval( JustWritingAutoLoad, 100 );
			}
			
		// Hide the word count div if we've been asked to.
		if( HideWordCount == 1 )
			{
			JustWritingElementSetDisplay( 'wp-fullscreen-count', 'none' );
			}
			
		// If the user has selected to hide or lighten the border, do so now.
		if( HideBorder > 0 )
			{
			var SubjectBorder = document.getElementById( 'wp-fullscreen-title' );
			var BodyBorder = document.getElementById( 'wp-fullscreen-container' );
			var BorderStyle = 'none';

			if( HideBorder == 1 ) { BorderStyle = '1px dotted #CCCCCC'; }
			
			SubjectBorder.style.border = BorderStyle;
			BodyBorder.style.border = BorderStyle;
			}

		// Hide the editor mode (visual/html) if requested.
		if( HideModeBar == 1 )
			{
			JustWritingElementSetDisplay( 'wp-fullscreen-mode-bar', 'none' );
			}

		// Add the format listbox, if the JavaScript pickers have been disabled, add just a listbox, otherwise add the JavaScript popup.
		if( DisableJSPickers == 1 )
			{
			if( FormatLB == 1 )
				{
				jQuery( '#wp_fs_Paragraph' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFormats id=JustWritingFormats onchange=JustWritingFormatSelectChange()><option>[Style]</option><option>Paragraph</option><option>Address</option><option>Block Quotes</option><option>Preformatted</option><option>Heading 1</option><option>Heading 2</option><option>Heading 3</option><option>Heading 4</option><option>Heading 5</option><option>Heading 6</option></select>" );
				}
			}
		else
			{
			if( FormatLB == 1 )
				{
				FormatButton = document.getElementById( 'wp_fs_Paragraph' );
				
				if( FormatButton != null )
					{
					FormatButton.onclick = JustWritingFormatDropDown;
				
					jQuery( 'body' ).append( '<div role="listbox" id="just_writing_formatselect_menu" class="mceListBoxMenu mceNoIcons wp_themeSkin" style="position: absolute; z-index: 300000; outline-color: currentColor; outline-width: 0px; outline-style: none; display: none; width: 131px; left: 24px; top: 295px;"><div role="presentation" id="just_writing_formatselect_menu_co" class="mceMenu mceListBoxMenu mceNoIcons wp_themeSkin" style="width: 131px;"><span class="mceMenuLine"></span><table role="presentation" id="just_writing_formatselect_menu_tbl" border="0" cellpadding="0" cellspacing="0"><tbody><tr class="mceMenuItem mceMenuItemEnabled mceFirst"><td class="mceMenuItemTitle"><a role="option" href="javascript:;" onclick="return false;"><span class="mceText" title="Format">Format</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_p"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'p\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="true"><span class="mceText" title="Paragraph" style="font-family:Arial;font-weight:400;text-decoration:none;text-transform:none;">Paragraph</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_address"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'address\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Address" style="font-family:Arial;font-weight:400;text-decoration:none;text-transform:none;">Address</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_block"><a  role="option" href="javascript:;" onclick="fullscreen.blockquote(); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="BlockQuote"><blockquote>Block Quote</blockquote></span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_pre"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'pre\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Preformatted" style="font-family:Courier;font-weight:400;text-decoration:none;text-transform:none;">Preformatted</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_h1"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h1\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 1" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 1</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_h2"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h2\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 2" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 2</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_h3"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h3\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 3" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 3</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_h4"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h4\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 4" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 4</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled"><td class="mce_formatPreview mce_h5"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h5\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 5" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 5</span></a></td> </tr><tr class="mceMenuItem mceMenuItemEnabled mceLast"><td class="mce_formatPreview mce_h6"><a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FormatBlock\', false, \'h6\' ); document.getElementById(\'just_writing_formatselect_menu\').style.display=\'none\';" aria-disabled="false" aria-pressed="false" aria-checked="false"><span class="mceText" title="Heading 6" style="font-family:&quot;Times New Roman&quot;;font-weight:700;text-decoration:none;text-transform:none;">Heading 6</span></a></td> </tr></tbody></table></div></div>  ' );
					}
				}
			}
			
		// Add the font listbox, if the JavaScript pickers have been disabled, add just a listbox, otherwise add the JavaScript popup.
		if( DisableJSPickers == 1 )
			{
			jQuery( '#wp_fs_fontselector' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFonts id=JustWritingFonts onchange=JustWritingFontSelectChange()><option>[Font]</option><option style='font-size: 125%; font-family: Andale Mono'>Andale Mono</option><option style='font-size: 125%; font-family: Arial'>Arial</option><option style='font-size: 125%; font-family: Arial Black'>Arial Black</option><option style='font-size: 125%; font-family: Book Antiqua'>Book Antiqua</option><option style='font-size: 125%; font-family: Comic Sans MS'>Comic Sans MS</option><option style='font-size: 125%; font-family: Courier New'>Courier New</option><option style='font-size: 125%; font-family: Georgia'>Georgia</option><option style='font-size: 125%; font-family: Helvetica'>Helvetica</option><option style='font-size: 125%; font-family: Imapct'>Impact</option><option style='font-size: 125%;'>Symbol</option><option style='font-size: 125%; font-family: Tahoma'>Tahoma</option><option style='font-size: 125%; font-family: Terminal'>Terminal</option><option style='font-size: 125%; font-family: Times New Roman'>Times New Roman</option><option style='font-size: 125%; font-family: Trebuchet MS'>Trebuchet MS</option><option style='font-size: 125%; font-family: Verdana'>Verdana</option><option style='font-size: 125%;'>Webdings</option><option style='font-size: 125%;'>Wingdings</option></select>" );
			}
		else
			{
			FontButton = document.getElementById( 'wp_fs_fontselector' );
			
			if( FontButton != null )
				{
				FontButton.onclick = JustWritingFontDropDown;

				jQuery( 'body' ).append( '<div role="listbox" id="just_writing_fontselect_menu" class="mceListBoxMenu mceNoIcons wp_themeSkin" style="position: absolute; z-index: 300000; outline-color: currentColor; outline-width: 0px; outline-style: none; display: none; width: 128px; left: 24px; top: 302px;"> <div role="presentation" id="just_writing_fontselect_menu_co" class="mceMenu mceListBoxMenu mceNoIcons wp_themeSkin" style="width: 128px;"> <span class="mceMenuLine"></span> <table role="presentation" id="just_writing_fontselect_menu_tbl" border="0" cellpadding="0" cellspacing="0"> <tbody> <tr id="mce_25" class="mceMenuItem mceMenuItemEnabled mceFirst"> <td class="mceMenuItemTitle"> <a id="mce_25_aria" role="option" href="javascript:;" onclick="return false;"> <span class="mceIcon"></span> <span class="mceText" title="Font family">Font family</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Andale Mono\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Andale Mono" style="font-family:andale mono,times">Andale Mono</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Arial\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Arial" style="font-family:arial,helvetica,sans-serif">Arial</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Arial Black\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Arial Black" style="font-family:arial black,avant garde">Arial Black</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Book Antiqua\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Book Antiqua" style="font-family:book antiqua,palatino">Book Antiqua</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Comic Sans MS\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Comic Sans MS" style="font-family:comic sans ms,sans-serif">Comic Sans MS</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Courier New\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Courier New" style="font-family:courier new,courier">Courier New</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Georgia\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Georgia" style="font-family:georgia,palatino">Georgia</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Helvetica\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Helvetica" style="font-family:helvetica">Helvetica</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Impact\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Impact" style="font-family:impact,chicago">Impact</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Symbol\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Symbol" style="font-family:symbol">Symbol</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Tahoma\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Tahoma" style="font-family:tahoma,arial,helvetica,sans-serif">Tahoma</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Terminal\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Terminal" style="font-family:terminal,monaco">Terminal</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Times New Roman\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Times New Roman" style="font-family:times new roman,times">Times New Roman</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Trebuchet MS\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Trebuchet MS" style="font-family:trebuchet ms,geneva">Trebuchet MS</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Verdana\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Verdana" style="font-family:verdana,geneva">Verdana</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Webdings\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Webdings">Webdings</span> </a> </td>  </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontName\', false, \'Wingdings\' ); document.getElementById(\'just_writing_fontselect_menu\').style.display=\'none\';"> <span class="mceIcon"></span> <span class="mceText" title="Wingdings">Wingdings</span> </a> </td>  </tr> </tbody> </table> </div> </div> ' );
				}
			}
		
		// Add the font size listbox, if the JavaScript pickers have been disabled, add just a listbox, otherwise add the JavaScript popup.
		if( DisableJSPickers == 1 )
			{
			jQuery( '#wp_fs_fontsize' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontSize id=JustWritingFontSize onchange=JustWritingFontSizeSelectChange()><option>[Font Size]</option><option style='font-size: 6px'>6</option><option style='font-size: 8px'>8</option><option style='font-size: 10px'>10</option><option style='font-size: 12px'>12</option><option style='font-size: 14px'>14</option><option style='font-size: 16px'>16</option><option style='font-size: 18px'>18</option><option style='font-size: 20px'>20</option><option style='font-size: 22px'>22</option><option style='font-size: 24px'>24</option><option style='font-size: 28px'>28</option><option style='font-size: 32px'>32</option><option style='font-size: 36px'>36</option><option style='font-size: 40px'>40</option><option style='font-size: 44px'>44</option><option style='font-size: 48px'>48</option><option style='font-size: 52px'>52</option><option style='font-size: 62px'>62</option><option style='font-size: 72px'>72</option></select>" );
			}
		else
			{
			FontSizeButton = document.getElementById( 'wp_fs_fontsize' );
			
			if( FontSizeButton != null )
				{
				FontSizeButton.onclick = JustWritingFontSizeDropDown;

				jQuery( 'body' ).append( '<div role="listbox" id="just_writing_fontsizeselect_menu" class="mceListBoxMenu mceNoIcons wp_themeSkin" style="position: absolute; z-index: 300000; outline-color: currentColor; outline-width: 0px; outline-style: none; display: none; height: 450px; width: 220px; left: 24px; top: 272px;"> <div role="presentation" id="just_writing_fontsizeselect_menu_co" class="mceMenu mceListBoxMenu mceNoIcons wp_themeSkin" style="height: 450px; width: 220px;"> <span class="mceMenuLine"></span> <table role="presentation" id="just_writing_fontsizeselect_menu_tbl" border="0" cellpadding="0" cellspacing="0"> <tbody> <tr class="mceMenuItem mceMenuItemEnabled mceFirst"> <td class="mceMenuItemTitle" style="width: 220px"> <a role="option" href="javascript:;" onclick="return false;"> <span class="mceText" title="Font size">Font size</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 6pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'6pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="6pt" style="font-size: 6pt">6pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 8pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'8pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="8pt" style="font-size: 8pt">8pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 10pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'10pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="10pt" style="font-size: 10pt">10pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 12pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'12pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="12pt" style="font-size: 12pt">12pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 14pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'14pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="14pt" style="font-size: 14pt">14pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 16pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'16pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="16pt" style="font-size: 14pt">16pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 18pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'18pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="18pt" style="font-size: 18pt">18pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 20pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'20pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="20pt" style="font-size: 20pt">20pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 22pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'22pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="22pt" style="font-size: 22pt">22pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 24pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'24pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="24pt" style="font-size: 24pt">24pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 28pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'28pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="28pt" style="font-size: 28pt">28pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled" style="height: 32pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'32pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="32pt" style="font-size: 32pt">32pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 36pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'36pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="36pt" style="font-size: 36pt;">36pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 40pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'40pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="40pt" style="font-size: 40pt;">40pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 44pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'44pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="44pt" style="font-size: 44pt;">44pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 48pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'48pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="48pt" style="font-size: 48pt;">48pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 52pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'52pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="52pt" style="font-size: 52pt;">52pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 62pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'62pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="62pt" style="font-size: 62pt;">62pt</span> </a> </td> </tr> <tr class="mceMenuItem mceMenuItemEnabled mceLast" style="height: 72pt"> <td> <a role="option" href="javascript:;" onclick="tinyMCE.execCommand( \'FontSize\', false, \'72pt\' ); document.getElementById(\'just_writing_fontsizeselect_menu\').style.display=\'none\';"> <span class="mceText" title="72pt" style="font-size: 72pt;">72pt</span> </a> </td> </tr> </tbody> </table> </div> </div>' );
				}
			}

		// Add the font color listbox, if the JavaScript pickers have been disabled, add just a listbox, otherwise add the JavaScript popup.
		if( DisableJSPickers == 1 )
			{
			jQuery( '#wp_fs_fontcolor' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontColor id=JustWritingFontColor onchange=JustWritingFontColorSelectChange()><option>[Font Color]</option><option style='font-size: 125%; background-color: #000000; color: white;'>Black</option><option style='font-size: 125%; background-color: #0000FF; color: white;'>Blue</option><option style='font-size: 125%; background-color: #0000A0; color: white;'>Blue (Dark)</option><option style='font-size: 125%; background-color: #ADD8E6; color: white;'>Blue (Light)</option><option style='font-size: 125%; background-color: #A52A2A; color: white;'>Brown</option><option style='font-size: 125%; background-color: #00FFFF; color: white;'>Cyan</option><option style='font-size: 125%; background-color: #008000; color: white;'>Green</option><option style='font-size: 125%; background-color: #808080; color: white;'>Grey</option><option style='font-size: 125%; background-color: #00FF00; color: white;'>Lime</option><option style='font-size: 125%; background-color: #FF00FF; color: white;'>Magenta</option><option style='font-size: 125%; background-color: #800000; color: white;'>Maroon</option><option style='font-size: 125%; background-color: #808000; color: white;'>Olive</option><option style='font-size: 125%; background-color: #FFA500; color: white;'>Orange</option><option style='font-size: 125%; background-color: #800080; color: white;'>Purple</option><option style='font-size: 125%; background-color: #FF0000; color: white;'>Red</option><option style='font-size: 125%; background-color: #C0C0C0; color: white;'>Silver</option><option style='font-size: 125%; background-color: #FFFFFF; color: black;'>White</option><option style='font-size: 125%; background-color: #FFFF00; color: black;'>Yellow</option></select>" );
			}
		else
			{
			FontColorButton = document.getElementById( 'wp_fs_fontcolor' );
			
			if( FontColorButton != null )
				{
				FontColorButton.onclick = JustWritingFontColor;
				
				jQuery( 'body' ).append('<div class=\'JustWritingColorPopup\' id=\'JustWritingFontColorPopup\'><div class="JustWritingColorSwatch" style="background-color: #000000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#000000\')"></div><div class="JustWritingColorSwatch" style="background-color: #0000FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#0000FF\')"></div><div class="JustWritingColorSwatch" style="background-color: #0000A0;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#0000A0\')"></div><div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#ADD8E6\')"></div><div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#A52A2A\')"></div><div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#00FFFF\')"></div><div class="JustWritingColorSwatch" style="background-color: #008000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#008000\')"></div><div class="JustWritingColorSwatch" style="background-color: #808080;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#808080\')"></div><div class="JustWritingColorSwatch" style="background-color: #00FF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#00FF00\')"></div><div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#FF00FF\')"></div><div class="JustWritingColorSwatch" style="background-color: #800000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#800000\')"></div><div class="JustWritingColorSwatch" style="background-color: #808000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#808000\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFA500;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#FFA500\')"></div><div class="JustWritingColorSwatch" style="background-color: #800080;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#800080\')"></div><div class="JustWritingColorSwatch" style="background-color: #FF0000;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#FF0000\')"></div><div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#C0C0C0\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#FFFFFF\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingFontColorSelect(\'#FFFF00\')"></div></div>');
				}
			}

		// Add the background color listbox, if the JavaScript pickers have been disabled, add just a listbox, otherwise add the JavaScript popup.
		if( DisableJSPickers == 1 )
			{
			jQuery( '#wp_fs_backgroundcolor' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingBackgroundColor id=JustWritingBackgroundColor onchange=JustWritingBackgroundColorSelectChange()><option>[BG Color]</option><option style='font-size: 125%; background-color: #000000; color: white;'>Black</option><option style='font-size: 125%; background-color: #0000FF; color: white;'>Blue</option><option style='font-size: 125%; background-color: #0000A0; color: white;'>Blue (Dark)</option><option style='font-size: 125%; background-color: #ADD8E6; color: white;'>Blue (Light)</option><option style='font-size: 125%; background-color: #A52A2A; color: white;'>Brown</option><option style='font-size: 125%; background-color: #00FFFF; color: white;'>Cyan</option><option style='font-size: 125%; background-color: #008000; color: white;'>Green</option><option style='font-size: 125%; background-color: #808080; color: white;'>Grey</option><option style='font-size: 125%; background-color: #00FF00; color: white;'>Lime</option><option style='font-size: 125%; background-color: #FF00FF; color: white;'>Magenta</option><option style='font-size: 125%; background-color: #800000; color: white;'>Maroon</option><option style='font-size: 125%; background-color: #808000; color: white;'>Olive</option><option style='font-size: 125%; background-color: #FFA500; color: white;'>Orange</option><option style='font-size: 125%; background-color: #800080; color: white;'>Purple</option><option style='font-size: 125%; background-color: #FF0000; color: white;'>Red</option><option style='font-size: 125%; background-color: #C0C0C0; color: white;'>Silver</option><option style='font-size: 125%; background-color: #FFFFFF; color: black;'>White</option><option style='font-size: 125%; background-color: #FFFF00; color: black;'>Yellow</option></select>" );
			}
		else
			{
			BGColorButton = document.getElementById( 'wp_fs_backgroundcolor' );
			
			if( BGColorButton != null )
				{
				BGColorButton.onclick = JustWritingBackgroundColor;
				
				jQuery( 'body' ).append('<div class=\'JustWritingColorPopup\' id=\'JustWritingBackgroundColorPopup\'><div class="JustWritingColorSwatch" style="background-color: #000000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#000000\')"></div><div class="JustWritingColorSwatch" style="background-color: #0000FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#0000FF\')"></div><div class="JustWritingColorSwatch" style="background-color: #0000A0;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#0000A0\')"></div><div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#ADD8E6\')"></div><div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#A52A2A\')"></div><div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#00FFFF\')"></div><div class="JustWritingColorSwatch" style="background-color: #008000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#008000\')"></div><div class="JustWritingColorSwatch" style="background-color: #808080;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#808080\')"></div><div class="JustWritingColorSwatch" style="background-color: #00FF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#00FF00\')"></div><div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#FF00FF\')"></div><div class="JustWritingColorSwatch" style="background-color: #800000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#800000\')"></div><div class="JustWritingColorSwatch" style="background-color: #808000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#808000\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFA500;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#FFA500\')"></div><div class="JustWritingColorSwatch" style="background-color: #800080;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#800080\')"></div><div class="JustWritingColorSwatch" style="background-color: #FF0000;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#FF0000\')"></div><div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#C0C0C0\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#FFFFFF\')"></div><div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onmouseover="JustWritingColorHover()" onclick="JustWritingBackgroundColorSelect(\'#FFFF00\')"></div></div>');
				}
			}
		
		// Assume we're running left to right, but if not, handle right to left setups.
		var marginside = 'margin-left';
		if( rtl == 1 )
			{
			marginside = 'margin-right';
			}
		
		// Deal with the Separators
		jQuery( '#wp_fs_JustWritingSeparatorOne' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorTwo' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorThree' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorFour' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorFive' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorSix' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorSeven' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		jQuery( '#wp_fs_JustWritingSeparatorEight' ).removeClass( 'mceButton' ).removeClass( 'mceButtonEnabled' );
		
		// Add exit button
		var preview = jQuery( '#post-preview' );
		var exit = jQuery( '#wp_fs_JustWritingExit' );
		var label = exit.attr( 'title' );
				
		preview.clone()
				.removeAttr( 'id' ).removeClass( 'preview' ).addClass( 'right' )
				.css( marginside, '5px' )
				.css( 'margin-bottom', '8px' )
				.click( function(e) 
					{
					JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
					JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
					JustWritingElementSetDisplay( 'just_writing_formatselect_menu', 'none' );
					JustWritingElementSetDisplay( 'just_writing_fontselect_menu', 'none' );
					JustWritingElementSetDisplay( 'just_writing_fontsizeselect_menu', 'none' );
					
					fullscreen.off(); 
					return false; 
					} )
				.html( label )
				.insertBefore( '#wp-fullscreen-save input.button-primary' );

		// Hide the temporary button we added to get the property exit text.	
		exit.hide();

		// Add preview button
		if( HidePreview == 0 )
			{
			preview.clone()
					.removeAttr( 'id' ).removeClass( 'preview' ).addClass( 'right' )
					.css( marginside, '5px' )
					.click( function( e ) 
						{
						$preview.click();
						e.preventDefault();
						} )
					.insertBefore( '#wp-fullscreen-save input.button-primary' );
			}	

		if( CenterToolbar == 1)
			{
			// Add a spacer to center the toolbar, we have to do this in two stages.
			// First create a hook for the Full Screen button (which isn't created until 
			// later, hence the setInterval to check every .5 second) and then create
			// a second setInterval once that is complete so we can calculate the size
			// of the toolbar after it has become visible.
			//
			// We have to store the setInterval value in a global so we can clear it later.
			JustWritingToolbarCenterID = setInterval( JustWritingToolbarCenter, 500 );
			}
		}
	}

/*
	This function will hide an element if it exists.  
	
	PopupID = ID of the html element.
*/
function JustWritingElementSetDisplay( PopupID, DisplayMode )
	{
	Popup = document.getElementById( PopupID );
	if( Popup != null ) { Popup.style.display = DisplayMode; }
	}
	
/*
	This function hides the JavaScript popups when a user clicks outside of the popup.
	
	PopupID = html ID of the popup to track.
	ButtonID = html ID of the button used to active the popup.
*/
function JustWritingPopupClickHandler( PopupID, ButtonID )
	{
	var Popup = document.getElementById( PopupID );

	// We should be visible, but double check to make sure.
	if( Popup.style.display != 'none' )
		{
		var Button = document.getElementById( ButtonID );

		// This is the position of the mouse click.
		posx = window.event.clientX;
        posy = window.event.clientY;
		
		// First check to see if we're outside of the popup on the x axis.
		if( posx < Popup.offsetLeft || posx > Popup.offsetLeft + Popup.offsetWidth )
			{
			// Then make sure we're also outside of the button used to active the popup.
			if( posx < Button.offsetLeft || posx > Button.offsetLeft + Button.offsetWidth )
				{
				// If both are true, hide the popup.
				Popup.style.display = 'none';
				
				// Unbind ourselves from the tracking the clicks as we're done now.
				jQuery( 'body' ).unbind( 'click' );
				
				return;
				}
			}
			
		// First check to see if we're outside of the popup on the y axis.
		if( posy < Popup.offsetTop || posy > Popup.offset.top + Popup.offsetHeight )
			{
			// Then make sure we're also outside of the button used to active the popup.
			if( posy < Button.offsetTop || posy > Button.offsetTop + Button.offsetHeight )
				{
				// If both are true, hide the popup.
				Popup.style.display = 'none';

				// Unbind ourselves from the tracking the clicks as we're done now.
				jQuery( 'body' ).unbind( 'click' );
				
				return;
				}
			}
		}
	}
	
/*
	This function displays or hides the JavaScript format listbox when the button is pressed.
*/
function JustWritingFormatDropDown()
	{
	var Button = document.getElementById( 'wp_fs_Paragraph' );
	var Popup = document.getElementById( 'just_writing_formatselect_menu' );

	// Set the location of the popup so it's bellow the button.
	Popup.style.top = ( Button.offsetTop + Button.offsetHeight ) + "px";
	Popup.style.left = Button.offsetLeft + "px";

	// Hide the other popups if they're visible.
	JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
	JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontsizeselect_menu', 'none' );

	// Setup the click handler so that if the user click's outside of the popup it will be closed.
	jQuery( 'body' ).on( 'click', function () { JustWritingPopupClickHandler( 'just_writing_formatselect_menu', 'wp_fs_Paragraph' ); } );
	
	// Show/hide the popup
	jQuery('#just_writing_formatselect_menu').toggle();
	}

/*
	This function displays or hides the JavaScript font listbox when the button is pressed.
*/
function JustWritingFontDropDown()
	{
	var Button = document.getElementById( 'wp_fs_fontselector' );
	var Popup = document.getElementById( 'just_writing_fontselect_menu' );
	
	// Set the location of the popup so it's bellow the button.
	Popup.style.top = ( Button.offsetTop + Button.offsetHeight ) + "px";
	Popup.style.left = Button.offsetLeft + "px";

	// Hide the other popups if they're visible.
	JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
	JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
	JustWritingElementSetDisplay( 'just_writing_formatselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontsizeselect_menu', 'none' );

	// Setup the click handler so that if the user click's outside of the popup it will be closed.
	jQuery( 'body' ).on( 'click', function () { JustWritingPopupClickHandler( 'just_writing_fontselect_menu', 'wp_fs_fontselector' ); } );

	// Show/hide the popup
	jQuery('#just_writing_fontselect_menu').toggle();
	}
	
/*
	This function displays or hides the JavaScript font listbox when the button is pressed.
*/
function JustWritingFontSizeDropDown()
	{
	var Button = document.getElementById( 'wp_fs_fontsize' );
	var Popup = document.getElementById( 'just_writing_fontsizeselect_menu' );
	
	// Set the location of the popup so it's bellow the button.
	Popup.style.top = ( Button.offsetTop + Button.offsetHeight ) + "px";
	Popup.style.left = Button.offsetLeft + "px";

	// Hide the other popups if they're visible.
	JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
	JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
	JustWritingElementSetDisplay( 'just_writing_formatselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontselect_menu', 'none' );

	// Setup the click handler so that if the user click's outside of the popup it will be closed.
	jQuery( 'body' ).on( 'click', function () { JustWritingPopupClickHandler( 'just_writing_fontsizeselect_menu', 'wp_fs_fontsize' ); } );

	// Show/hide the popup
	jQuery('#just_writing_fontsizeselect_menu').toggle();
	}
	
/*
	This function displays or hides the JavaScript font color listbox when the button is pressed.
*/
function JustWritingFontColor()
	{
	var Button = document.getElementById( 'wp_fs_fontcolor' );
	var Popup = document.getElementById( 'JustWritingFontColorPopup' );
	
	// Set the location of the popup so it's bellow the button.
	Popup.style.top = ( Button.offsetTop + Button.offsetHeight ) + "px";
	Popup.style.left = Button.offsetLeft + "px";

	// Hide the other popups if they're visible.
	JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
	JustWritingElementSetDisplay( 'just_writing_formatselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontsizeselect_menu', 'none' );
	
	// Setup the click handler so that if the user click's outside of the popup it will be closed.
	jQuery( 'body' ).on( 'click', function () { JustWritingPopupClickHandler( 'JustWritingFontColorPopup', 'wp_fs_fontcolor' ); } );

	// Show/hide the popup
	jQuery('#JustWritingFontColorPopup').toggle();
	}

/*
	This function displays or hides the JavaScript background color listbox when the button is pressed.
*/
function JustWritingBackgroundColor()
	{
	var Button = document.getElementById( 'wp_fs_backgroundcolor' );
	var Popup = document.getElementById( 'JustWritingBackgroundColorPopup' );
	
	// Set the location of the popup so it's bellow the button.
	Popup.style.top = ( Button.offsetTop + Button.offsetHeight ) + "px";
	Popup.style.left = Button.offsetLeft + "px";

	// Hide the other popups if they're visible.
	JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
	JustWritingElementSetDisplay( 'just_writing_formatselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontselect_menu', 'none' );
	JustWritingElementSetDisplay( 'just_writing_fontsizeselect_menu', 'none' );
	
	// Setup the click handler so that if the user click's outside of the popup it will be closed.
	jQuery( 'body' ).on( 'click', function () { JustWritingPopupClickHandler( 'JustWritingBackgroundColorPopup', 'wp_fs_backgroundcolor' ); } );

	// Show/hide the popup
	jQuery('#JustWritingBackgroundColorPopup').toggle();
	}
	
/*
	This function sets the selected color when clicked in the popup.
	
	color = HTML color value.
*/
function JustWritingFontColorSelect( color )
	{
	// Move to the saved bookmark in TinyMCE (fixes an issue with IE losing focus on TinyMCE when the popup is clicked).
	tinyMCE.activeEditor.selection.moveToBookmark( JustWritingTinyMCECurrentSelection );

	// Set the font color.
	tinyMCE.execCommand( 'ForeColor', false, color );
	
	// Close the popup.
	JustWritingElementSetDisplay( 'JustWritingFontColorPopup', 'none' );
	}

/*
	This function sets the selected color when clicked in the popup.
	
	color = HTML color value.
*/
function JustWritingBackgroundColorSelect( color )
	{
	// Move to the saved bookmark in TinyMCE (fixes an issue with IE losing focus on TinyMCE when the popup is clicked).
	tinyMCE.activeEditor.selection.moveToBookmark( JustWritingTinyMCECurrentSelection );

	// Set the background color.
	tinyMCE.execCommand( 'hiliteColor', false, color );

	// Close the popup.
	JustWritingElementSetDisplay( 'JustWritingBackgroundColorPopup', 'none' );
	}

/*
	This function stores the current position in TinyMCE when the user hovers over a color swatch on the popup.
	
	This is to get around an issue in IE when a user clicks outside of TinyMCE it will lose the current select.
	
	color = HTML color value.
*/
function JustWritingColorHover()
	{
	JustWritingTinyMCECurrentSelection = tinyMCE.activeEditor.selection.getBookmark();
	}
	
/*
	This function is called at the end of the initial Just Writing setup every half second until the Full Screen button in TinyMCE has been created.
	
	Once the button is available it will hook another function to be called when the user activates full screen mode.
*/
function JustWritingToolbarCenter()
	{
	var FSButton = document.getElementById( 'content_wp_fullscreen' );

	if( FSButton != null ) 
		{
		// Store the old function called so we can chain it.
		var oldclick = FSButton.onclick;

		// Add our function to the onclick call, it will watch of the full screen load to complete by checking every 100ms.
		// Also chain on the old onclick function.
		FSButton.onclick = function() { JustWritingToolbarCenterID = setInterval( JustWritingToolbarCenterMove, 100 ); oldclick; };
		
		// Since we've done what we needed to, stop calling this function.
		clearInterval( JustWritingToolbarCenterID );
		
		// Flush the global.
		JustWritingToolbarCenterID = null;
		}
	}

/*
	This function is called when we need to resize the toolbar, like when the window size changes.
*/
function JustWritingToolBarResize()
	{
	var ModeBarWidth = document.getElementById( 'wp-fullscreen-mode-bar' ).clientWidth;
	var ButtonBarWidth = document.getElementById( 'wp-fullscreen-button-bar' ).clientWidth;
	var WindowSize = document.body.clientWidth;
	var SaveSize = document.getElementById( 'wp-fullscreen-save' ).clientWidth;
	
	// Note the clientWidth is set to 0 if the div is not visible to the user so we don't have to worry about checking to see if the mode bar has been hidden.
	var BarsWidth = ModeBarWidth + ButtonBarWidth;
	
	// Note: the 'extra' 10px in this calculation is for the padding in the parent div 
	var IdealBorder = Math.floor( ( WindowSize / 2 ) - ( BarsWidth / 2 ) - 10 );
	
	// Note: the 'extra' 20px in this calculation is for the padding in the parent div 
	var Remainder = WindowSize - ( BarsWidth + IdealBorder ) - SaveSize - 20;

	// If the IdealBorder is 0 or less OR there's no space left with in the window, reset the IdealBorder back to 0 and let the browser wrap the toolbar
	if( IdealBorder < 1 || Remainder < 0 ) { IdealBorder = 0; }
	
	document.getElementById( 'wp-fullscreen-mode-bar' ).style.marginLeft = IdealBorder + "px";
	}
	
/*
	This function is called every 100ms when the full screen mode is activated until the toolbar has been created.
*/
function JustWritingToolbarCenterMove()
	{
	var ButtonBarWidth = document.getElementById( 'wp-fullscreen-button-bar' ).clientWidth;
	
	// If the toolbar isn't on screen yet, keep trying
	if( ButtonBarWidth != 0 ) 
		{
		// Setup the proper toolbar size for the first time.
		JustWritingToolBarResize();
		
		// Since we're done what we need to do, stop calling ourselves every 100ms
		clearInterval( JustWritingToolbarCenterID );
		
		// Flush out the global.
		JustWritingToolbarCenterID = null;
		
		// Setup an event listener on the window so that if the user resizes their browser, we'll recenter the toolbar.
		window.addEventListener ? window.addEventListener( "resize", JustWritingOnResizeDocument, false ) : window.attachEvent && window.attachEvent( "onresize", JustWritingOnResizeDocument );
		}
	}

/*
	This function is called every time the user resizes the browser window in DFWM and they've selected to center the toolbar.
*/
function JustWritingOnResizeDocument()
	{
	// Recenter the toolbar for the new window size.
	JustWritingToolBarResize();
	}
	
/*
	This function is called every time the user selects a new format in the non-JavaScript listbox.
*/
function JustWritingFormatSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingFormats' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'FormatBlock', false, 'p' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'FormatBlock', false, 'address' ); }
	if( index == 3 ) { fullscreen.blockquote(); }
	if( index == 4 ) { tinyMCE.execCommand( 'FormatBlock', false, 'pre' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h1' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h2' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h3' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h4' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h5' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'FormatBlock', false, 'h6' ); }

	// reset the listbox select back to the generic item as we don't track the current format of the selected text.
	Listbox.selectedIndex = 0;	
	}

/*
	This function is called every time the user selects a new font in the non-JavaScript listbox.
*/
function JustWritingFontSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingFonts' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'FontName', false, 'Andale Mono' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'FontName', false, 'Arial' ); }
	if( index == 3 ) { tinyMCE.execCommand( 'FontName', false, 'Arial Black' ); }
	if( index == 4 ) { tinyMCE.execCommand( 'FontName', false, 'Book Antiqua' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'FontName', false, 'Comic Sans MS' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'FontName', false, 'Courier New' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'FontName', false, 'Georgia' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'FontName', false, 'Helvetica' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'FontName', false, 'Impact' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'FontName', false, 'Symbol' ); }
	if( index == 11 ) { tinyMCE.execCommand( 'FontName', false, 'Tahoma' ); }
	if( index == 12 ) { tinyMCE.execCommand( 'FontName', false, 'Terminal' ); }
	if( index == 13 ) { tinyMCE.execCommand( 'FontName', false, 'Times New Roman' ); }
	if( index == 14 ) { tinyMCE.execCommand( 'FontName', false, 'Trebuchet MS' ); }
	if( index == 15 ) { tinyMCE.execCommand( 'FontName', false, 'Verdana' ); }
	if( index == 16 ) { tinyMCE.execCommand( 'FontName', false, 'Webdings' ); }
	if( index == 17 ) { tinyMCE.execCommand( 'FontName', false, 'Wingdings' ); }
	
	// reset the listbox select back to the generic item as we don't track the current format of the selected text.
	Listbox.selectedIndex = 0;	
	}

/*
	This function is called every time the user selects a new font size in the non-JavaScript listbox.
*/
function JustWritingFontSizeSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingFontSize' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'FontSize', false, '6pt' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'FontSize', false, '8pt' ); }
	if( index == 3 ) { tinyMCE.execCommand( 'FontSize', false, '10pt' ); }
	if( index == 4 ) { tinyMCE.execCommand( 'FontSize', false, '12pt' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'FontSize', false, '14pt' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'FontSize', false, '16pt' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'FontSize', false, '18pt' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'FontSize', false, '20pt' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'FontSize', false, '22pt' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'FontSize', false, '24pt' ); }
	if( index == 11 ) { tinyMCE.execCommand( 'FontSize', false, '28pt' ); }
	if( index == 12 ) { tinyMCE.execCommand( 'FontSize', false, '32pt' ); }
	if( index == 13 ) { tinyMCE.execCommand( 'FontSize', false, '36pt' ); }
	if( index == 14 ) { tinyMCE.execCommand( 'FontSize', false, '40pt' ); }
	if( index == 15 ) { tinyMCE.execCommand( 'FontSize', false, '44pt' ); }
	if( index == 16 ) { tinyMCE.execCommand( 'FontSize', false, '48pt' ); }
	if( index == 17 ) { tinyMCE.execCommand( 'FontSize', false, '52pt' ); }
	if( index == 18 ) { tinyMCE.execCommand( 'FontSize', false, '62pt' ); }
	if( index == 19 ) { tinyMCE.execCommand( 'FontSize', false, '72pt' ); }

	// reset the listbox select back to the generic item as we don't track the current format of the selected text.
	Listbox.selectedIndex = 0;	
	}

/*
	This function is called every time the user selects a new font color in the non-JavaScript listbox.
*/
function JustWritingFontColorSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingFontColor' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'ForeColor', false, '#000000' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'ForeColor', false, '#0000FF' ); }
	if( index == 3 ) { tinyMCE.execCommand( 'ForeColor', false, '#0000A0' ); }
	if( index == 4 ) { tinyMCE.execCommand( 'ForeColor', false, '#ADD8E6' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'ForeColor', false, '#A52A2A' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'ForeColor', false, '#00FFFF' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'ForeColor', false, '#008000' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'ForeColor', false, '#808080' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'ForeColor', false, '#00FF00' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'ForeColor', false, '#FF00FF' ); }
	if( index == 11 ) { tinyMCE.execCommand( 'ForeColor', false, '#800000' ); }
	if( index == 12 ) { tinyMCE.execCommand( 'ForeColor', false, '#808000' ); }
	if( index == 13 ) { tinyMCE.execCommand( 'ForeColor', false, '#FFA500' ); }
	if( index == 14 ) { tinyMCE.execCommand( 'ForeColor', false, '#800080' ); }
	if( index == 15 ) { tinyMCE.execCommand( 'ForeColor', false, '#FF0000' ); }
	if( index == 16 ) { tinyMCE.execCommand( 'ForeColor', false, '#C0C0C0' ); }
	if( index == 17 ) { tinyMCE.execCommand( 'ForeColor', false, '#FFFFFF' ); }
	if( index == 18 ) { tinyMCE.execCommand( 'ForeColor', false, '#FFFF00' ); }

	// reset the listbox select back to the generic item as we don't track the current format of the selected text.
	Listbox.selectedIndex = 0;	
	}

/*
	This function is called every time the user selects a new background color in the non-JavaScript listbox.
*/
function JustWritingBackgroundColorSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingBackgroundColor' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'hiliteColor', false, '#000000' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'hiliteColor', false, '#0000FF' ); }
	if( index == 3 ) { tinyMCE.execCommand( 'hiliteColor', false, '#0000A0' ); }
	if( index == 4 ) { tinyMCE.execCommand( 'hiliteColor', false, '#ADD8E6' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'hiliteColor', false, '#A52A2A' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'hiliteColor', false, '#00FFFF' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'hiliteColor', false, '#008000' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'hiliteColor', false, '#808080' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'hiliteColor', false, '#00FF00' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'hiliteColor', false, '#FF00FF' ); }
	if( index == 11 ) { tinyMCE.execCommand( 'hiliteColor', false, '#800000' ); }
	if( index == 12 ) { tinyMCE.execCommand( 'hiliteColor', false, '#808000' ); }
	if( index == 13 ) { tinyMCE.execCommand( 'hiliteColor', false, '#FFA500' ); }
	if( index == 14 ) { tinyMCE.execCommand( 'hiliteColor', false, '#800080' ); }
	if( index == 15 ) { tinyMCE.execCommand( 'hiliteColor', false, '#FF0000' ); }
	if( index == 16 ) { tinyMCE.execCommand( 'hiliteColor', false, '#C0C0C0' ); }
	if( index == 17 ) { tinyMCE.execCommand( 'hiliteColor', false, '#FFFFFF' ); }
	if( index == 18 ) { tinyMCE.execCommand( 'hiliteColor', false, '#FFFF00' ); }

	// reset the listbox select back to the generic item as we don't track the current format of the selected text.
	Listbox.selectedIndex = 0;	
	}

/*
	This function is called every 1.5 seconds to fake a mouse move if the user has selected to disable the toolbar fade.
	
	1.5 seconds is used as WordPress waits 3 seconds from the last mouse move before executing the toolbar fade.
*/
function JustWritingMoveMouse()
	{
	jQuery( document ).trigger( 'mousemove' );
	}

/*
	This function is called every 5 second during the initial page load if we're autoloading DFWM.
*/
function JustWritingAutoLoad()
	{
	var UpdateBanner = document.getElementById( 'message' );

	// If the user has just clicked update/publish/save/etc then autoload should not happen as it's not the first time the user has come to this page.
	if( UpdateBanner != null )
		{
		if( UpdateBanner.hidden == false ) 
			{ 
			// Since we're finished, clear our interval.
			clearInterval( JustWritingAutoLoadIntervalID );
			return;
			}
		}
		
	var FSButton = document.getElementById( 'content_wp_fullscreen' );

	// Make sure we don't conflict with the toolbar centering code
	if( FSButton != null && JustWritingToolbarCenterID == null ) 
		{ 
		// click the full screen button to load DFWM.
		FSButton.click(); 

		// Since we're finished, clear our interval.
		clearInterval( JustWritingAutoLoadIntervalID );
		}
	}

// Use an event listener to add the Just Writing function on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener( "load", JustWriting, false ) : window.attachEvent && window.attachEvent( "onload", JustWriting );