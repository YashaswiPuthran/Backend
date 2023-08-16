<?php

namespace Drupal\entity_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * To include Reference Entity.
 */
class RefNode extends ControllerBase {

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

      $taxonomy = $node->get('field_taxonomy_term')->referencedEntities();
      $taxonomyTerm = reset($taxonomy);
      $term = $taxonomyTerm->getName();

      $username = $taxonomyTerm->get('field_user_ref')->referencedEntities();
      $userTerm = reset($username);
      $name = $userTerm->getDisplayName();

      $details = "$nodeTitle . $term . $name ";

      $build = [
        '#type' => 'markup',
        '#markup' => "$details",
      ];
      return $build;
    }

  }

}
