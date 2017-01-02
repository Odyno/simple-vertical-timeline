
  tinymce.create 'tinymce.plugins.svt',
    ##
    # Initializes the plugin, this will be executed after the plugin has been created.
    # This call is done before the editor instance has finished it's initialization so use the onInit event
    # of the editor instance to intercept that event.
    #
    # @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
    # @param {string} url Absolute URL to where the plugin is located.
    ##
    init: (ed, url) ->
      svtimelineButtons=null
      svtEventButtons= null

      ed.addButton 'svtimeline',
        title: "Simple Vertical Timeline"
        cmd: "svtimeline"
        image: url + "/img/timeline.png"
        onPostRender : ->
          svtimelineButtons = this
          return


      ed.addButton 'svtevent',
        title: "Event for Simple Vertical Timeline"
        cmd: "svtevent"
        image: url + "/img/timeevent.png"
        onPostRender : ->
          svtEventButtons = this
          return


      ed.addCommand 'svtimeline', ->
        shortcode = "[svtimeline]"+ed.selection.getContent()+"[/svtimeline]"
        ed.execCommand 'mceInsertContent', 0, shortcode


      ed.addCommand 'svtevent', ->
        today = new Date
        dd = today.getDate()
        mm = today.getMonth() + 1
        #January is 0!
        yyyy = today.getFullYear()
        if dd < 10
          dd = '0' + dd
        if mm < 10
          mm = '0' + mm


        ed.windowManager.open
          title: 'Insert Timeline Events'
          body: [
            {
              type: 'textbox'
              name: 'title'
              label: 'Title:'
            }
            {
              type: 'textbox'
              name: 'content'
              label: 'Note:'
              multiline: true
              value: ed.selection.getContent()
            }

            {
              type: 'textbox'
              name: 'date'
              label: 'Date:'
              value: dd + '/' + mm + '/' + yyyy

            }
            {
              type: 'listbox'
              name: 'style'
              label: 'Node color'
              'values': [
                {text: 'green', value: 'svt-cd-green'},
                {text: 'blue', value: 'svt-cd-blue'},
                {text: 'red', value: 'svt-cd-red'},
                {text: 'white', value: 'svt-cd-white'},
                {text: 'yellow', value: 'svt-cd-yellow'}
              ]
            }

          ]
          onsubmit: (e) ->
            if e.data.title? and e.data.title!=''
              title=' title="' + e.data.title + '" '
            else
              title=''

            if e.data.date? and e.data.date!=''
              date=' date="' + e.data.date + '" '
            else
              date=' date=""'

            if e.data.style? and e.data.style!=''
              style=' class="' + e.data.style + '" '
            else
              style=''

            if e.data.content? and e.data.content!=''
              content=e.data.content
            else
              content=ed.selection.getContent()



            ed.insertContent '[svt-event  '+title+date+style+' ] '+content+" [/svt-event]"
            return




    ##
    # Creates control instances based in the incomming name. This method is normally not
    # needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
    # but you sometimes need to create more complex controls like listboxes, split buttons etc then this
    # method can be used to create those.
    #
    # @param {String} n Name of the control to create.
    # @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
    # @return {tinymce.ui.Control} New control instance or null if no control was created.
    ##
    createControl: (n, cm) ->
      null

    ##
    # Returns information about the plugin as a name/value array.
    # The current keys are longname, author, authorurl, infourl and version.
    #
    # @return {Object} Name/value array containing information about the plugin.
    ##
    getInfo: ->
      {
        longname: 'SVT Buttons'
        author: 'Alessandro Staniscia'
        authorurl: 'http://www.staniscia.net'
        infourl: 'http://www.staniscia.net'
        version: '0.1'
      }

  # Register plugin
  tinymce.PluginManager.add 'svt', tinymce.plugins.svt
