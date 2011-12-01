/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	/**
 * A list of keystrokes to be blocked if not defined in the {@link CKEDITOR.config.keystrokes}
 * setting. In this way it is possible to block the default browser behavior
 * for those keystrokes.
 * @type Array
 * @default (see example)
 * @example
 * // This is actually the default value.
 * config.blockedKeystrokes =
 * [
 *     CKEDITOR.CTRL + 66 &#47;*B*&#47;,
 *     CKEDITOR.CTRL + 73 &#47;*I*&#47;,
 *     CKEDITOR.CTRL + 85 &#47;*U*&#47;
 * ];
 */
config.blockedKeystrokes =
[
	CKEDITOR.CTRL + 66 /*B*/,
	CKEDITOR.CTRL + 73 /*I*/,
	CKEDITOR.CTRL + 85 /*U*/,
	CKEDITOR.CTRL + 83 /*S*/
];

/**
 * A list associating keystrokes to editor commands. Each element in the list
 * is an array where the first item is the keystroke, and the second is the
 * name of the command to be executed.
 * @type Array
 * @default (see example)
 * @example
 * // This is actually the default value.
 * config.keystrokes =
 * [
 *     [ CKEDITOR.ALT + 121 &#47;*F10*&#47;, 'toolbarFocus' ],
 *     [ CKEDITOR.ALT + 122 &#47;*F11*&#47;, 'elementsPathFocus' ],
 *
 *     [ CKEDITOR.SHIFT + 121 &#47;*F10*&#47;, 'contextMenu' ],
 *
 *     [ CKEDITOR.CTRL + 90 &#47;*Z*&#47;, 'undo' ],
 *     [ CKEDITOR.CTRL + 89 &#47;*Y*&#47;, 'redo' ],
 *     [ CKEDITOR.CTRL + CKEDITOR.SHIFT + 90 &#47;*Z*&#47;, 'redo' ],
 *
 *     [ CKEDITOR.CTRL + 76 &#47;*L*&#47;, 'link' ],
 *
 *     [ CKEDITOR.CTRL + 66 &#47;*B*&#47;, 'bold' ],
 *     [ CKEDITOR.CTRL + 73 &#47;*I*&#47;, 'italic' ],
 *     [ CKEDITOR.CTRL + 85 &#47;*U*&#47;, 'underline' ],
 *
 *     [ CKEDITOR.ALT + 109 &#47;*-*&#47;, 'toolbarCollapse' ]
 * ];
 */
config.keystrokes =
[
	[ CKEDITOR.ALT + 121 /*F10*/, 'toolbarFocus' ],
	[ CKEDITOR.ALT + 122 /*F11*/, 'elementsPathFocus' ],

	[ CKEDITOR.SHIFT + 121 /*F10*/, 'contextMenu' ],
	[ CKEDITOR.CTRL + CKEDITOR.SHIFT + 121 /*F10*/, 'contextMenu' ],

	[ CKEDITOR.CTRL + 90 /*Z*/, 'undo' ],
	[ CKEDITOR.CTRL + 89 /*Y*/, 'redo' ],
	[ CKEDITOR.CTRL + 83 /*S*/, 'save' ],
	[ CKEDITOR.CTRL + CKEDITOR.SHIFT + 90 /*Z*/, 'redo' ],

	[ CKEDITOR.CTRL + 76 /*L*/, 'link' ],

	[ CKEDITOR.CTRL + 66 /*B*/, 'bold' ],
	[ CKEDITOR.CTRL + 73 /*I*/, 'italic' ],
	[ CKEDITOR.CTRL + 85 /*U*/, 'underline' ],

	[ CKEDITOR.ALT + 109 /*-*/, 'toolbarCollapse' ]
];

config.enterMode = CKEDITOR.ENTER_BR;

/**
 * Added Jan 2010 by Phil Gapp - attempting to protect php scripts in our editable content.
 * @type regex array
 * @default /<\?[\s\S]*?\?>/g
 * @example
 * config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP Code
 */
config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP Code

};

CKEDITOR.plugins.load('pgrfilemanager');





