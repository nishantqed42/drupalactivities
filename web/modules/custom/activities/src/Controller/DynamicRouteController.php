<?php

namespace Drupal\activities\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A Staticpage controller.
 */
class DynamicRouteController extends ControllerBase {

  /**
   * Page callback function.
   *
   * @param string $arg
   *   Get an argument from url and display it on page.
   */
  public function content($arg) {
    $output = [
      '#markup' => 'Hello! I am your' . $arg . 'listing page.',
    ];
    return $output;
  }

}
