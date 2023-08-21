<?php

declare(strict_types = 1);

namespace Drupal\fifteen_hook_operations\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for Fifteen hook operations routes.
 */
final class FifteenHookOperationsController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function title(Node $node) {

    $build['content'] = [
      '#markup' => $node->getTitle(),
    ];

    return $build;
  }

}
