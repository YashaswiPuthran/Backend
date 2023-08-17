<?php

namespace Drupal\template_module\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class.
 */
class ControllerTemplate extends ControllerBase {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructor for ControllerTemplate.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Renders the config template.
   */
  public function configTemplate() {
    $config = $this->configFactory->get('template_module.settings');
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
