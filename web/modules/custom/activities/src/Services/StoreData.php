<?php

namespace Drupal\activities\Services;

use Drupal\Core\Database\Connection;

class StoreData {
  protected $database;
  public function __construct(Connection $connection) {
    $this->database = $connection;
  }
  public function AddData(array $data) {
    if (db_table_exists('activity_data')) {
      $this->database->insert('activity_data')
      ->fields( array(
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'])
          )->execute();
      drupal_set_message('Data stored Successfully');
    }
  }

  Public function GetData() {
    $record = $this->database->select('activity_data')
              ->fields('activity_data',['first_name','last_name'])
              ->execute()->fetchAll();
    return end($record);
  }
}