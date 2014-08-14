=== Just Writing ===
Contributors: GregRoss
Plugin URI: http://toolstack.com/just-writing
Author URI: http://toolstack.com
Tags: admin posts writing
Requires at least: 3.5.0
Tested up to: 3.9.2
Stable tag: 2.17

Adds buttons and features to the Distraction Free Writing Mode for all kinds of extra functions.

== Description ==

Distraction Free Writing Mode (DFWM) is a great way to focus on writing text, but have you ever found yourself wanting to do a bit more with it?  How about spell check, or change the paragraph style without dropping back to the standard post edit mode?  Now you can get all the functionality of the standard mode tools in DFWM!

But maybe you think there are too many buttons in DFWM, no problem you can get rid of pretty much all of them!

Just Writing takes DFWM from a great way to write to a great way of writing posts!

This plugin adds the following optional commands to the toolbar in DFWM:

	* Address					* Insert More Tag
	* Align Full				* Insert Custom Character
	* Align Left				* Outdent
	* Align Right				* Paragraph
	* Background Color			* Paste
	* Block Quotes				* Paste as Text
	* Copy						* Paste from Word
	* Cut						* Preformatted
	* Font						* Preview
	* Font Color				* Redo
	* Font Size					* Remove Formatting
	* H1						* Spellcheck
	* H2						* Strikethrough
	* H3						* Subscript
	* H4						* Superscript	
	* H5						* Underline
	* H6						* Undo
	* Indent				

And there's more!

	* Option to remove the fade effect and keep the toolbar visible
	* Option to hide or lighten the border on the title/body areas
	* Option to hide the word count
	* Option to hide the editor mode bar
	* Option to center the toolbar on screen
	* Adds an optional Preview button to the right of the Save button
	* Moves the exit link to the right of the new Preview 
	  button as a real button
	* Re-orders the button list to make more sense
	* Per-user preferences for enabling Just Writing
	* Per-user preferences for which buttons to display
	* Option to start in DFWM for new posts
	* Option to start in DFWM when editing posts
	* Option to add a DFWM link to the pages/posts list to go directly to DFWM
	* Adds spell check field to the post title so your browser will spell check it for you

This code is released under the GPL v2, see license.txt for details.

== Installation ==

1. Extract the archive file into your plugins directory in the just-writing folder.
2. Activate the plugin in the Plugin options.
3. Login to WordPress and go to your profile page, update the options at the bottom.

== Frequently Asked Questions ==

= What browsers are supported? =

Try it and find out, the JavaScript is pretty basic so it should work in just about any browser.  I've successfully run it on:

	* IE 11
	* Opera 12.16
	* FireFox 24/25
	* Chrome 31

= I can't find the Just Writing options, where are they? =

For standard users (aka non-admin users), they can go to their WordPress settings page and select "Profile", scroll down to the bottom and your see the Just Writing section.

For admin users it can be found under "Users"->"Your Profile".

= I've disabled the fade effect and now the browser is running slowly, what's wrong? =

The fade effect is triggered by WordPress when no mouse movement is executed for 2 seconds, the only (without changing some of the WordPress sources files at least) way to disable it is to execute a mousemove event every 1.5 seconds.  This shouldn't be an issue in any modern browser, but if your having performance issues, simply re-enable the fade effect.

= I've disabled the fade effect but there is a 'flicker' when DFWM comes up, what's wrong? =

If you start DFWM without moving the mouse you might hit right between when WordPress starts fading but before Just Writing fires off a mousemove event, this shouldn't be an issue after the first start of DFWM.

= I've added the spellcheck button to my toolbar but it doesn't do anything when I click it =

As of WordPress 3.6, the spellchecker is no longer part of the core WordPress install, you need to add a plugin to get the functionality back.  I'd suggest [TinyMCE SpellChecker](http://wordpress.org/plugins/tinymce-spellcheck/) as a good option.

= The "Paste as Word" button doesn't show up in WordPress 3.9, why not? =

WordPress 3.9 removed the "Paste as Word" button as the functionality is built in to TinyMCE now.  Just paste your word content in to the visual editor and the formatting will be maintained.

== Screenshots ==

1. Pre installation DFWM.
2. Post installation DFWM.
3. User preferences screen.
4. Advanced user preferences options.
5. A real DFWM!
6. Administration screen.

== Changelog ==
= 2.17 =
* Added browser based spell check to the post title field, inspired by Post Title Spell Check (https://github.com/FlagshipWP/post-title-spell-check).

= 2.16 =
* Added full justification button.
* Fixed behaviour of center justificaiton button.

= 2.15.4 =
* Fixed javascript popup menus not showing up on posts that were longer then the display size.

= 2.15.3 =
* Fixed insert media button in WP3.9

= 2.15.2 =
* Fixed special characters and paste as text buttons in WP3.9
* Removed paste as word in WP3.9

= 2.15.1 =
* Added link to user profile page in the Just Writing settings page.
* About page cleanup and additional translation strings.
* Fix to remove new 'cover' background-size setting in default icon settings in WP3.9.

= 2.15 =
* Minor WordPress and PHP notices clean up when in debug mode, thanks Dave Warfel.
* Major overhaul of code to support upcoming WordPress 3.9 release with TinyMCE 4.0.  WP3.9 support should be considered beta at this time.
* Fixed a bug where centring the toolbar would fail if there was very little space left between the toolbar and the save/preview/exit buttons.
* Fixed incorrect description of Paste as Word button.

= 2.14.2 =
* Fixed quick settings area being displayed when Just Writing has been disabled.
* Tested with WordPress 3.8.

= 2.14.1 =
* Bug fix for when JavaScript popups were selected but the associated button was not selected to be added to the toolbar.
* Added some descriptive text to the quick settings options.

= 2.14 =
* Added JavaScript Font/Size/Style selectors
* Added "out of bounds" click detection to the JavaScript popups
* Fixed issue with the JavaScript color selector and IE losing the selection when clicking a color.
* Updated the profile page to support "quick" settings.

= 2.13.2 =
* Added permissions check to the uninstall code.

= 2.13.1 =
* Fixed several bugs with the new JavaScript color pickers staying on screen when they shouldn't.

= 2.13 =
* Added JavaScript color pickers for font color and background color.
* Added option to disable JavaScript color pickers (they may not work in some browsers).
* Collapsed the user options and button options by default to make the user preferences screen cleaner.

= 2.12.2 =
* Fixed issue with Chrome not centering the toolbar correctly
* Prettied up the font/color listboxes.  Only works on some browsers.

= 2.12.1 =
* Fixed a bug in the DFWM link code which ALWAYS included the linked regardless of the user preference setting.

= 2.12 =
* Fixed a bug between the center toolbar and autoload code.
* Added option to add a DFWM link to the post and pages list.

= 2.11 =
* Added option to center the toolbar on screen.

= 2.10 =
* Added Font, Font Size, Font Color and Background Color selector options

= 2.9 =
* Fixed issue with auto load of DFWM being triggered every time a post was updated or published
* Fixed issue with new installs, users would get a blank screen if they did not save their profile settings before editing a post

= 2.8 =
* Add support for visual separators between button groups
* Modularized the code as the primary PHP file was getting large
* Added support for translation of the 'Exit' button

= 2.7 =
* Added Cut/Copy/Paste buttons
* Cleaned up the preferences screen
* Added 'Select Defaults' to the preferences screen

= 2.6 =
* Fixed missing css file that caused the P, H1-H6, etc. buttons to not display an image
* Added Superscript and Subscript buttons

= 2.5 =
* Added support for Right-to-Left languages

= 2.4 =
* Added option to use a listbox instead of individual buttons
* Fixed bug in border option selector which would not allow you to save the hide option
 
= 2.3 =
* Added rate and review reminder in the user profile page
* Added reminder to make sure the Visual Editor is enabled in the user profile page
* Added option to start in DFWM for new posts
* Added option to start in DFWM when editing posts
* Added 'lighter' border option for title/body area
* Cleaned up the De/Select All code in the user profile page, should work with all 
  browsers now

= 2.2 =
* Minor readme.txt updates.
* Added option to disable editor mode bar.
* Added brief description to the plugin in the user option panel.
* Added code to hide the options list in the user panel when disabled.

= 2.1 =
* Minor bug fix, if a user for the first time went to their user preferences before editing a post the defaults would not be set.

= 2.0 =
* Added options to remove the fade effect, hide the border, word count and preview button.

= 1.0 =
* Released on WordPress.org

= 0.3 =
* Re-ordered buttons.
* Allow disabling of default buttons.

= 0.2 =
* Added user preferences.

= 0.1 =
* Initial release.

== Upgrade Notice ==
= 2.17 =
* None.

== Roadmap ==
* Version 3.0  - add second row to toolbar, remove individual style buttons
               - update how preferences are stored to reduce database calls
