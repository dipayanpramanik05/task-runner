/*
	Forty by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

(function($, Drupal) {
  $(window).on('load', function() {
    var elementCount = {div: $("div").length, span: $("span").length};
    console.table(elementCount);
  });
})(jQuery, Drupal);
