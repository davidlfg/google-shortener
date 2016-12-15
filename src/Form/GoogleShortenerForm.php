<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Form\GoogleShortener
 */

namespace Drupal\google_shortener\Form;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\google_shortener\Plugin\ShortenerURL\GoogleUrlApi;

/**
 * Google Shortener URL form.
 */
class GoogleShortenerForm extends ConfigFormBase implements FormInterface {
  protected $shorten_url;
  protected $api_key;

 /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'shortener_url_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('google_shortener.settings');
    $this->api_key = $config->get('google_shortener_api_key');
    $form['#id'] = 'shortener-url-form';
    $form['large_url'] = array(
      '#type' => 'url',
      '#title' => $config->get('google_shortener_label') ?: 'Simplify your links',
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $config->get('google_shortener_description') ?: 'All goo.gl URLs and click analytics are public and can be accessed by anyone',
      '#weight' => 1,
      '#required' => TRUE,
      '#default_value' => 'https://glow.corp.globant.com/#/dashboard/embedded/myInformation.do',
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $config->get('google_shortener_submit') ?: $this->t('Shorten URL'),
      '#ajax' => [
        'callback' => '::getShortenerUrlCallback',
        'wrapper' => 'shortener-url-form',
      ],
      '#weight' => 3,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //Validate service google_shortener
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $g_url = new GoogleURLAPI($this->api_key);
    $large_url = $form_state->getValue('large_url');
    $this->shorten_url = $g_url->shorten($large_url);
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
    if ($form_state->getErrors())
      return $form;
    $form['#attached']['library'][] = 'google_shortener/drupal.clipboard_form';
    $form['#attached']['drupalSettings']['google_shortener']['shortener']['shorturl'] = 'bar';
    $form['short_url'] = [
      '#type' => 'item',
      '#markup' => '<span id="text-shortener">' . $this->shorten_url . '</span>',
      '#weight' => 2,
      '#field_suffix' => $this->t('<a href="#" class="button shortener-clipboard btn">Copy</a>'),//FIX
    ];
    $form['#attached']['library'][] = 'google_shortener/drupal.clipboard_form';
    $form['#attached']['drupalSettings']['google_shortener']['shortener']['shorturl'] = $this->shorten_url;
    return $form;
  }
}
