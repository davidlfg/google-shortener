<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Services\Shortener
 */

namespace Drupal\google_shortener\Services;

/**
 * Google Shortener URL API.
 */
class Shortener {
  public function getSay($count) {
    return str_repeat('Drupaleros ', $count);
  }
}
