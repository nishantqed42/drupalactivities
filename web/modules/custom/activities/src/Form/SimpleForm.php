<?php

namespace Drupal\activities\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SimpleForm extends FormBase {
  public function getFormId() {
    return 'simple_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Store'),
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    if (strlen($name) < 4) {
       $form_state->setErrorByName('name', $this->t('Name should be more than 4 characters.'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('Name is : ' . $form_state->getValue('name'));
  }
}
