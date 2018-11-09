module.exports = function(grunt){
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		notify_hooks: {
			options: {
				enable: true,
				max_jshint_notifications: 5,
				title: "barrows_forrester",
				success: true
			}
		},

		watch: {
			sass: {
				files: ['assets/sass/*.scss'],
				tasks: ['sass', 'cssmin']
			},
			scripts: {
				files: ['assets/js/main.js'],
				tasks: ['concat']
			}
		},

		sass: {
			dist: {
				files: {
					'assets/css/style.css' : 'assets/sass/style.scss'
				}
			}
		},

		concat: {
			options: {
				seperator: ";",
				stripBanners: true,
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */'
			},
			dist: {
				src: ['assets/js/main.js', 'assets/js/alt.js'],
				dest: 'assets/js/<%= pkg.name %>-<%= pkg.version %>.min.js'
			}
		},

		uglify: {
			options: {
				manage: false,
				preserveComments: 'all'
			},
			my_target: {
				files: [{
					'assets/js/main.min.js': ['assets/js/main.js', 'assets/js/alt.js']
				}]
			}
		},

		cssmin: {
			my_target: {
				files: [{
					expand: true,
					cwd: 'assets/css/',
					src: ['*.css', '!*.min.css'],
					dest: 'assets/css/',
					ext: '.min.css'
				}]
			}
		}

	});

	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.registerTask('default', ["watch"]);

	grunt.task.run('notify_hooks');
};