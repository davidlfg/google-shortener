<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Form\GoogleShortenerCredentialsForm
 */

namespace Drupal\google_shortener\Form;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Google Shortener Credentials Form.
 */
class GoogleShortenerCredentialsForm extends ConfigFormBase implements FormInterface {

 /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'google_shortener_credentials_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('google_shortener.settings');
    $form = parent::buildForm($form, $form_state);
    $form['google_shortener_api_key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('API key'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Acquiring and using an API key. Go to the <a href="https://console.developers.google.com/" target="_blank">Google Developers Console</a>'),
      '#default_value' => $config->get('google_shortener_api_key') ?: '',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('google_shortener.settings');
    $properties = ['google_shortener_api_key'];
    array_walk($properties, function ($property) use ($config, $form_state) {
      $config->set($property, $form_state->getValue($property));
    });
    $config->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['google_shortener.settings'];
  }
}
