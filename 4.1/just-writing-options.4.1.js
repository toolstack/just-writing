/*
	This function selects all the buttons in the options page.
*/
function JustWritingSelectAll()
{
}

/*
	This function deselects all the buttons in the options page.
*/
function JustWritingDeSelectAll()
{
}

/*
	This function toggles the visibility of the Just Writing advanced options section on the user profile page.
*/
function JustWritingToggleOptionGroups()
	{
	jQuery('[id^="JustWritingOptionGroup"]').toggle();
	}
	
/*
	This function toggles the visibility of the Just Writing advanced buttons section on the user profile page.
*/
function JustWritingToggleButtonGroups()
	{
	jQuery('[id^="JustWritingButtonGroup"]').toggle();
	}
	
/*
	This function shows both the advanced options and buttons  sections when the user clicks custom in the quick settings radio group.
*/
function JustWritingShowAdvancedGroups()
	{
	jQuery('[id^="JustWritingOptionGroup"]').show();
	jQuery('[id^="JustWritingButtonGroup"]').show();
	}

/*
	This function hides both the advanced options and buttons  sections when the user clicks anything other than custom in the quick settings radio group.
*/
function JustWritingHideAdvancedGroups()
	{
	jQuery('[id^="JustWritingOptionGroup"]').hide();
	jQuery('[id^="JustWritingButtonGroup"]').hide();
	}
	
/*
	This function sets the options for each type of quick setting.
*/
function JustWritingSetQuickOptions( optiontype )
	{
	if( optiontype == 'minimal' )
		{
		}
	else if( optiontype == 'wpdefault' )
		{
		}
	
	if( optiontype == 'custom' )
		{
		JustWritingShowAdvancedGroups();
		}
	else
		{
		JustWritingHideAdvancedGroups();
		}
	}