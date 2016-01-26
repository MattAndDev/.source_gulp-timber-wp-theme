'use strict';

var path = require('path');

function distName() {
  var folder = path.dirname(__dirname);
  folder = path.basename(folder);
  return folder.replace('.source_', '');
}

var folderName = distName();
var dest = './../'+ folderName;
var src = './src';
var server = 'domain.dev'


module.exports = {


  destFolder: dest,



  // ==============================
  // browserify.js settings
  // ==============================


  browserify: {
    // A separate bundle will be generated for each
    // bundle config in the list below
    bundleConfigs: [{
      entries: src + '/js/main.js',
      dest: dest + '/js',
      outputName: 'main.js',
      // Additional file extentions to make optional
      extensions: ['.js'],
      // list of modules to make require-able externally
      require: ['jquery']
      // old: require: ['jquery', 'backbone/node_modules/underscore']
      // See https://github.com/greypants/gulp-starter/issues/87 for note about
      // why this is 'backbone/node_modules/underscore' and not 'underscore'
    // }, {
    //   entries: src + '/javascript/page.js',
    //   dest: dest + '/js',
    //   outputName: 'page.js',
    //   // list of externally available modules to exclude from the bundle
    //   external: ['jquery', 'underscore']
    }]
  },


  // ==============================
  // browserSync.js settings
  // ==============================

  browserSync: {
    proxy: server,
    files: [
      dest + '/css/*',
      dest + '/js/*',
      dest + '*.php',
      dest + '*.twig',
    ]
  },

  code: {
    src: src + '/code/**',
    dest: dest + '/'
  },


  fonts: {
    src: src + '/fonts/**',
    dest: dest + '/fonts'
  },



  // ==============================
  // images.js settings
  // ==============================

  images: {
    src: src + "/images/**",
    dest: dest + "/images",

    // gulp-imagemin settings

    settings: {
    }
  },


  // ==============================
  // jslint.js settings
  // ==============================

  eslint: {
    srcJs: src + '/js/**/*.js'
  },



  // ==============================
  // markup.js settings
  // ==============================

  templates: {
    src: src + "/templates/**/**",
    dest: dest + "/",

    // gulp-file-include settings

    settings: {
      basepath: src + '/html/includes/',
      prefix : '@@'
    }
  },


  // ==============================
  // _production.js settings
  // ==============================


  production: {
    cssSrc: dest + '/css/*.css',
    jsSrc: dest + '/js/*.js',
    dest: dest,
    cssDest: dest + '/',
    jsDest: dest + '/js'
  },


  // ==============================
  // sass.js settings
  // ==============================

  sass: {
    src: src + "/sass/**/*.{sass,scss}",
    dest: dest + '/',

    // gulp-autoprefixer settings

    prefix: [
      'ie >= 9',
      'ie_mob >= 10',
      'ff >= 30',
      'chrome >= 34',
      'safari >= 7',
      'opera >= 23',
      'ios >= 7',
      'android >= 4.4',
      'bb >= 10'
    ],

    // gulp-sass settings

    settings: {
      indentedSyntax: true, // Enable .sass syntax!
      imagePath: 'images' // Used by the image-url helper
    }
  },

  // ==============================
  // sprite.js settings
  // ==============================


  svgSprite: {
    type: 'inline', // 'inline'
    src: src + '/icons',
    glob: '**/*.svg',
    dest: dest + '/images',
    removeFills: true,
    optionsInline: {
      shape: {
        id: {
          generator: 'i-%s'
        }
      },
      mode: {
        symbol: {
          sprite: 'sprite.svg',
          dest: '.',
          render: {
            scss: {
              template: 'gulp/tpl/_sprite-inline.scss',
              dest: '../../.source_'+folderName+'/src/sass/_sprite.scss'
            }
          }
        }
      }
    },
    optionsBackground: {
      mode: {
        css: {
          layout: 'horizontal',
          sprite: 'sprite.svg',
          dest: '.',
          render: {
            scss: {
              template: 'gulp/tpl/_sprite-background.scss',
              dest: '../../.source_'+folderName+'/src/sass/_sprite.scss'
            }
          }
        }
      },
      variables: {
        cssPath: '../images/'
      }
    }
  }


};
