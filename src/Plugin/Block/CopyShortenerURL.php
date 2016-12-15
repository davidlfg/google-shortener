<?php

namespace Drupal\google_shortener\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Controller\ControllerBase;

/**
 *
 * @Block(
 *   id = "google_copy_shortener",
 *   admin_label = @Translation("Copy Shortener URL"),
 *   category = @Translation("Custom")
 * )
 */
class CopyShortenerURL extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\google_shortener\Form\GoogleShortenerCopyURLForm');
  }
}
