<?php

namespace Drupal\entity_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * To use ontroller.
 */
class NodeValues extends ControllerBase {

  /**
   * Controller function.
   *
   * @return string
   *   The concatenated details.
   */
  public function fetchNode2() {
    $node_id = 2;
    $node = Node::load($node_id);
    // $details = '';
    if ($node) {
      $nodeTitle = $node->getTitle();

      $taxonomyValue = $node->get('field_taxonomy_term')->entity->getName();
      // $termName = $taxonomyValue['field_tax_t']['name'];
      $userField = $node->get('field_taxonomy_term')->entity;
      $userName = $userField->get('field_user_ref')->entity->getDisplayName();

      $details = "$nodeTitle . $taxonomyValue . $userName ";

      $build = [
        '#type' => 'markup',
        '#markup' => $details,
      ];
      return $build;
    }

  }

}
