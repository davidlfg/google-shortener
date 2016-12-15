<?php

/**
 * @file
 * Contains \Drupal\google_shortener\Form\GoogleShortenerSettingsForm
 */

namespace Drupal\google_shortener\Form;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Google Shortener Settings Form.
 */
class GoogleShortenerSettingsForm extends ConfigFormBase implements FormInterface {

 /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'google_shortener_settings_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('google_shortener.settings');
    $form = parent::buildForm($form, $form_state);
    $form['google_shortener_label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#description' => $this->t('Name label for the original url field'),
      '#attributes' => array(
          'placeholder' => $this->t('Add the name of the label'),
          'autofocus' => TRUE,
        ),
      '#default_value' => $config->get('google_shortener_label') ?: 'Simplify your links',
      '#required' => TRUE,
    );
    $form['google_shortener_placeholder'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder'),
      '#description' => $this->t('Text placeholder for the original url field'),
      '#attributes' => array(
          'placeholder' => $this->t('Add the text of the placeholder'),
          'autofocus' => TRUE,
        ),
      '#default_value' => $config->get('google_shortener_placeholder') ?: 'Your original URL here',
    );
    $form['google_shortener_description'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#description' => $this->t('Text description for the original url field'),
      '#attributes' => array(
          'placeholder' => $this->t('Add the text of the description'),
          'autofocus' => TRUE,
        ),
      '#default_value' => $config->get('google_shortener_description') ?: 'Your original URL here',
    );
    $form['google_shortener_submit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Submit'),
      '#description' => $this->t('Text for the original submit'),
      '#attributes' => array(
        'placeholder' => $this->t('Add the text of the submit'),
        'autofocus' => TRUE,
      ),
      '#default_value' => $config->get('google_shortener_submit') ?: 'Shorten URL',
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
    $properties = ['label', 'placeholder', 'description', 'submit', 'path_image'];
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
