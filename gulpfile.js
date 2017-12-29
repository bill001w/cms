var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    cssmin = require('gulp-minify-css'),
    del = require('del'),
    jshint = require("gulp-jshint"),
    runSequence = require('gulp-sequence'),
    autoprefixer = require('gulp-autoprefixer');

var myDate = new Date();
var publishVersion = "v" + myDate.getFullYear() + "-" + (myDate.getMonth() + 1).toString() + "-" + myDate.getDate();
var basePath = './resources/';
var distPath = './res/';

var ued_conf = require("./page_list.js");

gulp.task('clean', function () {
    return del([
        distPath + '**/*'
    ]);
});

gulp.task('build-js-and-css', function () {
    for (var i in ued_conf) {
        if (i.indexOf('.js') !== -1) {
            gulp.src(ued_conf[i].map(function (v) {
                return basePath + 'js/' + v;
            }))
                .pipe(concat(i))
                .pipe(jshint())
                .pipe(uglify())
                .pipe(rename({suffix: '-min'}))
                .pipe(gulp.dest(distPath + publishVersion + '/'));
        }

        if (i.indexOf('.css') !== -1) {
            gulp.src(ued_conf[i].map(function (v) {
                return basePath + 'css/' + v;
            }))
                .pipe(concat(i))
                .pipe(cssmin())
                .pipe(rename({suffix: '-min'}))
                .pipe(gulp.dest(distPath + publishVersion + '/'));
        }
    }

    gulp.src(['./ued.conf.js', './ued.concat.js', './import.js'])
        .pipe(concat('ued.import.js'))
        .pipe(gulp.dest(distPath + publishVersion + '/'))
        .pipe(uglify())
        .pipe(rename({suffix: '-min'}))
        .pipe(gulp.dest(distPath + publishVersion + '/'));
});

gulp.task('copy', function () {
    gulp.src(basePath + 'imgs/**/*')
        .pipe(gulp.dest(distPath + 'imgs/'));

    gulp.src(basePath + 'fonts/**/*')
        .pipe(gulp.dest(distPath + 'fonts/'));

    gulp.src(basePath + 'icon/**/*')
        .pipe(gulp.dest(distPath + 'icon/'));

    gulp.src(basePath + 'templates/**/*')
        .pipe(gulp.dest(distPath + 'templates/'));

    gulp.src(basePath + 'html/**/*')
        .pipe(gulp.dest(distPath + 'html/'));
});

gulp.task('default', ['clean'], function (cb) {
    runSequence('build-js-and-css', 'copy')(cb);
});



