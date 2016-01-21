'use strict';

var gulp = require('gulp');
var changed = require('gulp-changed');
var flatten = require('gulp-flatten');
var config = require('../config').templates;
var browserSync  = require('browser-sync');

gulp.task('templates', function() {
  return gulp.src(config.src)
    .pipe(changed(config.dest))
    .pipe(flatten())
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.reload({stream:true}));
});
