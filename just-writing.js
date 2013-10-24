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
		}
		
		// Add Preview and Exit buttons
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

// Use an event listener to add the calendar on a page load instead of .OnLoad as we might otherwise get overwritten by another plugin.
window.addEventListener ? window.addEventListener("load",JustWriting,false) : window.attachEvent && window.attachEvent("onload",JustWriting);
