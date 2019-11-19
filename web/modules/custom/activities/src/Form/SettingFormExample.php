<?php

namespace Drupal\activities\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingFormExample extends ConfigFormBase {
  const SETTINGS = 'activities.settings';

  public function getFormId() {
    return 'setting_form_example';
  }

  public function defaultConfiguration() {
    $default_config = \Drupal::config('activities.settings');
    return [
      'appid_config' => $default_config->get('appid_config'),
    ];
  }
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['app_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('App ID'),
      '#default_value' => $this->defaultConfiguration(),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitform(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
    ->set('appid_config', $form_state->getValue('app_id'))
    ->save();
    parent::submitForm($form, $form_state);
  }
}


