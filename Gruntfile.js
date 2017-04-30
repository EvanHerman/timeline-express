/**
 * Gruntfile.js Controls
 *
 * @author Code Parrots <support@codeparrots.com>
 * @since 1.0.0
 */
module.exports = function( grunt ) {

	'use strict';

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig( {

		pkg: pkg,

		uglify: {
			dist: {
				files: {
					'lib/admin/js/min/timeline-express-admin.min.js': [
						'lib/admin/js/bootstrap-select.js',
						'lib/admin/js/script.options-color-picker-custom.js'
					],
					'lib/admin/js/min/timeline-express-tinymce.min.js': [
						'lib/admin/js/timeline-express-button-script.js'
					],
					'lib/public/js/min/timeline-express.min.js': [
						'lib/public/js/timeline-express.js'
					]
				}
			}
		},

		postcss: {
			options: {
				map: true,
				processors: [
					require( 'autoprefixer-core' ) ( {
						browsers: [ 'last 2 versions' ]
					} )
				]
			},
			dist: {
				src: [ 'lib/admin/css/*.css', 'lib/public/css/*.css' ]
			}
		},

		cssmin: {
			target: {
				files: [
					{
						'lib/admin/css/min/timeline-express-admin.min.css':
						[
							'lib/admin/css/timeline-express-settings.css',
							'lib/admin/css/timeline-express-welcome.css',
							'lib/admin/css/timeline-express-addons.css'
						]
					},
					{
						'lib/admin/css/min/timeline-express-admin-rtl.min.css':
						[
							'lib/admin/css/timeline-express-settings-rtl.css',
							'lib/admin/css/timeline-express-welcome-rtl.css',
							'lib/admin/css/timeline-express-addons-rtl.css'
						]
					},
					{
						'lib/public/css/min/timeline-express.min.css':
						[
							'lib/public/css/timeline-express.css',
							'lib/public/css/timeline-express-single-page.css'
						]
					},
					{
						'lib/public/css/min/timeline-express-rtl.min.css':
						[
							'lib/public/css/timeline-express-rtl.css',
							'lib/public/css/timeline-express-single-page.css',
							'lib/public/css/timeline-express-single-page-rtl.css'
						]
					}
				]
			}
		},

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
						'lib/admin/js/min/timeline-express-admin.min.js'
					]
				}
			}
		},

		copy: {
			main: {
				files: [
					{
						expand: true,
						flatten: true,
						src: [ 'lib/public/partials/*.php' ],
						dest: 'templates/',
						filter: 'isFile'
					}
				]
			},
			deploy: {
				files: [
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
						dest: 'build/timeline-express/'
					}
				]
			}
		},

		watch: {
			admin_css: {
				files: [ 'lib/admin/css/*.css, ! lib/admin/css/*.min.css' ],
				tasks: [ 'watch-banner' ],
				options: {
					spawn: false,
					event: [ 'all' ]
				}
			},
			admin_js: {
				files: [ 'lib/admin/js/*.js', 'lib/admin/js/*.min.js' ],
				tasks: [ 'watch-banner' ],
				options: {
					spawn: false,
					event: [ 'all' ]
				}
			},
			public_css: {
				files: [ 'lib/public/css/*.css', '! lib/public/css/*.min.css' ],
				tasks: [ 'watch-banner' ],
				options: {
					spawn: false,
					event: [ 'all' ]
				}
			},
			public_js: {
				files: [ 'lib/public/js/*.js', '! lib/public/js/*.min.js' ],
				tasks: [ 'watch-banner' ],
				options: {
					spawn: false,
					event: [ 'all' ]
				}
			}
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
						pot.headers[ 'report-msgid-bugs-to' ] = pkg.bugs.url;
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

		bump: {
			options: {
				files: [ 'package.json' ],
				updateConfigs: [],
				commit: false,
				createTag: false,
				push: false,
				globalReplace: false,
				prereleaseName: false,
				metadata: '',
				regExp: false
			}
		},

		prompt: {
			bump: {
				options: {
					questions: [
						{
							config:  'bump.increment',
							type:    'list',
							message: 'Bump version from <%= pkg.version %> to:',
							choices: [
								{
									value: 'patch',
									name:  'Patch:  Patch Release eg: 1.0.0 => 1.0.1'
								},
								{
									value: 'minor',
									name:  'Minor:  Minor Release eg: 1.0.3 => 1.1.0'
								},
								{
									value: 'major',
									name:  'Major:  Major Release eg: 1.1.0 => 2.0.0'
								},
								{
									value: 'custom',
									name:  'Custom: Specify Version'
								}
							]
						},
						{
							config:   'bump.custom_version',
							type:     'input',
							message:  'What specific version would you like',
							when:     function ( answers ) {
								return answers[ 'bump.increment' ] === 'custom';
							}
						}
					],
					then: function( results ) {
						if ( results[ 'bump.increment' ] === 'patch' ) {
							grunt.task.run( [ 'shell:bump_patch' ] );
						} else if( results[ 'bump.increment' ] === 'minor' ) {
							grunt.task.run( [ 'shell:bump_minor' ] );
						} else if( results[ 'bump.increment' ] === 'major' ) {
							grunt.task.run( [ 'shell:bump_major' ] );
						} else if( results[ 'bump.increment' ] === 'custom' ) {
							grunt.task.run( [ 'shell:bump_custom' ] );
						}
						grunt.task.run( [ 'shell:bump' ] );
					}
				}
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
				replacements: [
				{
					from: /Stable tag: (.*)/,
					to: "Stable tag: <%= pkg.version %>"
				},
				{
					from: /Tested up to: (.*)/,
					to: "Tested up to: <%= pkg.tested_up_to %>"
				}
			]
			},
			readme_md: {
				src: [ 'README.md' ],
				overwrite: true,
				replacements: [
					{
						from: /# Timeline Express - (.*)/,
						to: "# Timeline Express - <%= pkg.version %>"
					},
					{
						from: /\*\*Stable tag:\*\* {8}(.*)/,
						to: "\**Stable tag:**        <%= pkg.version %> <br />"
					},
					{
						from: /\*\*Tested up to:\*\* {6}WordPress v(.*)/,
						to: "\**Tested up to:**      WordPress v<%= pkg.tested_up_to %> <br />"
					}
				]
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

		shell: {
			bump_patch: [
				'grunt bump:patch'
			].join( ' && ' ),
			bump_minor: [
				'grunt bump:minor'
			].join( ' && ' ),
			bump_major: [
				'grunt bump:major'
			].join( ' && ' ),
			bump_custom: [
				'grunt bump --setversion=<%= bump.custom_version %>'
			].join( ' && ' ),
			bump: [
				'grunt replace',
				'grunt cssmin',
				'grunt uglify',
				'grunt usebanner'
			].join( ' && ' )
		},

		wp_deploy: {
			deploy: {
				options: {
					plugin_slug: 'timeline-express',
					build_dir: 'build/timeline-express/',
					deploy_trunk: true,
					deploy_tag: pkg.version,
					max_buffer: 1024*1024*10
				}
			}
		},

		clean: {
			build: [ 'build/*' ]
		},

		compress: {
				main: {
						options: {
								archive: 'build/timeline-express-v<%= pkg.version %>.zip'
						},
						files: [ {
							cwd: 'build/timeline-express/',
							dest: 'timeline-express',
							src: [ '**' ]
						} ]
				}
		}

	} );

	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-banner' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-po2mo' );
	grunt.loadNpmTasks( 'grunt-prompt' );
	grunt.loadNpmTasks( 'grunt-shell' );
	grunt.loadNpmTasks( 'grunt-bump' );
	grunt.loadNpmTasks( 'grunt-text-replace' );
	grunt.loadNpmTasks( 'grunt-wp-deploy' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-menu' );

	grunt.registerTask( 'default', [ 'menu' ] );

	grunt.registerTask( 'Run all development tasks.', [
		'cssjanus',
		'uglify',
		'postcss',
		'cssmin',
		'usebanner',
		'copy:main'
	] );

	grunt.registerTask( 'Watch files for changes.', [
		'watch'
	] );

	grunt.registerTask( 'watch-banner', 'Run minify/uglify/banner.', [
		'uglify',
		'postcss',
		'cssjanus',
		'cssmin',
		'usebanner'
	] );

	grunt.registerTask( 'Update tempalte files.', [
		'copy:main'
	] );

	grunt.registerTask( 'Build the plugin into the /build/ directory.', [
		'clean:build',
		'copy:deploy',
		'compress'
	] );

	grunt.registerTask( 'Bump the verison of Timeline Express to the next release.', [
		'prompt'
	] );

	grunt.registerTask( 'Generate a .pot translation file.', [
		'makepot'
	] );

	grunt.registerTask( 'Convert .po to .mo files.', [
		'po2mo'
	] );

	grunt.registerTask( 'Update the Timeline Express translation files.', [
		'makepot',
		'po2mo'
	] );

	grunt.registerTask( 'Deploy Timeline Express to the WordPress.org repository.', [
		'copy:deploy',
		'wp_deploy'
	] );

	grunt.registerTask( 'Bump the version throughout from package.json.', [
		'replace'
	] );

};
