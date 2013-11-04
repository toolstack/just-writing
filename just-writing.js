var JustWritingAutoLoadIntervalID;

function GetScriptIndex(name)
{
	// Loop through all the scripts in the current document to find the one we want.
	for( i = 0; i < document.scripts.length; i++) 
		{
		// Make a temporary copy of the URI and find out where the query string starts.
		var tmp_src = String(document.scripts[i].src);
		var qs_index = tmp_src.indexOf('?');

		// Check if the script is the script we are looking for and if it has a QS, if so return the current index.
		if( tmp_src.indexOf(name) >= 0 && qs_index >= 0)
			{
			return i;
			}
		}
		
	return -1;
}

function GetScriptVariable(index, name, vardef)
{
	// If a negitive index has been passed in it's because we didn't find any matching script with a query
	// string, so just return the default value.
	if( index < 0 )
		{
		return vardef;
		}

	// Make a temporary copy of the URI and find out where the query string starts.
	var tmp_src = String(document.scripts[index].src);
	var qs_index = tmp_src.indexOf('?');

	// Split the query string ino var/value pairs.  ie: 'var1=value1', 'var2=value2', ...
	var params_raw = tmp_src.substr(qs_index + 1).split('&');

	// Now look for the one we want.
	for( j = 0; j < params_raw.length; j++)
		{
		// Split names from the values.
		var pp_raw = params_raw[j].split('=');

		// If this is the one we're looking for, simply return it.
		if( pp_raw[0] == name )
			{
			// Check to make sure a value was actualy passed in, otherwise we should return the default later on.
			if( typeof(pp_raw[1]) != 'undefined' )
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
	var TopBar = document.getElementById('fullscreen-topbar');
	
	// If we didn't find the parent, don't bother doing anything else.
	if( TopBar )
		{
		var ExitBar = document.getElementById('wp-fullscreen-close');
		var ToolBar = document.getElementById('wp-fullscreen-toolbar');
		var CentralBar = document.getElementById('wp-fullscreen-central-toolbar');
		var ButtonBar = document.getElementById('wp-fullscreen-button-bar');
		var TagLine = document.getElementById('wp-fullscreen-tagline');

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
		var GSI = GetScriptIndex('just-writing.js');
		var DisableFade = GetScriptVariable(GSI, 'disablefade', 0);
		var HideWordCount = GetScriptVariable(GSI, 'hidewordcount', 0);
		var HidePreview = GetScriptVariable(GSI, 'hidepreview', 0);
		var HideBorder = GetScriptVariable(GSI, 'hideborder', 0);
		var HideModeBar = GetScriptVariable(GSI, 'hidemodebar', 0);
		var AutoLoad = GetScriptVariable(GSI, 'autoload', 0);
		var FormatLB = GetScriptVariable(GSI, 'formatlistbox', 0);
		var rtl = GetScriptVariable(GSI, 'rtl', 0);

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
			var WordCount = document.getElementById('wp-fullscreen-count');
			
			WordCount.style.display = 'none';
			}
			
		if( HideBorder > 0 )
			{
			var SubjectBorder = document.getElementById('wp-fullscreen-title');
			var BodyBorder = document.getElementById('wp-fullscreen-container');
			var BorderStyle = 'none';
			
			if( HideBorder == 1 ) { BorderStyle = '1px dotted #CCCCCC'; }
			
			SubjectBorder.style.border = BorderStyle;
			BodyBorder.style.border = BorderStyle;
			}
			
		if( HideModeBar == 1 )
			{
			var ModeBar = document.getElementById('wp-fullscreen-mode-bar');
			
			ModeBar.style.display = 'none';
			}

		// Add the format listbox
		if( FormatLB == 1 )
			{
			(	function($) 
					{
					$('#wp_fs_Paragraph').replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFormats id=JustWritingFormats onchange=JustWritingFormatSelectChange()><option>Paragraph</option><option>Address</option><option>Block Quotes</option><option>Preformatted</option><option>Heading 1</option><option>Heading 2</option><option>Heading 3</option><option>Heading 4</option><option>Heading 5</option><option>Heading 6</option></select>" );
					}(jQuery)
			);
			}
		
		// Add the font listbox
		(	function($) 
				{
				$('#wp_fs_fontselect').replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFonts id=JustWritingFonts onchange=JustWritingFontSelectChange()><option>Andale Mono</option><option SELECTED>Arial</option><option>Arial Black</option><option>Book Antiqua</option><option>Comic Sans MS</option><option>Courier New</option><option>Georgia</option><option>Helvetica</option><option>Impact</option><option>Symbol</option><option>Tahoma</option><option>Terminal</option><option>Times New Roman</option><option>Trebuchet MS</option><option>Verdana</option><option>Webdings</option><option>Wingdings</option></select>" );
				}(jQuery)
		);
		
		// Add the font size listbox
		(	function($) 
				{
				$('#wp_fs_fontsize').replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontSize id=JustWritingFontSize onchange=JustWritingFontSizeSelectChange()><option>6</option><option>8</option><option>10</option><option>12</option><option>14</option><option>16</option><option>18</option><option>20</option><option>22</option><option>24</option><option>28</option><option>32</option><option>36</option><option>40</option><option>44</option><option>48</option><option>52</option><option>62</option><option>72</option></select>" );
				}(jQuery)
		);

		// Add the font color listbox
		(	function($) 
				{
				$('#wp_fs_fontcolor').replaceWith( "<select style='margin-left: 5px; margin-right: 5px;' name=JustWritingFontColor id=JustWritingFontColor onchange=JustWritingFontColorSelectChange()><option>Black</option><option>Blue</option><option>Blue (Dark)</option><option>Blue (Light)</option><option>Brown</option><option>Cyan</option><option>Green</option><option>Grey</option><option>Lime</option><option>Magenta</option><option>Maroon</option><option>Olive</option><option>Orange</option><option>Purple</option><option>Red</option><option>Silver</option><option>White</option><option>Yellow</option></select>" );
				}(jQuery)
		);

		var marginside = 'margin-left';
		if( rtl == 1 )
			{
			marginside = 'margin-right';
			}
		
		// Deal with the Separators
		(  	function($)
				{
				$('#wp_fs_JustWritingSeparatorOne').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorTwo').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorThree').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorFour').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorFive').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorSix').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorSeven').removeClass('mceButton').removeClass('mceButtonEnabled');
				$('#wp_fs_JustWritingSeparatorEight').removeClass('mceButton').removeClass('mceButtonEnabled');
				}(jQuery)
		);
		
		// Add exit button
		(	function($) 
				{
				var $preview = $('#post-preview');
				var $exit = $('#wp_fs_JustWritingExit');
				var $label = $exit.attr('title');
				
				$preview.clone()
					.removeAttr('id').removeClass('preview').addClass('right')
					.css(marginside, '5px')
					.css('margin-bottom', '8px')
					.click(function(e) 
						{ 
						fullscreen.off(); 
						return false; 
						})
					.html($label)
					.insertBefore('#wp-fullscreen-save input.button-primary');

				// Hide the temporary button we added to get the property exit text.	
				$exit.hide();
				}(jQuery)
		);

		// Add preview button
		if( HidePreview == 0 )
			{
			(	function($) 
					{
					var $preview = $('#post-preview');

					$preview.clone()
						.removeAttr('id').removeClass('preview').addClass('right')
						.css( marginside, '5px')
						.click(function(e) 
							{
							$preview.click();
							e.preventDefault();
							})
						.insertBefore('#wp-fullscreen-save input.button-primary');
					}(jQuery)
			);
			}	

		}
}

function JustWritingFormatSelectChange()
{
	var FormatListbox = document.getElementById('JustWritingFormats');
	var index = FormatListbox.selectedIndex;
	
	if( index == 0 ) { tinyMCE.execCommand('FormatBlock', false, 'p'); }
	if( index == 1 ) { tinyMCE.execCommand('FormatBlock', false, 'address'); }
	if( index == 2 ) { fullscreen.blockquote(); }
	if( index == 3 ) { tinyMCE.execCommand('FormatBlock', false, 'pre'); }
	if( index == 4 ) { tinyMCE.execCommand('FormatBlock', false, 'h1'); }
	if( index == 5 ) { tinyMCE.execCommand('FormatBlock', false, 'h2'); }
	if( index == 6 ) { tinyMCE.execCommand('FormatBlock', false, 'h3'); }
	if( index == 7 ) { tinyMCE.execCommand('FormatBlock', false, 'h4'); }
	if( index == 8 ) { tinyMCE.execCommand('FormatBlock', false, 'h5'); }
	if( index == 9 ) { tinyMCE.execCommand('FormatBlock', false, 'h6'); }
	
}

function JustWritingFontSelectChange()
{
	var FontsListbox = document.getElementById('JustWritingFonts');
	var index = FontsListbox.selectedIndex;
	
	if( index == 0 ) { tinyMCE.execCommand('FontName', false, 'Andale Mono'); }
	if( index == 1 ) { tinyMCE.execCommand('FontName', false, 'Arial'); }
	if( index == 2 ) { tinyMCE.execCommand('FontName', false, 'Arial Black'); }
	if( index == 3 ) { tinyMCE.execCommand('FontName', false, 'Book Antiqua'); }
	if( index == 4 ) { tinyMCE.execCommand('FontName', false, 'Comic Sans MS'); }
	if( index == 5 ) { tinyMCE.execCommand('FontName', false, 'Courier New'); }
	if( index == 6 ) { tinyMCE.execCommand('FontName', false, 'Georgia'); }
	if( index == 7 ) { tinyMCE.execCommand('FontName', false, 'Helvetica'); }
	if( index == 8 ) { tinyMCE.execCommand('FontName', false, 'Impact'); }
	if( index == 9 ) { tinyMCE.execCommand('FontName', false, 'Symbol'); }
	if( index == 10 ) { tinyMCE.execCommand('FontName', false, 'Tahoma'); }
	if( index == 11 ) { tinyMCE.execCommand('FontName', false, 'Terminal'); }
	if( index == 12 ) { tinyMCE.execCommand('FontName', false, 'Times New Roman'); }
	if( index == 13 ) { tinyMCE.execCommand('FontName', false, 'Trebuchet MS'); }
	if( index == 14 ) { tinyMCE.execCommand('FontName', false, 'Verdana'); }
	if( index == 15 ) { tinyMCE.execCommand('FontName', false, 'Webdings'); }
	if( index == 16 ) { tinyMCE.execCommand('FontName', false, 'Wingdings'); }
	
}

function JustWritingFontSizeSelectChange()
{
	var FontSizeListbox = document.getElementById('JustWritingFontSize');
	var index = FontSizeListbox.selectedIndex;
	
	if( index == 0 ) { tinyMCE.execCommand('FontSize', false, '6'); }
	if( index == 1 ) { tinyMCE.execCommand('FontSize', false, '8'); }
	if( index == 2 ) { tinyMCE.execCommand('FontSize', false, '10'); }
	if( index == 3 ) { tinyMCE.execCommand('FontSize', false, '12'); }
	if( index == 4 ) { tinyMCE.execCommand('FontSize', false, '14'); }
	if( index == 5 ) { tinyMCE.execCommand('FontSize', false, '16'); }
	if( index == 6 ) { tinyMCE.execCommand('FontSize', false, '18'); }
	if( index == 7 ) { tinyMCE.execCommand('FontSize', false, '20'); }
	if( index == 8 ) { tinyMCE.execCommand('FontSize', false, '22'); }
	if( index == 9 ) { tinyMCE.execCommand('FontSize', false, '24'); }
	if( index == 10 ) { tinyMCE.execCommand('FontSize', false, '28'); }
	if( index == 11 ) { tinyMCE.execCommand('FontSize', false, '32'); }
	if( index == 12 ) { tinyMCE.execCommand('FontSize', false, '36'); }
	if( index == 13 ) { tinyMCE.execCommand('FontSize', false, '40'); }
	if( index == 14 ) { tinyMCE.execCommand('FontSize', false, '44'); }
	if( index == 15 ) { tinyMCE.execCommand('FontSize', false, '48'); }
	if( index == 16 ) { tinyMCE.execCommand('FontSize', false, '52'); }
	if( index == 17 ) { tinyMCE.execCommand('FontSize', false, '62'); }
	if( index == 18 ) { tinyMCE.execCommand('FontSize', false, '72'); }

}

function JustWritingFontColorSelectChange()
{
	var FontColorListbox = document.getElementById('JustWritingFontColor');
	var index = FontColorListbox.selectedIndex;
	
	if( index == 0 ) { tinyMCE.execCommand('ForeColor', false, '#000000'); }
	if( index == 1 ) { tinyMCE.execCommand('ForeColor', false, '#0000FF'); }
	if( index == 2 ) { tinyMCE.execCommand('ForeColor', false, '#0000A0'); }
	if( index == 3 ) { tinyMCE.execCommand('ForeColor', false, '#ADD8E6'); }
	if( index == 4 ) { tinyMCE.execCommand('ForeColor', false, '#A52A2A'); }
	if( index == 5 ) { tinyMCE.execCommand('ForeColor', false, '#00FFFF'); }
	if( index == 6 ) { tinyMCE.execCommand('ForeColor', false, '#008000'); }
	if( index == 7 ) { tinyMCE.execCommand('ForeColor', false, '#808080'); }
	if( index == 8 ) { tinyMCE.execCommand('ForeColor', false, '#00FF00'); }
	if( index == 9 ) { tinyMCE.execCommand('ForeColor', false, '#FF00FF'); }
	if( index == 10 ) { tinyMCE.execCommand('ForeColor', false, '#800000'); }
	if( index == 11 ) { tinyMCE.execCommand('ForeColor', false, '#808000'); }
	if( index == 12 ) { tinyMCE.execCommand('ForeColor', false, '#FFA500'); }
	if( index == 13 ) { tinyMCE.execCommand('ForeColor', false, '#800080'); }
	if( index == 14 ) { tinyMCE.execCommand('ForeColor', false, '#FF0000'); }
	if( index == 15 ) { tinyMCE.execCommand('ForeColor', false, '#C0C0C0'); }
	if( index == 16 ) { tinyMCE.execCommand('ForeColor', false, '#FFFFFF'); }
	if( index == 17 ) { tinyMCE.execCommand('ForeColor', false, '#FFFF00'); }

}

function JustWritingMoveMouse()
{
		(	function($) 
				{
				$(document).trigger('mousemove');
				}(jQuery)
		);
}

function JustWritingAutoLoad()
{
		var UpdateBanner = document.getElementById('message');

		if( UpdateBanner != null )
			{
			if( UpdateBanner.hidden == false) 
				{ 
				clearInterval(JustWritingAutoLoadIntervalID);
				return;
				}
			}
			
		var FSButton = document.getElementById('content_wp_fullscreen');

		if( FSButton != null ) 
			{ 
			FSButton.click(); 
			clearInterval(JustWritingAutoLoadIntervalID);
			}
}

// Use an event listener to add the Just Writing function on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener("load",JustWriting,false) : window.attachEvent && window.attachEvent("onload",JustWriting);
