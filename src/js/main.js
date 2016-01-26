import $ from 'jquery';

// Shimmed feature js , aiting for npm module
import featurejs from 'featurejs';

// Enable inline svgs in IE
// import svg4everybody from 'svg4everybody';
// svg4everybody();

$(() => {

  // =======================================================
  // Frontend helpers
  // Init featurejs and set default touch/no-touc flag
  // =======================================================

  if (feature.touch) {
    $('html').addClass('touch');
  } else {
    $('html').addClass('no-touch');
  }
  // =======================================================

  // Code some awesome things

});
