<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Form\GoogleShortener
 */

namespace Drupal\google_shortener\Form;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\google_shortener\Plugin\ShortenerURL\GoogleUrlApi;

/**
 * Google Shortener URL form.
 */
class GoogleShortenerCopyURLForm extends ConfigFormBase implements FormInterface {
  protected $shorten_url;
  protected $large_url;
  protected $api_key;

 /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'shortener_copy_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('google_shortener.settings');
    $this->api_key = $config->get('google_shortener_api_key');
    $form['#id'] = 'shortener-copy-form';
    $form['short_url'] = [
      '#type' => 'button',
      '#value' => $this->t('Copy'),
      '#ajax' => ['callback' => [$this, 'getShortenerUrlCallback']],
      '#attributes' => array(
        'class' => array('shortener-clipboard btn'),
      ),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //Validate service google_shortener
    global $base_url;
    $currentPath = Url::fromRoute('<current>')->getInternalPath();
    $g_url = new GoogleURLAPI($this->api_key);
    $this->large_url = $base_url . '/' . $currentPath;
    $this->shorten_url = $g_url->shorten($this->large_url);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['google_shortener.settings'];
  }

  /**
   * Function productoCallback
   * @return $form producto by clase
   */
  public function getShortenerUrlCallback(array &$form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = 'google_shortener/drupal.clipboard_form';
    $form['#attached']['drupalSettings']['google_shortener']['shortener']['shorturl'] = $this->shorten_url;
    return $form;
  }
}
