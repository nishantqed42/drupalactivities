<?php

namespace Drupal\activities\Form;

use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

class FormStateExample extends FormBase {
  public function getFormID() {
    return 'form_state_example';
  }

  public function buildForm (array $form, FormStateInterface $form_state) {
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('First Name'),
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('Last name'),
    ];

    $form['qualification'] = [
      '#type' => 'select',
      '#title' => 'Qualifications',
      '#options' => [
        'ug' => 'Under Graduation',
        'pg' => 'Post Graduation',
        'other' => 'Other',
      ],
    ];

    $form['other'] = [
      '#type' => 'textfield',
      '#title' => t('Other Qualification Name'),
      '#states' => [
        'visible' => [
          ':input[name="qualification"]' => ['value' => 'other'],
        ],
      ],
    ];

    $form['country'] = [
      '#type' => 'select',
      '#title'=> t('Country'),
      '#options' => [
        'india' => 'India',
        'uk' => 'United Kingdom',
      ],
      '#empty_option' => 'Select Country',
      '#ajax' => [
        'event' => 'change',
        'callback' => '::changeStates',
        'wrapper' => 'states-wrapper',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Getting states...'),
        ],
      ],
    ];
    $selected_country = $form_state->getValue('country');
    $selected_country = isset($selected_country) ? $selected_country :  'india';
    $state_options = [
      'india' => [
        'gujrat' => 'Gujarat',
        'maharastra' => 'Maharastra',
      ],
      'uk' => [
        'scotland' => 'Scotland',
        'england' => 'England',
      ],
    ];
    $state_list = $state_options[$selected_country];
    $form['states'] = [
      '#type' => 'select',
      '#title' => t('States'),
      '#prefix' => '<div id="states-wrapper">',
      '#suffix' => '</div>',
      '#options' => $state_list,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    return $form;
  }

  public function changeStates(array &$form, FormStateInterface $form_state) {
    return $form['states'];
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $time = time();
    \Drupal::state()->set('drupal_activity_ajax_form_submission', $time);
    $submission_time = \Drupal::state()->get('drupal_activity_ajax_form_submission');
    drupal_set_message($this->t("submission time @submission_time", array('@submission_time' => date('d M Y H:m:s',$submission_time))));
  }
}