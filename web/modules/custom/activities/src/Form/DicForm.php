<?php

namespace Drupal\activities\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\activities\Services\StoreData;

class DicForm extends FormBase {
  public function getFormId() {
    return 'dic_form';
  }
  public function __construct(StoreData $storedata) {
    $this->datastore = $storedata;
  }

  public static function create(ContainerInterface $container) {
    return new static(
    // Load the service required to construct this class.
      $container->get('activities.datastore')
    );
  }
  public function buildForm (array $form, FormStateInterface $form_state) {
    $record = $this->datastore->GetData();
    $first_name = empty($record->first_name) ? '' : $record->first_name;
    $last_name = empty($record->last_name) ? '': $record->last_name;
    
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => TRUE,
      '#default_value' => $first_name,
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#required' => TRUE,
      '#default_value' => $last_name,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $firstName = $form_state->getValue('first_name');
    $lastName = $form_state->getValue('last_name'); 
    if (!empty($firstName) && !empty($lastName)) {
      $data = [
        'first_name' => $firstName,
        'last_name' => $lastName,
      ];
      $this->datastore->AddData($data);
    }
  }
}