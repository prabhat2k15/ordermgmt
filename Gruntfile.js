/**
 * Description
 * @method exports
 * @param {} grunt
 * @return
 */
module.exports = function (grunt) {

    var pkg = grunt.file.readJSON('package.json');
    // Project configuration.
    grunt.initConfig({
        pkg: pkg,
        uglify: {
            options: {
                compress: true,
                mangle: true,
                beautify: false,
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            }
        },
        watch: {
            css: {
                files: [
                    'dist/css/**/*.css'
                ],
                options: {
                    livereload: true
                }
            },
            sass: {
                files: [
                    'src/**/*.scss'
                ],
                tasks: ['sass:dist'],
                options: {
                    livereload: false
                }
            },
            modulejson: {
                files: ['src/**/module.json'],
                tasks: ['scan']
            }
        },
        bootloader: {
            options: {
                projectPrefix: "pichku-service", //packages with this prefic will have preferences, it tells me that `myapp` needs to be bundeled first
                sort: false,
                indexBundles: ["webmodules/bootloader", "pichku-service/app"],
                src: "./",
                dest: "dist",
                resourceJson: "dist/resource.json",
                resourcesInline: true,
                livereloadUrl: "http://localhost:35729/livereload.js",
                bootServer: {
                    port: 8080,
                    indexMatch: /^\/pichku-service\// //URLs to be used to render index.html
                }
            }
        },
        jsbeautifier: {
            files: ["src/**/*.js", "!src/external/components/**/*.js"],
            options: {
                config: ".jsbeautifyrc"
            }
        },
        jshint: {
            files: ["src/**/*.js", "!src/external//**/*.js"],
            options: {
                jshintrc: true,
                reporterOutput: ""
            }
        },
        sass: {
            options: {
                sourceMap: false,
                outputStyle: 'nested',
                sourceComments: false
            },
            dist: {
                files: {
                    'dist/css/style/main.css': 'src/style/main.scss',
                    'dist/css/external/public.css': 'src/external/public.scss'
                }
            }
        },
        cssmin: {
            options: {
                target: "/",
                advanced: true,
                keepSpecialComments: 0,
                rebase: true
            },
            target: {
                files: {
                    'dist/css/bootstrap.css': [
                        "src/external/components/bootstrap/dist/css/bootstrap.min.css",
                        "src/external/components/bootstrap/dist/css/bootstrap-theme.min.css",
                        "src/external/components/bootswatch/paper/bootstrap.min.css"
                    ],
                    'dist/css/style.css': [
                        "src/external/components/font-awesome/css/font-awesome.min.css",
                        "src/external/components/animate.css/animate.min.css",
                        'dist/css/external/public.css',
                        'dist/css/style/main.css'

                    ]
                }
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-jsbeautifier');
    //grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-gitinfo');
    grunt.loadNpmTasks('grunt-bootloader');

    // task(s).
    grunt.registerTask('check', ["jshint"]);
    grunt.registerTask('buildcss', ['sass', 'cssmin']);
    grunt.registerTask('scan', ['bootloader:scan:skip', 'buildcss']);
    grunt.registerTask('build', ['gitinfo', 'buildcss', 'bootloader:bundlify']);
    grunt.registerTask('boot', ['scan', 'bootloader:server', 'watch']);
    grunt.registerTask('default', ['check', 'scan']);

};