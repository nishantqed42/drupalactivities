<?php

namespace Drupal\activities\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * An example of entity based dynamic route.
 */
class EntityDynamicRouteController extends ControllerBase {

  /**
   * Display node information.
   *
   * @param nodeInterface $nodeinfo
   *   Node object get node id from url.
   */
  public function content(nodeInterface $nodeinfo) {
    $nodeinfo = node_view($nodeinfo, $view_mode = 'full', $langcode = NULL);
    return $nodeinfo;
  }

  public function access(AccountInterface $account, nodeInterface $nodeinfo) {
    $nodeAuthor = $nodeinfo->getOwnerId();
    $currentUserId = $account->id();
    return AccessResult::allowedIf($nodeAuthor == $currentUserId);
  }
  /**
   * Display node information.
   *
   * @param nodeInterface $nodeinfo1
   *   Node object get node id from url.
   * @param nodeInterface $nodeinfo2
   *   Node object get node id from url.
   */
  public function multiplenodes(nodeInterface $nodeinfo1, nodeInterface $nodeinfo2) {
    $entityType = 'node';
    $view_mode = 'teaser';
    $nodes = [
      $nodeinfo1,
      $nodeinfo2,
    ];

    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entityType);
    $build = $view_builder->viewMultiple($nodes, $view_mode);
    $output = [
      '#markup' => render($build),
    ];

    return $output;
  }

}
