<?php

namespace Drupal\template_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class.
 */
class ControllerTemplate extends ControllerBase {

  /**
   * Renders the config template.
   */
  public function configTemplate() {
    $config = \Drupal::config('template_module.settings');
    $title = $config->get('title');
    $paragraph = $config->get('paragraph')['value'];
    $colorCode = $config->get('color_code');

    $template = [
      '#theme' => 'configform_template',
      '#title' => $title,
      '#paragraph' => $paragraph,
      '#color_code' => $colorCode,
    ];

    return $template;
  }

}
