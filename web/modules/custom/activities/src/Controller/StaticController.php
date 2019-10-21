<?php

namespace Drupal\activities\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A Staticpage controller.
 */
class StaticController extends ControllerBase {

  /**
   * Page callback function.
   */
  public function content() {
    $output = [
      '#markup' => $this->t('Hello! I am your node listing page.'),
    ];
    return $output;
  }

}
