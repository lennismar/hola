module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: {
                    'assets/js/<%= pkg.name %>.min.js': [

                        'assets/js/vendors/lodash.core.js',
                        'assets/js/vendors/select2.js',
                        'assets/js/vendors/owl.carousel.js',
                        'assets/js/vendors/fotorama.js',
                        'assets/js/vendors/dropdown.js',
                        'assets/js/vendors/background.cycle.js',

                        'assets/js/vendors/nav-responsive.js',
                        'assets/js/vendors/hide-extra-content.js',
                        'assets/js/vendors/venobox.min.js',
                        'assets/js/vendors/jquery.tooltipster.min.js',
                        'assets/js/vendors/jquery.sticky-kit.min.js',

                        'assets/js/vendors/jquery.validate.min.js',
                        'assets/js/dop-prototypes.js',
                        'assets/js/init.js',

                    ]
                }
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Default task(s).
    grunt.registerTask('default', ['uglify']);

};