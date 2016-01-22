'use strict';

var gulp      = require('gulp');
var config    = require('../config').production;
var minifyCSS = require('gulp-cssnano');
var size      = require('gulp-filesize');

gulp.task('minifyCss', ['sass'], function() {
  return gulp.src(config.cssSrc)
    .pipe(minifyCSS())
    .pipe(gulp.dest(config.cssDest))
    .pipe(size());
});
