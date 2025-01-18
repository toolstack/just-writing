/*
    Register the settings panel for the word count.
*/
( function( wp ) {
    var registerPlugin = wp.plugins.registerPlugin;
    var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
    var el = wp.element.createElement;
    var __ = wp.i18n.__;

    registerPlugin( 'just-writing-wordcount-setting-panel', {
        render: function() {
            return el(
                PluginDocumentSettingPanel,
                {
                    className: 'just-writing-wordcount-setting-panel',
                    title: 'Word Count',
                },
                null
            );
        },
    } );
} )( window.wp );

/*
    This function counts the words in a sentence or string of text.
*/
function JustWritingWordCounter( sentence )
    {
    sentence = sentence.trim();

    if( sentence.length === 0 ) { return 0; }

    // Break the sentence up by word breaks.
    var WordSplit = sentence.split( /\b/ );

    // Now count the number of splits we did.
    var SplitCount = sentence.split( /\b/ ).length;

    // Time for some math, as we have to remove the wordbreak characters from the list, so divide it by two and round up.
    var WordCount = Math.round( SplitCount / 2 );
    
    // Make sure we don't get an error or some other null type value.
    if( ! WordCount )
        {
        WordCount = 0;
        }

    return WordCount;
    }

function JustWritingUpdateWordCount()
    {
    var body = jQuery( '.block-editor-block-list__layout' );

    body.each( function( index ) {
        WordCount = JustWritingWordCounter( this.innerText );

        button = jQuery( 'div.components-panel__body.just-writing-wordcount-setting-panel > h2 > button');
        button[0].innerText = 'Word Count: ' + WordCount;
        });
    }