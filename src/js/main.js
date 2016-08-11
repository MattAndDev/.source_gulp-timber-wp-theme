import $ from 'jquery';

// Shimmed feature js , aiting for npm module
import featurejs from 'featurejs';

// Class import
import MyClass from './classes/MyClass';

// Enable inline svgs in IE
// import svg4everybody from 'svg4everybody';
// svg4everybody();

$(() => {

  // =======================================================
  // Frontend helpers
  // Init featurejs and set default touch/no-touc flag
  // =======================================================

  if (feature.touch) {
    let inst = new MyClass();
    $('html').addClass('touch');
  } else {
    $('html').addClass('no-touch');
  }

  let inst = new MyClass()
  // =======================================================

  // Code some awesome things

});
