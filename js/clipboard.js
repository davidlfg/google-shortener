(function($, Drupal, drupalSettings) {
  Drupal.behaviors.yourbehavior = {
    attach: function (context, settings) {
      $('.shortener-clipboard').click(function (event) {
        console.log($('.text-shortener').text());
      });
    }
  };
})(jQuery, Drupal, drupalSettings);