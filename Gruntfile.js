/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    sass: {                              // Task
      debug: {                            // Target
        options: {                       // Target options
          style: 'expanded'
        },
        files: {                         // Dictionary of files
          'admin/css/admin-style.css': 'admin/css/admin-style.scss',       // 'destination': 'source'
          'css/simple-vertical-timeline.css': 'css/simple-vertical-timeline.scss'
        }
      },
      dist: {                            // Target
        options: {                       // Target options
          style: 'compressed'
        },
        files: {                         // Dictionary of files
          'admin/css/admin-style.min.css': 'admin/css/admin-style.scss',       // 'destination': 'source'
          'css/simple-vertical-timeline.min.css': 'css/simple-vertical-timeline.scss'
        }
      }
    },
    coffee: {
      compile: {
        files: {
          'js/svt-animation.js': 'js/svt-animation.coffee',
          'js/svtplugin/svt-plugin.js': 'js/svtplugin/svt-plugin.coffee'
        }
      }
    },
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      }
    },
    replace: {
      readme: {
        options: {
          patterns: [
            {
              match: /(Stable tag: \d+\.\d+\.\d+)/,
              replacement: 'Stable tag: <%= pkg.version %>'
            }
          ]
        },
        files: [
          {expand: true, flatten: true, src: ['readme.txt'], dest: './'}
        ]
      },
      vercode: {
        options: {
          patterns: [
            {
              match: /(Version: \d+\.\d+\.\d+)/,
              replacement: 'Version: <%= pkg.version %>'
            }
          ]
        },
        files: [
          {expand: true, flatten: true, src: ['simple-vertical-timeline.php'], dest: './'}
        ]
      },
      vercode2: {
        options: {
          patterns: [
            {
              match: /('SVT_VER', '\d+\.\d+\.\d+')/,
              replacement: '\'SVT_VER\', \'<%= pkg.version %>\''
            }
          ]
        },
        files: [
          {expand: true, flatten: true, src: ['simple-vertical-timeline.php'], dest: './'}
        ]
      }
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: 'js/svt-animation.js',
        dest: 'js/svt-animation.min.js'
      },
      dist_admin: {
        src: 'js/svtplugin/svt-plugin.js',
        dest: 'js/svtplugin/svt-plugin.min.js'
      }
    },
    watch: {
      sass:{
        files: ['admin/css/**/*.scss','/css/**/*.scss'],
        tasks: ['sass']
      },
      coffee:{
        files: ['js/**/*.coffee'],
        tasks: ['coffee','uglify']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-replace');




  // Default task.
  grunt.registerTask('default', ['sass', 'coffee' , 'concat', 'uglify', 'replace']);

};
