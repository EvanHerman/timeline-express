'use strict';
module.exports = function(grunt) {

  grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

    // js minification
    uglify: {
      dist: {
        files: {
          // admin scripts
          'lib/admin/js/min/timeline-express-admin.min.js': [ // all other admin scripts
            'lib/admin/js/bootstrap-select.js',
            'lib/admin/js/script.options-color-picker-custom.js',
          ],
          // tinymce scripts
          'lib/admin/js/min/timeline-express-tinymce.min.js': [ // tinymce button script
            'lib/admin/js/timeline-express-button-script.js',
          ],
					// public scripts
					'lib/public/js/min/timeline-express.min.js': [ // public scripts
						'lib/public/js/timeline-express.js',
					],
        }
      }
    },

    // Autoprefixer for our CSS files
    postcss: {
      options: {
        map: true,
        processors: [
          require('autoprefixer-core') ({
            browsers: ['last 2 versions']
          })
        ]
      },
      dist: {
        src: ['lib/admin/css/*.css', 'lib/public/css/*.css']
      }
    },
    auto_install: {
      local: {}
    },

    // css minify all contents of our directory and add .min.css extension
    cssmin: {
      target: {
        files: [
          // admin css files
          {
						'lib/admin/css/min/timeline-express-admin.min.css':
						[
							'lib/admin/css/timeline-express-settings.css',
							'lib/admin/css/timeline-express-welcome.css',
							'lib/admin/css/timeline-express-addons.css'
						],
          }, {
						'lib/public/css/min/timeline-express.min.css':
						[
							'lib/public/css/timeline-express.css',
							'lib/public/css/timeline-express-single-page.css',
						],
					}
        ]
      }
    },

		// Generate a nice banner for our css/js files
		usebanner: {
	    taskName: {
	      options: {
	        position: 'top',
	        banner: '/*! @Plugin <%= pkg.title %> ' +
						' - @Author <%= pkg.author %> '+
						'- @Site <%= pkg.site %> '+
						'- @Version <%= pkg.version %> - ' +
		        '@Build <%= grunt.template.today("mm-dd-yyyy") %> !*/',
	        linebreak: true
	      },
	      files: {
	        src: [
						'lib/public/css/min/timeline-express.min.css',
						'lib/admin/css/min/timeline-express-admin.min.css',
						'lib/public/js/min/timeline-express.min.js',
						'lib/admin/js/min/timeline-express-tinymce.min.js',
						'lib/admin/js/min/timeline-express-admin.min.js',
					]
	      }
	    }
	  },

    // Copy our template files to the root /template/ directory.
    copy: {
      main: {
        files: [
          // copy over the announcement container template
          {
            expand: true,
            flatten: true,
            src: ['lib/public/partials/timeline-express-container.php'],
            dest: 'templates/',
            filter: 'isFile'
          }, {
            expand: true,
            flatten: true,
            src: ['lib/public/partials/single.timeline-express.php'],
            dest: 'templates/',
            filter: 'isFile'
          },
        ],
      },
    },

    // watch our project for changes
    watch: {
      admin_css: { // admin css
        files: 'lib/admin/css/*.css',
        tasks: ['cssmin'],
        options: {
          spawn: false,
          event: ['all']
        },
      },
      admin_js: { // admin js
        files: 'lib/admin/js/*.js',
        tasks: ['uglify'],
        options: {
          spawn: false,
          event: ['all']
        },
      },
      public_css: {
        // public css
        files: 'lib/public/css/*.css',
        tasks: ['cssmin'],
        options: {
          spawn: false,
          event: ['all']
        },
      },
      public_js: { // public js
        files: 'lib/public/js/*.js',
        tasks: ['uglify'],
        options: {
          spawn: false,
          event: ['all']
        },
      },
    },

  });

  // load tasks
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-banner');
	grunt.loadNpmTasks('grunt-contrib-copy'); // Copy template files from within the plugin - over to a /template/ directory in the plugin root.
  grunt.loadNpmTasks('grunt-postcss'); // CSS autoprefixer plugin (cross-browser auto pre-fixes)
  grunt.loadNpmTasks('grunt-auto-install'); // autoload all of ourd ependencies (ideally, you install this one package, and run grunt auto_install to install our dependencies automagically)

  // register task
  grunt.registerTask('default', [
    'uglify',
    'postcss',
    'cssmin',
		'usebanner',
    'copy',
    // 'watch',
  ]);

};
