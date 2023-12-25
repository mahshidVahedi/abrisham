/**
 * Emoji Picker (Dropdown) can work as global singleton (one dropdown for all inputs on the page)
 * or with separate instances (and settings) for each input.
 *
 * @author Wolfgang Stöttinger
 */
import EmojiArea from './EmojiArea.js';
import Emoji from './EmojiUtil.js';

export default class EmojiPicker {

  constructor(options = EmojiArea.DEFAULTS) {
    this.o = options;
    const $body = $(document.body);
    var $this = this;
    $body.on('keydown', (e) => { if (e.keyCode === KEY_ESC || e.keyCode === KEY_TAB) this.hide(); });
    $body.on('click', function(e) {
      if(!$(e.target).closest('.chat-input').length && !$(e.target).filter('.chat-input').length)
          $this.hide();
    });
    $(window).on('resize', () => { if (this.$p.is(':visible')) { this.reposition(); }});

    this.$p = $('<div>')
      .addClass('emoji-picker')
      .attr('data-picker-type', options.type) // $.data() here not possible, doesn't change dom
      .on('mouseup click', (e) => e.stopPropagation() && false)
      .hide()
      .insertBefore($('.conversation-chat-box .chat-editor .chat-send'));

    const tabs = this.loadPicker();
    setTimeout(this.loadEmojis.bind(this, tabs), 100);
  }


  getCaretPosition(editableDiv) {
      var caretPos = 0,
          sel, range;
      if (window.getSelection) {
          sel = window.getSelection();
          if (sel.rangeCount) {
              range = sel.getRangeAt(0);
              if (range.commonAncestorContainer.parentNode == editableDiv) {
                  caretPos = range.endOffset;
              }
          }
      }
      else if (document.selection && document.selection.createRange) {
          range = document.selection.createRange();
          if (range.parentElement() == editableDiv) {
              var tempEl = document.createElement("span");
              editableDiv.insertBefore(tempEl, editableDiv.firstChild);
              var tempRange = range.duplicate();
              tempRange.moveToElementText(tempEl);
              tempRange.setEndPoint("EndToEnd", range);
              caretPos = tempRange.text.length;
          }
      }
      return caretPos;
  }



    loadPicker() {
    const ul = $('<ul>')
      .addClass('emoji-selector');
    const tabs = $('<div>')
      .addClass('tab-content');

    for (let g = 0; g < Emoji.groups.length; g++) {
      const group = Emoji.groups[g];
      const id = 'group_' + group.name;
      const gid = '#' + id;

      const a = $('<a>')
        .html(EmojiArea.createEmoji(group.name, this.o))
        .data('toggle', 'tab')
        .attr('href', gid);

      ul.append($('<li>').append(a));

      const tab = $('<div>')
        .attr('id', id)
        .addClass('emoji-group tab-pane')
        .data('group', group.name);

      a.on('click', (e) => {
        $('.tab-pane').not(tab).hide().removeClass('active');
        tab.addClass('active').show();
        e.preventDefault();
      });
      tabs.append(tab);
    }

    tabs.find('.tab-pane').not(':first-child').hide().removeClass('active');

    this.$p.append(ul).append(tabs);
    return tabs.children();
  }

  loadEmojis(tabs) {
    for (let g = 0; g < Emoji.groups.length; g++) {
      const group = Emoji.groups[g];
      const tab = tabs[g];
      for (let e = 0; e < group.items.length; e++) {
        const emojiId = group.items[e];
        if (Emoji.data.hasOwnProperty(emojiId)) {
          const word = Emoji.data[emojiId][Emoji.EMOJI_ALIASES] || '';
          const emojiElem = $('<a>')
            .data('emoji', word)
            .html(EmojiArea.createEmoji(word, this.o))
            .on('click', () => {this.insertEmoji(word)});
          $(tab).append(emojiElem);
        }
      }
    }
  }

  insertEmoji(emoji) {
    if (typeof this.cb === 'function')
      this.cb(emoji, this.o);
    // this.hide();
  }

  reposition(anchor, options) {
    if (!anchor || anchor.length === 0)
      return;
    const $anchor = $(anchor);
    const anchorOffset = $anchor.offset();
    // this.$p.css({
    //   bottom: anchorOffset.top - $('.conversation-chat-box').outerHeight() + 30,
    //   left: 20,
    // });
  };

  show(insertCallback, anchor, options) {
    this.cb = insertCallback;
    this.reposition(anchor, options);
    this.$p.attr('data-picker-type', options.type); // $.data() here not possible, doesn't change dom
    this.$p.show();
    return this;
  }

  hide() {
    this.$p.hide();
  }

  isVisible() {
    return this.$p.is(':visible');
  }
}

EmojiPicker.globalPicker = null;

EmojiPicker.show = function (insertCallback, anchor, options = EmojiArea.DEFAULTS) {
  let picker = EmojiPicker.globalPicker;
  if (!options.globalPicker)
    picker = new EmojiPicker(options);
  if (!picker)
    picker = EmojiPicker.globalPicker = new EmojiPicker(options);
  picker.show(insertCallback, anchor, options);
  return picker;
};

EmojiPicker.isVisible = function () {
  return EmojiPicker.globalPicker && EmojiPicker.globalPicker.isVisible();
};

EmojiPicker.hide = function () {
  !EmojiPicker.globalPicker || EmojiPicker.globalPicker.hide();
};

const KEY_ESC = 27;
const KEY_TAB = 9;