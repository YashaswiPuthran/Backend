<?php

namespace Drupal\sixteen_cache_module\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Controller for handling tasks related to ControllerTask module.
 */
class CacheController extends ControllerBase {

  /**
   * Comment.
   */
  public function task() {
    $nid = 100;
    $cid = 'marktwo:' . $nid;

    // Look for item in cache so we don't have to do work if we don't need to.
    if ($item = \Drupal::cache()->get($cid)) {
      return $item->data;
    }

    // Build up the marktwodown array we're going to use later.
    $node = Node::load($nid);
    $marktwo = [
      '#title' => $node->get('title')->value,
      // ...
    ];

    // Set the cache so we don't need to do this work again until $node changes.
    \Drupal::cache()->set($cid, $marktwo, Cache::PERMANENT, $node->getCacheTags());

    return $marktwo;

  }

}
