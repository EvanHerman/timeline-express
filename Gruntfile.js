'use strict';
module.exports = function(grunt) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

		pkg: pkg,

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

		// css minify all contents of our directory and add .min.css extension
		cssmin: {
			target: {
				files: [
					// Admin CSS files
					{
						'lib/admin/css/min/timeline-express-admin.min.css':
						[
							'lib/admin/css/timeline-express-settings.css',
							'lib/admin/css/timeline-express-welcome.css',
							'lib/admin/css/timeline-express-addons.css'
						],
					},
					// Admin RTL CSS files
					{
						'lib/admin/css/min/timeline-express-admin-rtl.min.css':
						[
							'lib/admin/css/timeline-express-settings-rtl.css',
							'lib/admin/css/timeline-express-welcome-rtl.css',
							'lib/admin/css/timeline-express-addons-rtl.css'
						],
					},
					// Public CSS file
					{
						'lib/public/css/min/timeline-express.min.css':
						[
							'lib/public/css/timeline-express.css',
							'lib/public/css/timeline-express-single-page.css'
						],
					},
					// Public RTL CSS file
					{
						'lib/public/css/min/timeline-express-rtl.min.css':
						[
							'lib/public/css/timeline-express-rtl.css',
							'lib/public/css/timeline-express-single-page.css',
							'lib/public/css/timeline-express-single-page-rtl.css'
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
					replace: true,
					banner: '/*\n'+
						' * @Plugin <%= pkg.title %>\n' +
						' * @Author <%= pkg.author %>\n'+
						' * @Site <%= pkg.site %>\n'+
						' * @Version <%= pkg.version %>\n' +
						' * @Build <%= grunt.template.today("mm-dd-yyyy") %>\n'+
						' */',
					linebreak: true
				},
				files: {
					src: [
						'lib/public/css/min/timeline-express.min.css',
						'lib/public/css/min/timeline-express-rtl.min.css',
						'lib/public/js/min/timeline-express.min.js',
						'lib/admin/css/min/timeline-express-admin.min.css',
						'lib/admin/css/min/timeline-express-admin-rtl.min.css',
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
						src: ['lib/public/partials/*.php'],
						dest: 'templates/',
						filter: 'isFile'
					},
				],
			},
			deploy: {
				files: [
					// copy over the files in preperation for a deploy to SVN
					{
						expand: true,
						src: [
							'constants.php',
							'i18n/**',
							'lib/**',
							'templates/**',
							'readme.txt',
							'timeline-express.php',
							'uninstall.php',
							'wpml-config.xml'
						],
						dest: 'build/'
					},
				],
			}
		},

		// watch our project for changes
		watch: {
			admin_css: { // admin css
				files: 'lib/admin/css/*.css',
				tasks: [ 'cssjanus', 'cssmin', 'usebanner' ],
				options: {
					spawn: false,
					event: ['all']
				},
			},
			admin_js: { // admin js
				files: 'lib/admin/js/*.js',
				tasks: [ 'uglify', 'usebanner' ],
				options: {
					spawn: false,
					event: ['all']
				},
			},
			public_css: {
				// public css
				files: 'lib/public/css/*.css',
				tasks: [ 'cssjanus', 'cssmin', 'usebanner' ],
				options: {
					spawn: false,
					event: ['all']
				},
			},
			public_js: { // public js
				files: 'lib/public/js/*.js',
				tasks: [ 'uglify', 'usebanner' ],
				options: {
					spawn: false,
					event: ['all']
				},
			},
		},

		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'lib/admin/css/timeline-express-addons.css',
						dest: 'lib/admin/css/timeline-express-addons-rtl.css'
					},
					{
						src: 'lib/admin/css/timeline-express-settings.css',
						dest: 'lib/admin/css/timeline-express-settings-rtl.css'
					},
					{
						src: 'lib/admin/css/timeline-express-welcome.css',
						dest: 'lib/admin/css/timeline-express-welcome-rtl.css'
					},
					{
						src: 'lib/public/css/timeline-express-single-page.css',
						dest: 'lib/public/css/timeline-express-single-page-rtl.css'
					},
					{
						src: 'lib/public/css/timeline-express.css',
						dest: 'lib/public/css/timeline-express-rtl.css'
					}
				]
			}
		},

		makepot: {
			target: {
				options: {
					domainPath: 'i18n/',
					include: [ '.+\.php' ],
					exclude: [ 'node_modules/', 'bin/', 'lib/admin/CMB2', 'tests/', 'lib/admin/classes/usage-tracking/vendor/' ],
					potComments: 'Copyright (c) {year} Code Parrots. All Rights Reserved.',
					potHeaders: {
						'x-poedit-keywordslist': true
					},
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = pkg.bugs.url;
						return pot;
					},
					type: 'wp-plugin',
					updatePoFiles: true
				}
			}
		},

		po2mo: {
			files: {
				src: 'i18n/*.po',
				expand: true
			}
		},

		replace: {
			base_file: {
				src: [ 'timeline-express.php' ],
				overwrite: true,
				replacements: [{
					from: /Version: (.*)/,
					to: "Version: <%= pkg.version %>"
				}]
			},
			readme_txt: {
				src: [ 'readme.txt' ],
				overwrite: true,
				replacements: [{
					from: /Stable tag: (.*)/,
					to: "Stable tag: <%= pkg.version %>"
				}]
			},
			readme_md: {
				src: [ 'README.md' ],
				overwrite: true,
				replacements: [{
					from: /# Timeline Express - (.*)/,
					to: "# Timeline Express - <%= pkg.version %>"
				}]
			},
			constants: {
				src: [ 'constants.php' ],
				overwrite: true,
				replacements: [{
					from: /define\(\s*'TIMELINE_EXPRESS_VERSION_CURRENT',\s*'(.*)'\s*\);/,
					to: "define( 'TIMELINE_EXPRESS_VERSION_CURRENT', '<%= pkg.version %>' );"
				}]
			}
		},

		wp_deploy: {
			deploy: {
				options: {
					plugin_slug: 'timeline-express',
					build_dir: 'build/',
					deploy_trunk: true,
					deploy_tag: pkg.version,
					max_buffer: 1024*1024*2
					// assets_dir: 'wp-assets'
				},
			}
		}

	});

	// load tasks
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-banner' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' ); // Copy template files from within the plugin - over to a /template/ directory in the plugin root.
	grunt.loadNpmTasks( 'grunt-postcss' ); // CSS autoprefixer plugin (cross-browser auto pre-fixes)
	grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-po2mo' );
	grunt.loadNpmTasks( 'grunt-text-replace' );
	grunt.loadNpmTasks( 'grunt-wp-deploy' );

	// register task
	grunt.registerTask( 'default', [
		'cssjanus',
		'uglify',
		'postcss',
		'cssmin',
		'usebanner',
		'copy:main'
	] );

	// register update-pot task
	grunt.registerTask( 'update-pot', [
		'makepot'
	] );

	// register deploy
	grunt.registerTask( 'deploy', [
		'copy:deploy',
		'wp_deploy'
	] );

	// register update-mo task
	grunt.registerTask( 'update-mo', [
		'po2mo'
	] );

	// register update-translations
	grunt.registerTask( 'update-translations', [
		'makepot',
		'po2mo'
	] );

	// register bump-version
	grunt.registerTask( 'bump-version', [
		'replace',
	] );

};
