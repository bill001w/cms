﻿﻿/*global module:false*/
module.exports = function(grunt) {
	var myDate = new Date();
    var publishVersion = "v"+ myDate.getFullYear()+"-"+(myDate.getMonth()+1).toString()+"-"+myDate.getDate();

    /**
     *  合并文件的映射关系
     */

    var ued_conf = require("./page_list.js"),
        ued_concat = {},
        ued_trans = [],
        ued_cssTransArr = [],
        ued_cssTransObj = {},
        baseJsPath = "resources/js",
        baseCssPath = "resources/css",
        distPath = 'res/'+ publishVersion + '/';

    ued_concat[distPath + 'ued.import.js'] = ['ued.conf.js', 'ued.concat.js','import.js'];

    var ued_reqRce = {};
        // ued_reqRceList = {};

    for (var j in ued_conf) {
        var ASource = ued_conf[j];
        var BSource = [];
        BSource = BSource.concat(ASource);
        if (j.indexOf(".js") > -1) {
            for (var n=0; n<ASource.length; n++) {
                var An = ASource[n];
                ASource[n] = baseJsPath + "/" + An;
            }
            for (var p=0; p<BSource.length; p++) {
                BSource[p] = baseJsPath + "/" + BSource[p];
            }
        } else if (j.indexOf(".css") > -1) {
            for (var m=0; m<ASource.length; m++) {
                ASource[m] = baseCssPath + "/" + ASource[m];
            }
            for (var q=0; q<BSource.length; q++) {
                BSource[q] = baseCssPath + "/" + BSource[q];
            }
            ued_cssTransObj[distPath + j] = [distPath + j];
            ued_cssTransArr.push(distPath + j);
        }

        ued_conf[j] = BSource;
        ued_concat[distPath + j] = ASource;
        ued_trans.push(distPath + j);
        
    }

    // console.log(ued_cssTransArr);
       //console.log(ued_concat);
    // console.log(ued_trans);

    grunt.file.write('ued.concat.js', 'window.UED_publishTime ="'+ new Date().getTime() +'"; window.UED_Souce ='+ JSON.stringify(ued_conf) +';');
  

    /**
     *  压缩文件的映射关系
     */
    var ued_min = {};
    var ued_mincss = {};

    for (var i in ued_concat) {
        if ('ued.import.js' === i) {
            continue;
        }

        if (i.indexOf(".js") > -1) {
            ued_min[i.replace(".js", "-min.js")] = ['<banner:meta.banner>', i];
        } else if (i.indexOf(".css") > -1) {
            //ued_min[i] = ['<banner:meta.banner>', i];
            ued_mincss[i.replace(".css", "-min.css")] = [i];
        }
    }

    // 项目配置
    grunt.initConfig({
        //清除dist目录当前版本文件
        clean: {
            dist: ['res/'+publishVersion+'/'],
            more: ued_trans
        },

        //将css背景图片资源复制到dist中
        copy: {
            cssimg: {
                expand: true,
                cwd: 'resources/imgs',
                src: '**',
              //  dest: 'res/'+publishVersion+'/imgs'
                  dest: 'res/imgs'
            },
			webfont: {
                expand: true,
                cwd: 'resources/fonts',
                src: '**',
                dest: 'res/fonts'
            },
            webicon: {
                expand: true,
                cwd: 'resources/icon',
                src: '**',
                dest: 'res/icon'
            }
        },
        
        //将require中的js文件输出到1个文件
        requirejs: ued_reqRce,

        //将css, js合并
        concat: ued_concat,

        qunit: {
            files: ['test/**/*.html']
        },

        watch: {
            files: '<config:lint.files>',
            tasks: 'lint qunit'
        },

        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                boss: true,
                eqnull: true,
                browser: true,
                force: true
            },
            globals: {
                jQuery: true
            }
        },

        //压缩js
        uglify: {
            my_target: {
                files: ued_min
            }
        },
        //css检查
        csslint: {
            options: {
                csslintrc: 'css/.csslintrc'
            },
            src: "css/*.css"
        },
        //梳理css
        csscomb: {
            dist: {
                options: {
                    config: 'css/.csscomb.json'
                },
                files: ued_cssTransObj
            }
        },
        //压缩css
        cssmin: {
            compress: {
                files: ued_mincss
            }
        }
    });

    // 加载所有依赖插件
    require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

    // 默认任务
    grunt.registerTask('dist-copy', ['clean:dist', 'copy']);
    grunt.registerTask('dist-clean', ['clean:more']);
    grunt.registerTask('css-check', ['csslint']);
    grunt.registerTask('dist-css', ['concat', 'cssmin', 'dist-clean']);
    grunt.registerTask('dist-js', [/*'requirejs',*/ 'concat', 'uglify', 'dist-clean']);
    grunt.registerTask('default', ['dist-clean', 'dist-copy', 'dist-js' , 'dist-css']);

    /*grunt.registerTask("makeui", "build ui moudle", function() {
        var filepath = "js/toolbar.htm";
        var code = grunt.file.read(filepath);
        code = code.replace(/\r|\n|\s{2,}/g, "");
        grunt.file.write("js/toolbar.tmpl.js", "YiQiGuang.ToolbarTmpl = '"+ code + "';");
        grunt.log.writeln("toolbar ui build success!");
    });*/
};
