/**
 * @file
 * Contains the definition of the behaviour copyShortener.
 */
(function($, Drupal, drupalSettings) {
  Drupal.behaviors.copyShortener = {
    attach: function (context, settings) {
      var short_url = drupalSettings.google_shortener.shortener.shorturl;
      console.log(short_url);
      $('.shortener-clipboard').click(function (event) {
        console.log('entro');
        var short_url = drupalSettings.google_shortener.shortener.shorturl;
        new Clipboard('.btn', {
          text: function(trigger) {
            return short_url;
          }
        });
      });

      new Clipboard('.btn', {
        text: function(trigger) {
          console.log('entro w');
          return short_url;
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
