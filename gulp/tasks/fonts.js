'use strict';

var gulp = require('gulp');
var config = require('../config').fonts;
var browserSync = require('browser-sync');
var handleErrors = require('../util/handleErrors');

gulp.task('fonts', function() {
  return gulp.src(config.src)
    .on('error', handleErrors)
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.reload({stream:true}));
});
