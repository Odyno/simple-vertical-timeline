(function() {
  tinymce.create('tinymce.plugins.svt', {
    init: function(ed, url) {
      var svtEventButtons, svtimelineButtons;
      svtimelineButtons = null;
      svtEventButtons = null;
      ed.addButton('svtimeline', {
        title: "Simple Vertical Timeline",
        cmd: "svtimeline",
        image: url + "/img/timeline.png",
        onPostRender: function() {
          svtimelineButtons = this;
        }
      });
      ed.addButton('svtevent', {
        title: "Event for Simple Vertical Timeline",
        cmd: "svtevent",
        image: url + "/img/timeevent.png",
        onPostRender: function() {
          svtEventButtons = this;
        }
      });
      ed.addCommand('svtimeline', function() {
        var shortcode;
        shortcode = "[svtimeline]" + ed.selection.getContent() + "[/svtimeline]";
        return ed.execCommand('mceInsertContent', 0, shortcode);
      });
      return ed.addCommand('svtevent', function() {
        var dd, mm, today, yyyy;
        today = new Date;
        dd = today.getDate();
        mm = today.getMonth() + 1;
        yyyy = today.getFullYear();
        if (dd < 10) {
          dd = '0' + dd;
        }
        if (mm < 10) {
          mm = '0' + mm;
        }
        return ed.windowManager.open({
          title: 'Insert Timeline Events',
          body: [
            {
              type: 'textbox',
              name: 'title',
              label: 'Title:'
            }, {
              type: 'textbox',
              name: 'content',
              label: 'Note:',
              multiline: true,
              value: ed.selection.getContent()
            }, {
              type: 'textbox',
              name: 'date',
              label: 'Date:',
              value: dd + '/' + mm + '/' + yyyy
            }, {
              type: 'listbox',
              name: 'style',
              label: 'Node color',
              'values': [
                {
                  text: 'green',
                  value: 'svt-cd-green'
                }, {
                  text: 'blue',
                  value: 'svt-cd-blue'
                }, {
                  text: 'red',
                  value: 'svt-cd-red'
                }, {
                  text: 'white',
                  value: 'svt-cd-white'
                }, {
                  text: 'yellow',
                  value: 'svt-cd-yellow'
                }
              ]
            }
          ],
          onsubmit: function(e) {
            var content, date, style, title;
            if ((e.data.title != null) && e.data.title !== '') {
              title = ' title="' + e.data.title + '" ';
            } else {
              title = '';
            }
            if ((e.data.date != null) && e.data.date !== '') {
              date = ' date="' + e.data.date + '" ';
            } else {
              date = ' date=""';
            }
            if ((e.data.style != null) && e.data.style !== '') {
              style = ' class="' + e.data.style + '" ';
            } else {
              style = '';
            }
            if ((e.data.content != null) && e.data.content !== '') {
              content = e.data.content;
            } else {
              content = ed.selection.getContent();
            }
            ed.insertContent('[svt-event  ' + title + date + style + ' ] ' + content + " [/svt-event]");
          }
        });
      });
    },
    createControl: function(n, cm) {
      return null;
    },
    getInfo: function() {
      return {
        longname: 'SVT Buttons',
        author: 'Alessandro Staniscia',
        authorurl: 'http://www.staniscia.net',
        infourl: 'http://www.staniscia.net',
        version: '0.1'
      };
    }
  });

  tinymce.PluginManager.add('svt', tinymce.plugins.svt);

}).call(this);
