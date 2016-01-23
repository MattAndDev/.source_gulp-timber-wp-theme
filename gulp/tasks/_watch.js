'use strict';
/* Notes:
   - gulp/tasks/browserify.js handles js recompiling with watchify
   - watchers are made using `gulp-watch` so new files are automatically watched
*/

var gulp     = require('gulp');
var config   = require('../config');
var browserSync   = require('browser-sync');
var watch = require('gulp-watch');


gulp.task('watch', ['clean'], function() {
  runSequence('default', ['watchify','browserSync']);

  watch(config.svgSprite.src + '/' + config.svgSprite.glob, function(){
    runSequence('sprite');
  });

  watch(config.eslint.srcJs, function(){
    runSequence('eslint', 'jscs');
  });


  watch(config.sass.src, function(){
    runSequence('sass');
  });

  watch(config.images.src, function(){
    runSequence('images');
  });

  watch(config.fonts.src, function(){
    runSequence('fonts');
  });

  watch([config.templates.src], function(){
    runSequence('templates');
  });
  watch([config.code.src], function(){
    runSequence('code');
  });
  // Watchify will watch and recompile our JS, so no need to gulp.watch it
});
