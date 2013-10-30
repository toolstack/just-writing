=== Just Writing ===
Contributors: GregRoss
Plugin URI: http://toolstack.com/just-writing
Author URI: http://toolstack.com
Tags: admin posts writing
Requires at least: 3.5.0
Tested up to: 3.7.1
Stable tag: 2.6

Adds buttons to the Distraction Free Writing Mode for all kinds of extra functions.

== Description ==

Distraction Free Writing Mode (DFWM) is a great way to focus on writing text, but have you ever found yourself wanting to do a bit more with it?  How about spell check, or change the paragraph style without dropping back to the standard post edit mode?  Now you can get all the functionality of the standard mode tools in DFWM!

But maybe you think there are too many buttons in DFWM, no problem you can get rid of pretty much all of them!

Just Writing takes DFWM from a great way to write to a great way of writing posts!

This plugin adds the following commands to the toolbar in DFWM:

	* Strikethrough
	* Underline
	* RemoveFormat
	* Align Left
	* Align Full
	* Align Right
	* Indent
	* Paragraph
	* H1
	* H2
	* H3
	* H4
	* H5
	* H6
	* Address
	* Preformatted
	* Proofread Writing
	* Insert More Tag
	* Insert custom character
	* Undo
	* Redo
	* Preview
	* Superscript
	* Subscript

And there's more!

	* Option to remove the fade effect and keep the toolbar visiable
	* Option to hide the border on the title/body areas
	* Option to hide the word count
	* Adds an optional Preview button to the right of the Save button
	* Moves the exit link to the right of the new Preview 
	  button as a real button
	* Re-orders the button list to make more sense
	* Per-user preferences for enabling Just Writing
	* Per-user preferences for which buttons to display
	* Option to start in DFWM for new posts
	* Option to start in DFWM when editing posts
	* 'lighter' border option for title/body area
	* Option to disable editor mode bar.

This code is released under the GPL v2, see license.txt for details.

== Installation ==

1. Extract the archive file into your plugins directory in the just-writing folder.
2. Activate the plugin in the Plugin options.
3. Login to WordPress and go to your profile page, update the options at the bottom.

== Frequently Asked Questions ==

= What browsers are supported? =

Try it and find out, the javascript is pretty basic so it should work in just about any browser (note even without javascript the buttons will be added, however the the preview and exit buttons along with the fade disable and border and word count hiding options will not be available).  I've successfully run it on:

	* IE 11
	* Opera 12.16
	* FireFox 24

= I've disabled the fade effect and now the browser is running slowly, what's wrong? =

The fade effect is triggered by WordPress when no mouse movement is executed for 2 seconds, the only (without changing some of the WordPress sources files at least) way to disable it is to execute a mousemove event every 1.5 seconds.  This shouldn't be an issue in any modern browser, but if your having performance issues, simply re-enable the fade effect.

= I've disabled the fade effect but there is a 'flicker' when DFWM comes up, what's wrong? =

If you start DFWM without moving the mouse you might hit right between when WordPress starts fading but before Just Writing fires off a mousemove event, this shouldn't be an issue after the first start of DFWM.


== Screenshots ==

1. Pre installation DFWM.
2. Post installation DFWM.
3. User preferences screen.
4. A real DFWM!

== Changelog ==
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
= 2.6 =
* None.

= 2.5 =
* None.

= 2.4 =
* New option for the format listbox will not be enabled until a user selections the option for existing users.  New users will have the opiton enabled by default.

= 2.3 =
* None.

= 2.2 =
* None.

= 2.1 =
* None.

= 2.0 =
* Disabling the fade effect will force javascript to execute a mousemove event every 1.5 seconds, this could have a performance impact on some browsers.

= 1.0 =
* None.

= 0.3 =
* None.

= 0.2 =
* None.

= 0.1 =
Initial release, no updates as everything is new!

== Roadmap ==

* Add dividers for button groups
