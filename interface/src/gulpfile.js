/**
 * by theWhK - 2018
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    stylus = require('gulp-stylus');

gulp.task('style', function () {
    gulp
        .src('./assets/css/main.styl')
        .pipe(stylus({
            compress: true
        }))
        .pipe(concat('main.css'))
        .pipe(gulp.dest('./assets/css/'));
});

gulp.task('watch', function () {
    gulp.watch(
        ['./assets/css/**/*.{styl,css}'], 
        ['style']);
});

gulp.task('default', ['style']);