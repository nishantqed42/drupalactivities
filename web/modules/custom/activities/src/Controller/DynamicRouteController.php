<?php

namespace Drupal\activities\Controller;

use Drupal\Core\Controller\ControllerBase;

/*
 * A Staticpage controller.
*/

class DynamicRouteController extends ControllerBase {
  public function content($arg) {
      $output = [
          '#markup' => $this->t('Hello! I am your ' . $arg . ' listing page.'),
      ];
      return $output;
      }
} 