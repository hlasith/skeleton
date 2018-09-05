'use strict';
module.exports = function (grunt) {

    // show elapsed time at the end
    require('time-grunt')(grunt);

    // load all grunt tasks
    require('load-grunt-tasks')(grunt);

    // configurable paths
    var dirConfig = {
        assets: '../assets'
    };

    grunt.initConfig({
        directory: dirConfig,

        /**********************************************************************************************************/
        /*    watch jobs - running during development                                                             */
        /**********************************************************************************************************/
        watch: {
            sass: {
                files: [
                    '<%= directory.assets %>/scss/*.scss'
                ],
                tasks: ['sass']
            }
        },

        /**********************************************************************************************************/
        /*     clean job  - remove old files                                                                      */
        /**********************************************************************************************************/
        clean: {
            first: [
                "css/styles.*.css",
                "js/*-min.js"
            ]
        },

        /**********************************************************************************************************/
        /*    Sass job to build css                                                                               */
        /**********************************************************************************************************/
        sass: {
            sourceMapSimple: {
                options: {
                    sourceMap: false
                },
                files: {
                    'css/styles.css': '<%= directory.assets %>/scss/ngl_pro_main.scss',
                    'css/styles-content.css': '<%= directory.assets %>/scss/index.scss'
                }
            }
        },

        /**********************************************************************************************************/
        /*     cssmin job                                                                                         */
        /**********************************************************************************************************/
        cssmin: {
            production: {
                options: {
                    shorthandCompacting: false,
                    roundingPrecision: -1
                },
                files: [{
                    expand: true,
                    src: 'css/styles.css',
                    dest: ''
                }]
            }
        },

        /**********************************************************************************************************/
        /*     require js job - compile files together into 1 min.js file                                         */
        /**********************************************************************************************************/
        requirejs: {
            compile: {
                options: {
                    baseUrl: "js",
                    mainConfigFile: "js/main.js",
                    include: [
                        '../node_modules/requirejs/require',
                        'ngl'
                    ],
                    findNestedDependencies: true,
                    exclude: [
                        // nothing to exclude because its the standalone version
                    ],
                    optimizeCss: "standard",
                    out: "js/ngl-min.js"
                }
            }
        },

        /**********************************************************************************************************/
        /*     Rev job                                                                                            */
        /**********************************************************************************************************/
        rev: {
            options: {
                encoding: 'utf8',
                algorithm: 'md5',
                length: 8
            },
            js: {
                files: [{
                    src: [
                        'js/ngl-min.js'
                    ]
                }]
            },
            css: {
                files: [{
                    src: [
                        'css/styles.css',
                        'css/styles-content.css'
                    ]
                }]
            }
        },

        cacheBust: {
            options: {
                assets: ['static/node_modules/ngl-ui-kit/**/images/**'],
                baseDir: '../'
            },
            taskName: {
                files: [{
                    expand: true,
                    cwd: '../',
                    src: ['../app/Resources/views/**/*.html.php']
                }]
            }
        }

    });

    /**********************************************************************************************************/
    /*     HELPER TASKS FOR DEVELOPMENT                                                                       */
    /**********************************************************************************************************/

    grunt.registerTask('css-sass', [
        'sass'
    ]);

    /**********************************************************************************************************/
    /*     TASKS FOR DEVELOPMENT AND PRODUCTION                                                               */
    /**********************************************************************************************************/

    grunt.registerTask('default', [
        'clean:first',
        'sass',
        'watch'
    ]);

    grunt.registerTask('build-production', [
        'clean:first',
        'sass',
        'requirejs',
        'rev:js',
        'cssmin',
        'rev:css',
        'cacheBust'
    ]);

};