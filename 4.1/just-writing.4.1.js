var JustWritingTinyMCECurrentSelection = null;
var JustWritingBrowserFS = 0;

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

		// Hide the default exit link
		JustWritingElementSetDisplay( 'wp-fullscreen-close', 'none' );

		// Time to get the options the user has selected from the script call
		var GSI = GetScriptIndex( 'just-writing.4.1.js' );
		var DisableFade = GetScriptVariable( GSI, 'disablefade', 0 );
		var HideWordCount = GetScriptVariable( GSI, 'hidewordcount', 0 );
		var HidePreview = GetScriptVariable( GSI, 'hidepreview', 0 );
		var HideBorder = GetScriptVariable( GSI, 'hideborder', 0 );
		var HideModeBar = GetScriptVariable( GSI, 'hidemodebar', 0 );
		var FormatLB = GetScriptVariable( GSI, 'formatlistbox', 0 );
		var rtl = GetScriptVariable( GSI, 'rtl', 0 );
		var CenterToolbar = GetScriptVariable( GSI, 'centertb', 0 );
		
		// Set the global for if we should ask the browser for fullscreen mode or not.
		JustWritingBrowserFS = GetScriptVariable( GSI, 'browserfs', 0 );

		document.getElementById( 'title' ).spellcheck = true;
		
		// If the user has selected to keep the toolbar visible at all times, setup a recurring function to fake a mouse move.
		if( DisableFade == 1 )
			{
			setInterval( JustWritingMoveMouse, 1500 );
			}

		// Hide the word count div if we've been asked to.
		if( HideWordCount == 1 )
			{
			JustWritingElementSetDisplay( 'wp-fullscreen-count', 'none' );
			}
			
		// If the user has selected to hide or lighten the border, do so now.
		if( HideBorder > 0 )
			{
			var SubjectBorder = jQuery( '#title' );
			var BodyBorder = jQuery( '#wp-content-editor-container' );
			var BorderStyle = 'none';

			if( HideBorder == 1 ) { BorderStyle = '1px dotted #CCCCCC'; }
			
			SubjectBorder.css( 'border', BorderStyle );
			BodyBorder.css( 'border', BorderStyle );
			}

		// Hide the editor mode (visual/html) if requested.
		if( HideModeBar == 1 )
			{
			JustWritingElementSetDisplay( 'wp-fullscreen-mode-bar', 'none' );
			}

		// Add the format JavaScript popup.
		if( FormatLB == 1 )
			{
			FormatButton = document.getElementById( 'wp_fs_Paragraph' );
			
			if( FormatButton != null )
				{
				FormatButton.onclick = JustWritingFormatDropDown;
				}
			}
			
		// Add the font JavaScript popup.
		FontButton = document.getElementById( 'wp_fs_fontselector' );
		
		if( FontButton != null )
			{
			FontButton.onclick = JustWritingFontDropDown;
			}
		
		// Add the font size JavaScript popup.
		FontSizeButton = document.getElementById( 'wp_fs_fontsize' );
		
		if( FontSizeButton != null )
			{
			FontSizeButton.onclick = JustWritingFontSizeDropDown;
			}

		// Add the font color JavaScript popup.
		FontColorButton = document.getElementById( 'wp_fs_fontcolor' );
		
		if( FontColorButton != null )
			{
			FontColorButton.onclick = JustWritingFontColor;
			}

		// Add the background color JavaScript popup.
		BGColorButton = document.getElementById( 'wp_fs_backgroundcolor' );
		
		if( BGColorButton != null )
			{
			BGColorButton.onclick = JustWritingBackgroundColor;
			}
		
		// Assume we're running left to right, but if not, handle right to left setups.
		var marginside = 'margin-left';
		if( rtl == 1 )
			{
			marginside = 'margin-right';
			}
		
		if( CenterToolbar == 1)
			{
			JustWritingToolbarCenterMove();
			if( JustWritingBrowserFS == 1 ) { jQuery(document.body).fullscreen(); }
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
		var Button = document.getElementById( ButtonID ).parentElement;
		
		// Check to make sure we have a real click event.
		if( typeof window.event == 'undefined' ) { return; }
		
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
	var Button = document.getElementById( 'wp_fs_Paragraph' ).parentElement;
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
	var Button = document.getElementById( 'wp_fs_fontselector' ).parentElement;
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
	var Button = document.getElementById( 'wp_fs_fontsize' ).parentElement;
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
	var Button = document.getElementById( 'wp_fs_fontcolor' ).parentElement;
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
	var Button = document.getElementById( 'wp_fs_backgroundcolor' ).parentElement;
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

	// If the remainder is less than 0 (Remainder can be a negative number) subtract the remainder from the IdealBorder
	if( Remainder < 0 ) { IdealBorder = IdealBorder + Remainder; }

	// If the IdealBorder is 0 or less reset the IdealBorder back to 0 and let the browser wrap the toolbar
	if( IdealBorder < 1 ) { IdealBorder = 0; }
	
	document.getElementById( 'wp-fullscreen-mode-bar' ).style.marginLeft = IdealBorder + "px";
	}
	
/*
	This function is called Just Writing is activated to centre the toolbar.
*/
function JustWritingToolbarCenterMove()
	{
	var ButtonBarWidth = document.getElementById( 'wp-fullscreen-button-bar' ).clientWidth;
	
	// If the toolbar isn't on screen yet, don't do anything
	if( ButtonBarWidth != 0 ) 
		{
		// Setup the proper toolbar size for the first time.
		JustWritingToolBarResize();
		
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
	This function is called every 1.5 seconds to fake a mouse move if the user has selected to disable the toolbar fade.
	
	1.5 seconds is used as WordPress waits 3 seconds from the last mouse move before executing the toolbar fade.
*/
function JustWritingMoveMouse()
	{
	jQuery( '#fullscreen-topbar' ).trigger( 'mouseover' );
	}

/*
	This function saves/updates the post.
*/
function JustWritingAjaxSave()
	{
	var $hidden = jQuery('#hiddenaction'),
		oldVal = $hidden.val(),
		$spinner = jQuery('#wp-fullscreen-save .spinner'),
		$saveMessage = jQuery('#wp-fullscreen-save .wp-fullscreen-saved-message'),
		$errorMessage = jQuery('#wp-fullscreen-save .wp-fullscreen-error-message');

	$spinner.show();
	$errorMessage.hide();
	$saveMessage.hide();

	tinyMCE.triggerSave(true,true);
	
	jQuery.ajax( {
			url: window.ajaxurl,
			type: 'post',
			data: jQuery('form#post').serialize(),
			dataType: 'json'
		}).done( function( response ) {
			$spinner.hide();

			if ( response && response.success ) {
				$saveMessage.show();

				setTimeout( function() {
					$saveMessage.fadeOut(300);
				}, 3000 );

				if ( response.data && response.data.last_edited ) {
					jQuery('#wp-fullscreen-save input').attr( 'title',  response.data.last_edited );
				}
			} else {
				$errorMessage.show();
			}
		}).fail( function() {
			$spinner.hide();
			$errorMessage.show();
		});

	$hidden.val( oldVal );
	};
	
	
// Use an event listener to add the Just Writing function on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener( "load", JustWriting, false ) : window.attachEvent && window.attachEvent( "onload", JustWriting );