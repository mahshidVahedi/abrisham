//import $ from 'jquery';
import generatePlugin from './generate-plugin.js';
import EmojiStyleGenerator from './EmojiStyleGenerator.js'
import EmojiArea from './EmojiArea.js';

generatePlugin('emojiarea', EmojiArea);

/**
 * call auto initialization.
 */
$(() => {
  $('[data-emoji-inject-style]').each((i, e) => {EmojiStyleGenerator.injectImageStyles(e); });
  $('[data-emojiarea]').emojiarea();
});
