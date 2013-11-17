var JustWritingAutoLoadIntervalID = null;
var JustWritingToolbarCenterID = null;

function GetScriptIndex( name )
	{
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

function GetScriptVariable( index, name, vardef )
	{
	// If a negitive index has been passed in it's because we didn't find any matching script with a query
	// string, so just return the default value.
	if( index < 0 )
		{
		return vardef;
		}

	// Make a temporary copy of the URI and find out where the query string starts.
	var tmp_src = String( document.scripts[index].src );
	var qs_index = tmp_src.indexOf( '?' );

	// Split the query string ino var/value pairs.  ie: 'var1=value1', 'var2=value2', ...
	var params_raw = tmp_src.substr( qs_index + 1 ).split( '&' );

	// Now look for the one we want.
	for( j = 0; j < params_raw.length; j++ )
		{
		// Split names from the values.
		var pp_raw = params_raw[j].split( '=' );

		// If this is the one we're looking for, simply return it.
		if( pp_raw[0] == name )
			{
			// Check to make sure a value was actualy passed in, otherwise we should return the default later on.
			if( typeof( pp_raw[1] ) != 'undefined' )
				{
				return pp_raw[1];
				}
			}
		}

	// If we fell through the loop and didn't find ANY matching variable, simply return the default value.
	return vardef;
	}

function JustWriting()
	{
	// Find the TopBar <div> in the current page.
	var TopBar = document.getElementById( 'fullscreen-topbar' );
	
	// If we didn't find the parent, don't bother doing anything else.
	if( TopBar )
		{
		var ExitBar = document.getElementById( 'wp-fullscreen-close' );
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
		TagLine.innerHTML = 'Just Writing.'

		// Hide the default exit link
		ExitBar.style.display = 'none';

		// Time to get the options the user has selected from the script call
		var GSI = GetScriptIndex( 'just-writing.js' );
		var DisableFade = GetScriptVariable( GSI, 'disablefade', 0 );
		var HideWordCount = GetScriptVariable( GSI, 'hidewordcount', 0 );
		var HidePreview = GetScriptVariable( GSI, 'hidepreview', 0 );
		var HideBorder = GetScriptVariable( GSI, 'hideborder', 0 );
		var HideModeBar = GetScriptVariable( GSI, 'hidemodebar', 0 );
		var AutoLoad = GetScriptVariable( GSI, 'autoload', 0 );
		var FormatLB = GetScriptVariable( GSI, 'formatlistbox', 0 );
		var rtl = GetScriptVariable( GSI, 'rtl', 0 );
		var CenterToolbar = GetScriptVariable( GSI, 'centertb', 0 );
		var DisableJSColorPicker = GetScriptVariable( GSI, 'disablejscp', 0 );

		if( DisableFade == 1 )
			{
			setInterval( JustWritingMoveMouse, 1500 );
			}

		if( AutoLoad == 1 )
			{
			JustWritingAutoLoadIntervalID = setInterval( JustWritingAutoLoad, 100 );
			}
			
		if( HideWordCount == 1 )
			{
			var WordCount = document.getElementById( 'wp-fullscreen-count' );
			
			WordCount.style.display = 'none';
			}
			
		if( HideBorder > 0 )
			{
			var SubjectBorder = document.getElementById( 'wp-fullscreen-title' );
			var BodyBorder = document.getElementById( 'wp-fullscreen-container' );
			var BorderStyle = 'none';
			
			if( HideBorder == 1 ) { BorderStyle = '1px dotted #CCCCCC'; }
			
			SubjectBorder.style.border = BorderStyle;
			BodyBorder.style.border = BorderStyle;
			}
			
		if( HideModeBar == 1 )
			{
			var ModeBar = document.getElementById( 'wp-fullscreen-mode-bar' );
			
			ModeBar.style.display = 'none';
			}

		// Add the format listbox
		if( FormatLB == 1 )
			{
			jQuery( '#wp_fs_Paragraph' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFormats id=JustWritingFormats onchange=JustWritingFormatSelectChange()><option>[Style]</option><option>Paragraph</option><option>Address</option><option>Block Quotes</option><option>Preformatted</option><option>Heading 1</option><option>Heading 2</option><option>Heading 3</option><option>Heading 4</option><option>Heading 5</option><option>Heading 6</option></select>" );
			}
		
		// Add the font listbox
		jQuery( '#wp_fs_fontselect' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFonts id=JustWritingFonts onchange=JustWritingFontSelectChange()><option>[Font]</option><option style='font-size: 125%; font-family: Andale Mono'>Andale Mono</option><option style='font-size: 125%; font-family: Arial'>Arial</option><option style='font-size: 125%; font-family: Arial Black'>Arial Black</option><option style='font-size: 125%; font-family: Book Antiqua'>Book Antiqua</option><option style='font-size: 125%; font-family: Comic Sans MS'>Comic Sans MS</option><option style='font-size: 125%; font-family: Courier New'>Courier New</option><option style='font-size: 125%; font-family: Georgia'>Georgia</option><option style='font-size: 125%; font-family: Helvetica'>Helvetica</option><option style='font-size: 125%; font-family: Imapct'>Impact</option><option style='font-size: 125%;'>Symbol</option><option style='font-size: 125%; font-family: Tahoma'>Tahoma</option><option style='font-size: 125%; font-family: Terminal'>Terminal</option><option style='font-size: 125%; font-family: Times New Roman'>Times New Roman</option><option style='font-size: 125%; font-family: Trebuchet MS'>Trebuchet MS</option><option style='font-size: 125%; font-family: Verdana'>Verdana</option><option style='font-size: 125%;'>Webdings</option><option style='font-size: 125%;'>Wingdings</option></select>" );
		
		// Add the font size listbox
		jQuery( '#wp_fs_fontsize' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontSize id=JustWritingFontSize onchange=JustWritingFontSizeSelectChange()><option>[Font Size]</option><option style='font-size: 6px'>6</option><option style='font-size: 8px'>8</option><option style='font-size: 10px'>10</option><option style='font-size: 12px'>12</option><option style='font-size: 14px'>14</option><option style='font-size: 16px'>16</option><option style='font-size: 18px'>18</option><option style='font-size: 20px'>20</option><option style='font-size: 22px'>22</option><option style='font-size: 24px'>24</option><option style='font-size: 28px'>28</option><option style='font-size: 32px'>32</option><option style='font-size: 36px'>36</option><option style='font-size: 40px'>40</option><option style='font-size: 44px'>44</option><option style='font-size: 48px'>48</option><option style='font-size: 52px'>52</option><option style='font-size: 62px'>62</option><option style='font-size: 72px'>72</option></select>" );

		// Add the font color listbox
		if( DisableJSColorPicker == 1 )
			{
			jQuery( '#wp_fs_fontcolor' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontColor id=JustWritingFontColor onchange=JustWritingFontColorSelectChange()><option>[Font Color]</option><option style='font-size: 125%; background-color: #000000; color: white;'>Black</option><option style='font-size: 125%; background-color: #0000FF; color: white;'>Blue</option><option style='font-size: 125%; background-color: #0000A0; color: white;'>Blue (Dark)</option><option style='font-size: 125%; background-color: #ADD8E6; color: white;'>Blue (Light)</option><option style='font-size: 125%; background-color: #A52A2A; color: white;'>Brown</option><option style='font-size: 125%; background-color: #00FFFF; color: white;'>Cyan</option><option style='font-size: 125%; background-color: #008000; color: white;'>Green</option><option style='font-size: 125%; background-color: #808080; color: white;'>Grey</option><option style='font-size: 125%; background-color: #00FF00; color: white;'>Lime</option><option style='font-size: 125%; background-color: #FF00FF; color: white;'>Magenta</option><option style='font-size: 125%; background-color: #800000; color: white;'>Maroon</option><option style='font-size: 125%; background-color: #808000; color: white;'>Olive</option><option style='font-size: 125%; background-color: #FFA500; color: white;'>Orange</option><option style='font-size: 125%; background-color: #800080; color: white;'>Purple</option><option style='font-size: 125%; background-color: #FF0000; color: white;'>Red</option><option style='font-size: 125%; background-color: #C0C0C0; color: white;'>Silver</option><option style='font-size: 125%; background-color: #FFFFFF; color: black;'>White</option><option style='font-size: 125%; background-color: #FFFF00; color: black;'>Yellow</option></select>" );
			}
		else
			{
			jQuery( 'body' ).append('<div class=\'JustWritingColorPopup\' id=\'JustWritingFontColorPopup\'><div class="JustWritingColorSwatch" style="background-color: #000000;" onclick="JustWritingFontColorSelect(\'#000000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #0000FF;" onclick="JustWritingFontColorSelect(\'#0000FF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #0000A0;" onclick="JustWritingFontColorSelect(\'#0000A0\')"></div> <div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onclick="JustWritingFontColorSelect(\'#ADD8E6\')"></div> <div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onclick="JustWritingFontColorSelect(\'#A52A2A\')"></div> <div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onclick="JustWritingFontColorSelect(\'#00FFFF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #008000;" onclick="JustWritingFontColorSelect(\'#008000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #808080;" onclick="JustWritingFontColorSelect(\'#808080\')"></div> <div class="JustWritingColorSwatch" style="background-color: #00FF00;" onclick="JustWritingFontColorSelect(\'#00FF00\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onclick="JustWritingFontColorSelect(\'#FF00FF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #800000;" onclick="JustWritingFontColorSelect(\'#800000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #808000;" onclick="JustWritingFontColorSelect(\'#808000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFA500;" onclick="JustWritingFontColorSelect(\'#FFA500\')"></div> <div class="JustWritingColorSwatch" style="background-color: #800080;" onclick="JustWritingFontColorSelect(\'#800080\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FF0000;" onclick="JustWritingFontColorSelect(\'#FF0000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onclick="JustWritingFontColorSelect(\'#C0C0C0\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onclick="JustWritingFontColorSelect(\'#FFFFFF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onclick="JustWritingFontColorSelect(\'#FFFF00\')"></div> </div>')
			jQuery( '#wp_fs_fontcolor' ).on( "click", JustWritingFontColor);
			}

		// Add the background color listbox
		if( DisableJSColorPicker == 1 )
			{
			jQuery( '#wp_fs_backgroundcolor' ).replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingBackgroundColor id=JustWritingBackgroundColor onchange=JustWritingBackgroundColorSelectChange()><option>[BG Color]</option><option style='font-size: 125%; background-color: #000000; color: white;'>Black</option><option style='font-size: 125%; background-color: #0000FF; color: white;'>Blue</option><option style='font-size: 125%; background-color: #0000A0; color: white;'>Blue (Dark)</option><option style='font-size: 125%; background-color: #ADD8E6; color: white;'>Blue (Light)</option><option style='font-size: 125%; background-color: #A52A2A; color: white;'>Brown</option><option style='font-size: 125%; background-color: #00FFFF; color: white;'>Cyan</option><option style='font-size: 125%; background-color: #008000; color: white;'>Green</option><option style='font-size: 125%; background-color: #808080; color: white;'>Grey</option><option style='font-size: 125%; background-color: #00FF00; color: white;'>Lime</option><option style='font-size: 125%; background-color: #FF00FF; color: white;'>Magenta</option><option style='font-size: 125%; background-color: #800000; color: white;'>Maroon</option><option style='font-size: 125%; background-color: #808000; color: white;'>Olive</option><option style='font-size: 125%; background-color: #FFA500; color: white;'>Orange</option><option style='font-size: 125%; background-color: #800080; color: white;'>Purple</option><option style='font-size: 125%; background-color: #FF0000; color: white;'>Red</option><option style='font-size: 125%; background-color: #C0C0C0; color: white;'>Silver</option><option style='font-size: 125%; background-color: #FFFFFF; color: black;'>White</option><option style='font-size: 125%; background-color: #FFFF00; color: black;'>Yellow</option></select>" );
			}
		else
			{
			jQuery( 'body' ).append('<div class=\'JustWritingColorPopup\' id=\'JustWritingBackgroundColorPopup\'><div class="JustWritingColorSwatch" style="background-color: #000000;" onclick="JustWritingBackgroundColorSelect(\'#000000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #0000FF;" onclick="JustWritingBackgroundColorSelect(\'#0000FF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #0000A0;" onclick="JustWritingBackgroundColorSelect(\'#0000A0\')"></div> <div class="JustWritingColorSwatch" style="background-color: #ADD8E6;" onclick="JustWritingBackgroundColorSelect(\'#ADD8E6\')"></div> <div class="JustWritingColorSwatch" style="background-color: #A52A2A;" onclick="JustWritingBackgroundColorSelect(\'#A52A2A\')"></div> <div class="JustWritingColorSwatch" style="background-color: #00FFFF;" onclick="JustWritingBackgroundColorSelect(\'#00FFFF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #008000;" onclick="JustWritingBackgroundColorSelect(\'#008000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #808080;" onclick="JustWritingBackgroundColorSelect(\'#808080\')"></div> <div class="JustWritingColorSwatch" style="background-color: #00FF00;" onclick="JustWritingBackgroundColorSelect(\'#00FF00\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FF00FF;" onclick="JustWritingBackgroundColorSelect(\'#FF00FF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #800000;" onclick="JustWritingBackgroundColorSelect(\'#800000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #808000;" onclick="JustWritingBackgroundColorSelect(\'#808000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFA500;" onclick="JustWritingBackgroundColorSelect(\'#FFA500\')"></div> <div class="JustWritingColorSwatch" style="background-color: #800080;" onclick="JustWritingBackgroundColorSelect(\'#800080\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FF0000;" onclick="JustWritingBackgroundColorSelect(\'#FF0000\')"></div> <div class="JustWritingColorSwatch" style="background-color: #C0C0C0;" onclick="JustWritingBackgroundColorSelect(\'#C0C0C0\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFFFFF;" onclick="JustWritingBackgroundColorSelect(\'#FFFFFF\')"></div> <div class="JustWritingColorSwatch" style="background-color: #FFFF00;" onclick="JustWritingBackgroundColorSelect(\'#FFFF00\')"></div></div>')
			jQuery( '#wp_fs_backgroundcolor' ).on( "click", JustWritingBackgroundColor);
			}
		
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
			JustWritingToolbarCenterID = setInterval( JustWritingToolbarCenter, 500 );
			}
		}
	}

function JustWritingFontColor()
	{
	var FCButton = document.getElementById( 'wp_fs_fontcolor' );
	var FCPopup = document.getElementById( 'JustWritingFontColorPopup' );
	
	FCPopup.style.top = ( FCButton.offsetTop + 23 ) + "px";
	FCPopup.style.left = FCButton.offsetLeft + "px";
		
	jQuery('#JustWritingFontColorPopup').toggle();
	}

function JustWritingBackgroundColor()
	{
	var FCButton = document.getElementById( 'wp_fs_backgroundcolor' );
	var BCPopup = document.getElementById( 'JustWritingBackgroundColorPopup' );
	
	BCPopup.style.top = ( FCButton.offsetTop + 23 ) + "px";
	BCPopup.style.left = FCButton.offsetLeft + "px";
		
	jQuery('#JustWritingBackgroundColorPopup').toggle();
	}
	
function JustWritingFontColorSelect( color )
	{
	tinyMCE.execCommand( 'ForeColor', false, color );
	document.getElementById( 'JustWritingFontColorPopup' ).style.display = 'none';
	}

function JustWritingBackgroundColorSelect( color )
	{
	tinyMCE.execCommand( 'hiliteColor', false, color );
	document.getElementById( 'JustWritingBackgroundColorPopup' ).style.display = 'none';
	}
	
function JustWritingToolbarCenter()
	{
	var FSButton = document.getElementById( 'content_wp_fullscreen' );

	if( FSButton != null ) 
		{ 
		var oldclick = FSButton.onclick;
		
		FSButton.onclick = function() { JustWritingToolbarCenterID = setInterval( JustWritingToolbarCenterMove, 100 ); oldclick; };
		clearInterval( JustWritingToolbarCenterID );
		JustWritingToolbarCenterID = null;
		}
	}

function JustWritingToolBarResize()
	{
	var ModeBarWidth = document.getElementById( 'wp-fullscreen-mode-bar' ).clientWidth;
	var ButtonBarWidth = document.getElementById( 'wp-fullscreen-button-bar' ).clientWidth;
	var WindowSize = document.body.clientWidth;
	var SaveSize = document.getElementById( 'wp-fullscreen-save' ).clientWidth;
	
	var BarsWidth = ModeBarWidth + ButtonBarWidth;
	// Note: the 'extra' 10px in this calculation is for the padding in the parent div 
	var IdealBorder = Math.floor( ( WindowSize / 2 ) - ( BarsWidth / 2 ) - 10 );
	
	// Note: the 'extra' 20px in this calculation is for the padding in the parent div 
	var Remainder = WindowSize - ( BarsWidth + IdealBorder ) - SaveSize - 20;

	// If the IdealBorder is 0 or less OR there's no space left with in the window, reset the IdealBorder back to 0 and let the browser wrap the toolbar
	if( IdealBorder < 1 || Remainder < 0 ) { IdealBorder = 0; }
	
	document.getElementById( 'wp-fullscreen-mode-bar' ).style.marginLeft = IdealBorder + "px";
	}
	
function JustWritingToolbarCenterMove()
	{
	var ButtonBarWidth = document.getElementById( 'wp-fullscreen-button-bar' ).clientWidth;
	
	if( ButtonBarWidth != 0 ) 
		{
		JustWritingToolBarResize();
		
		clearInterval( JustWritingToolbarCenterID );
		JustWritingToolbarCenterID = null;
		
		window.addEventListener ? window.addEventListener( "resize", JustWritingOnResizeDocument, false ) : window.attachEvent && window.attachEvent( "onresize", JustWritingOnResizeDocument );			
		}
		
	}

function JustWritingOnResizeDocument()
	{
	JustWritingToolBarResize();
	}
	
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
	
	Listbox.selectedIndex = 0;	
	}

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
	
	Listbox.selectedIndex = 0;	
	}

function JustWritingFontSizeSelectChange()
	{
	var Listbox = document.getElementById( 'JustWritingFontSize' );
	var index = Listbox.selectedIndex;
	
	if( index == 1 ) { tinyMCE.execCommand( 'FontSize', false, '6' ); }
	if( index == 2 ) { tinyMCE.execCommand( 'FontSize', false, '8' ); }
	if( index == 3 ) { tinyMCE.execCommand( 'FontSize', false, '10' ); }
	if( index == 4 ) { tinyMCE.execCommand( 'FontSize', false, '12' ); }
	if( index == 5 ) { tinyMCE.execCommand( 'FontSize', false, '14' ); }
	if( index == 6 ) { tinyMCE.execCommand( 'FontSize', false, '16' ); }
	if( index == 7 ) { tinyMCE.execCommand( 'FontSize', false, '18' ); }
	if( index == 8 ) { tinyMCE.execCommand( 'FontSize', false, '20' ); }
	if( index == 9 ) { tinyMCE.execCommand( 'FontSize', false, '22' ); }
	if( index == 10 ) { tinyMCE.execCommand( 'FontSize', false, '24' ); }
	if( index == 11 ) { tinyMCE.execCommand( 'FontSize', false, '28' ); }
	if( index == 12 ) { tinyMCE.execCommand( 'FontSize', false, '32' ); }
	if( index == 13 ) { tinyMCE.execCommand( 'FontSize', false, '36' ); }
	if( index == 14 ) { tinyMCE.execCommand( 'FontSize', false, '40' ); }
	if( index == 15 ) { tinyMCE.execCommand( 'FontSize', false, '44' ); }
	if( index == 16 ) { tinyMCE.execCommand( 'FontSize', false, '48' ); }
	if( index == 17 ) { tinyMCE.execCommand( 'FontSize', false, '52' ); }
	if( index == 18 ) { tinyMCE.execCommand( 'FontSize', false, '62' ); }
	if( index == 19 ) { tinyMCE.execCommand( 'FontSize', false, '72' ); }

	Listbox.selectedIndex = 0;	
	}

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

	Listbox.selectedIndex = 0;	
	}

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

	Listbox.selectedIndex = 0;	
	}

function JustWritingMoveMouse()
	{
	jQuery( document ).trigger( 'mousemove' );
	}

function JustWritingAutoLoad()
	{
	var UpdateBanner = document.getElementById( 'message' );

	if( UpdateBanner != null )
		{
		if( UpdateBanner.hidden == false ) 
			{ 
			clearInterval( JustWritingAutoLoadIntervalID );
			return;
			}
		}
		
	var FSButton = document.getElementById( 'content_wp_fullscreen' );

	// Make sure we don't conflict with the toolbar centering code
	if( FSButton != null && JustWritingToolbarCenterID == null ) 
		{ 
		FSButton.click(); 
		clearInterval( JustWritingAutoLoadIntervalID );
		}
	}

// Use an event listener to add the Just Writing function on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener( "load", JustWriting, false ) : window.attachEvent && window.attachEvent( "onload", JustWriting );