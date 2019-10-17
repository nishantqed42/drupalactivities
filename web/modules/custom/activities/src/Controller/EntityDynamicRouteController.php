<?php

namespace Drupal\activities\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

/*
 * An example of entity based dynamic route.
*/
class EntityDynamicRouteController extends ControllerBase {
  public function content(NodeInterface $nodeinfo) {
    print_r($nodeinfo);
    exit;
    $output = [
        '#markup' => $this->t('Hello! I am your listing page.'),
    ];
    return $output;
  }
} 