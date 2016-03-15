'use strict';
module.exports = function(grunt) {

    grunt.initConfig({
	
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
                }
            }
        },

		// css minify all contents of our directory and add .min.css extension
		cssmin: {
			target: {
				files: [
					// admin css files
					{
						expand: true,
						cwd: 'lib/admin/css',
						src: [
							'timeline-express-settings.css',
						], // main style declaration file
						dest: 'lib/admin/css/min',
						ext: '.min.css'
					},
					{
						expand: true,
						cwd: 'lib/public/css',
						src: [
							'timeline-express.css',
							'timeline-express-single-page.css',
						], // main style declaration file
						dest: 'lib/public/css/min',
						ext: '.min.css'
					}
				]
			}
		},
		
        // watch our project for changes
       watch: {
			admin_css: { // admin css
				files: 'lib/admin/css/*.css',
				tasks: ['cssmin'],
				options: {
					spawn:false,
					event:['all']
				},
			},
			admin_js: { // admin js
				files: 'lib/admin/js/*.js',
				tasks: ['uglify'],
				options: {
					spawn:false,
					event:['all']
				},
			},
			public_css: {
			 // public css
				files: 'lib/public/css/*.css',
				tasks: ['cssmin'],
				options: {
					spawn:false,
					event:['all']
				},
			},
			public_js: { // public js
				files: 'lib/public/js/*.js',
				tasks: ['uglify'],
				options: {
					spawn:false,
					event:['all']
				},
			},
		},
		
		// Borwser Sync
		/*
		browserSync: {
			bsFiles: {
				src : [ 'admin/css/*.min.css' , 'public/css/*.min.css' , 'admin/js/*.min.js' , 'public/js/*.min.js' ],
			},
			options: {
				proxy: "localhost/mc_free/",
				watchTask : true
			}
		},
		*/
		
		// Autoprefixer for our CSS files
		postcss: {
			options: {
                map: true,
                processors: [
                    require('autoprefixer-core')({
                        browsers: ['last 2 versions']
                    })
                ]
            },
			dist: {
			  src: [ 'lib/admin/css/*.css' , 'lib/public/css/*.css' ]
			}
		},
		auto_install: { 
			local: {}
		},
		
    });

    // load tasks
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	// grunt.loadNpmTasks('grunt-browser-sync'); // browser-sync auto refresh
	grunt.loadNpmTasks('grunt-postcss'); // CSS autoprefixer plugin (cross-browser auto pre-fixes)
	grunt.loadNpmTasks('grunt-wp-i18n'); // wordpress localization plugin
	grunt.loadNpmTasks('grunt-auto-install'); // autoload all of ourd ependencies (ideally, you install this one package, and run grunt auto_install to install our dependencies automagically)

    // register task
    grunt.registerTask('default', [
		'uglify',
		'postcss',
        'cssmin',
		/* 'browserSync', */
        'watch',
    ]);

};