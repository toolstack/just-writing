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

		// Add exit button
		(	function($) 
				{
				var $preview = $('#post-preview');

				$preview.clone()
					.removeAttr('id').removeClass('preview').addClass('right')
					.css('margin-left', '5px')
					.css('margin-bottom', '8px')
					.click(function(e) 
						{ 
						fullscreen.off(); 
						return false; 
						})
					.html('Exit')
					.insertBefore('#wp-fullscreen-save input.button-primary');
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
						.css('margin-left', '5px')
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
		var FSButton = document.getElementById('content_wp_fullscreen');
		if( FSButton != null ) 
			{ 
			FSButton.click(); 
			clearInterval(JustWritingAutoLoadIntervalID);
			}
}

// Use an event listener to add the Just Writing function on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener("load",JustWriting,false) : window.attachEvent && window.attachEvent("onload",JustWriting);
