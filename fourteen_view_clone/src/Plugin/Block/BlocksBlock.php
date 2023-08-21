<?php

declare(strict_types = 1);

namespace Drupal\fourteen_view_clone\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a blocks block.
 *
 * @Block(
 *   id = "fourteen_view_clone_blocks",
 *   admin_label = @Translation("blocks"),
 *   category = @Translation("Custom"),
 * )
 */
final class BlocksBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
